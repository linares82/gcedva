<?php namespace App\Http\Controllers;

use Auth;
use App\User;

use DateTime;
use App\Ticket;
use App\AvancesTicket;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\ImagenesAvancesTicket;
use App\Http\Controllers\Controller;
use App\Http\Requests\createAvancesTicket;
use App\Http\Requests\updateAvancesTicket;
use App\Notifications\LaravelTelegramNotification;
use Intervention\Image\ImageManagerStatic as Image;

class AvancesTicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$avancesTickets = AvancesTicket::getAllData($request);

		return view('avancesTickets.index', compact('avancesTickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$datos=$request->all();
		$ticket=Ticket::find($datos['ticket']);
		return view('avancesTickets.create', compact('ticket'))
			->with( 'list', AvancesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAvancesTicket $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$avance=AvancesTicket::create( $input );
		$ticket=Ticket::find($avance->ticket_id);
		$ticket->asignado_a=$avance->asignado_a;
		$ticket->st_ticket_id=$avance->st_ticket_id;
		$ticket->save();

		$msg="Ticket: ".$ticket->id."-".$avance->id." Detalle:".$avance->detalle;

		$this->toTelegram($ticket->usu_alta_id, $avance->asignado_a, $msg);

		return redirect()->route('tickets.show', $avance->ticket_id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AvancesTicket $avancesTicket, $message)
	{
		$avancesTicket=$avancesTicket->find($id);
		return view('avancesTickets.show', compact('avancesTicket', $message));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AvancesTicket $avancesTicket)
	{
		$avancesTicket=$avancesTicket->find($id);
		return view('avancesTickets.edit', compact('avancesTicket'))
			->with( 'list', AvancesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AvancesTicket $avancesTicket)
	{
		$avancesTicket=$avancesTicket->find($id);
		return view('avancesTickets.duplicate', compact('avancesTicket'))
			->with( 'list', AvancesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, AvancesTicket $avancesTicket, updateAvancesTicket $request)
	{
		$input = $request->all();
		//dd($input);
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$avancesTicket=$avancesTicket->find($id);
		$avancesTicket->update( $input );

		$ticket=Ticket::find($avancesTicket->ticket_id);
		$ticket->asignado_a=$avancesTicket->asignado_a;
		$ticket->st_ticket_id=$avancesTicket->st_ticket_id;
		$ticket->save();

		return redirect()->route('tickets.show',$avancesTicket->ticket_id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,AvancesTicket $avancesTicket)
	{
		$avancesTicket=$avancesTicket->find($id);
		$avancesTicket->delete();

		return redirect()->route('avancesTickets.index');
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

	public function cargaArchivoCorreo(Request $request)
    {
		//dd($request);
		if ($request->hasFile('file1')){
			$avancesTicket=AvancesTicket::find($request['avance']);
			$file1    = $request->file('file1');
			$now = new DateTime();
			$nombre     = $avancesTicket->ticket_id."_".$avancesTicket->id."_".$now->format('Ymdhmiv').".".$file1->guessExtension();
	
			$ruta=storage_path()."/app/public/telegram_tickets/".$nombre;
	
			Image::make($file1->getRealPath())
				->resize(1100, null, function ($constraint){ 
					$constraint->aspectRatio();
				})
				->save($ruta,40);
				
			$imagenAvanceTicket=New ImagenesAvancesTicket();
			$imagenAvanceTicket->avances_ticket_id=$avancesTicket->id;
			$imagenAvanceTicket->nombre=$nombre;
			$imagenAvanceTicket->usu_alta_id=Auth::user()->id;
			$imagenAvanceTicket->usu_mod_id=Auth::user()->id;
			//dd($imagenAvanceTicket);
			$imagenAvanceTicket->save();
			$ticket=Ticket::find($avancesTicket->ticket_id);
						
			$msg="Ticket: ".$avancesTicket->ticket_id."-".$avancesTicket->id." Se ha cargado una Imagen";

			$this->toTelegram($ticket->usu_alta_id, $avancesTicket->asignado_a, 
									$msg);	
			return redirect()->route('tickets.show', array($avancesTicket->ticket_id,"Mensaje Enviado"));						
		}
		
    }
}
