<?php namespace App\Http\Controllers;

use Auth;
use App\User;

use DateTime;
use App\Ticket;
use App\Http\Requests;
use App\ImagenesTicket;
use App\EtiquetasTicket;
use Illuminate\Http\Request;
use App\Http\Requests\createTicket;
use App\Http\Requests\updateTicket;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\LaravelTelegramNotification;
use Intervention\Image\ImageManagerStatic as Image;
use App\Notifications\LaravelTelegramImgNotification;

class TicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tickets = Ticket::getAllData($request);
		$users=User::pluck('name','id');
		$users->prepend('Seleccionar Opcion',0);
		return view('tickets.index', compact('tickets','users'))->with( 'list', Ticket::getListFromAllRelationApps());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$etiquetas=EtiquetasTicket::pluck('name','id');
		$users=User::pluck('name','id');
		
		return view('tickets.create', compact('etiquetas','users'))
			->with( 'list', Ticket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTicket $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$ticket=Ticket::create( $input );
		$ticket->etiquetas()->sync($input['etiquetas']);

		$msg="Ticket: ".$ticket->id." Nombre Corto:".$ticket->nombre_corto;

		$this->toTelegram($ticket->usu_alta_id, $ticket->asignado_a, $msg);

		return redirect()->route('tickets.show',$ticket->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $message=0, Ticket $ticket)
	{
		$ticket=$ticket->find($id);
		//dd($message);
		return view('tickets.show', compact('ticket', 'message'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Ticket $ticket)
	{
		$ticket=$ticket->find($id);
		$etiquetas=EtiquetasTicket::pluck('name','id');
		$users=User::pluck('name','id');
		return view('tickets.edit', compact('ticket', 'etiquetas','users'))
			->with( 'list', Ticket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Ticket $ticket)
	{
		$ticket=$ticket->find($id);
		return view('tickets.duplicate', compact('ticket'))
			->with( 'list', Ticket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Ticket $ticket, updateTicket $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ticket=$ticket->find($id);
		$ticket->update( $input );
		$ticket->etiquetas()->sync($input['etiquetas']);

		return redirect()->route('tickets.show',$ticket->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Ticket $ticket)
	{
		$ticket=$ticket->find($id);
		$ticket->delete();

		return redirect()->route('tickets.index')->with('message', 'Registro Borrado.');
	}

	public function toTelegram($from, $to, $msg){
		$From=User::find($from);
		$To=User::find($to);
		
		$From->notify(new LaravelTelegramNotification([
			'text' => $msg,
		]));
		$To->notify(new LaravelTelegramNotification([
			'text' => $msg,
		]));
	}

	public function toTelegramImg($from, $to, $msg, $img){
		
		$From=User::find($from);
		$To=User::find($to);
		
		$From->notify(new LaravelTelegramImgNotification([
			'caption' => $msg,
			'photo' => $img
		]));
		$To->notify(new LaravelTelegramImgNotification([
			'caption' => $msg,
			'photo'=> $img
		]));
	}


	public function cargaArchivoCorreo(Request $request)
        {
		//dd($request);
		if ($request->hasFile('file1')){
			$file1    = $request->file('file1');
			$now = new DateTime();
			$nombre     = $request['ticket']."_".$now->format('Ymdhmiv').".".$file1->guessExtension();
	
			$ruta=storage_path()."/app/public/telegram_tickets/".$nombre;
	
			Image::make($file1->getRealPath())
				->resize(1100, null, function ($constraint){ 
					$constraint->aspectRatio();
				})
				->save($ruta,40);
				
			$ticket=Ticket::find($request['ticket']);
				
			$imagenTicket=New ImagenesTicket();
			$imagenTicket->ticket_id=$ticket->id;
			$imagenTicket->nombre=$nombre;
			$imagenTicket->usu_alta_id=Auth::user()->id;
			$imagenTicket->usu_mod_id=Auth::user()->id;
			$imagenTicket->save();

			$msg="Ticket: ".$ticket->id." Se ha cargado una imagen";

			$img=asset('storage/telegram_tickets/'.$nombre);	

			$this->toTelegram($ticket->usu_mod_id, $ticket->asignado_a, $msg, $img);	

			return redirect()->route('tickets.show', array($ticket->id,"Mensaje Enviado"));
		}

    }

}
