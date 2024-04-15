<?php

namespace App\Http\Controllers;

use App\Bandeja;
use App\Correo;
use App\Http\Controllers\Controller;
use App\Http\Requests\createCorreo;
use App\Http\Requests\updateCorreo;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;
use Storage;
use Webklex\IMAP\Client;

class CorreosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $correos = Correo::getAllData($request);
        return view('correos.index', compact('correos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        //dd($vUltimoCorte);

        return view('correos.create')
            ->with('list', Correo::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createCorreo $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Correo::create($input);

        return redirect()->route('correos.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Correo $correo)
    {
        $correo = $correo->find($id);
        return view('correos.show', compact('correo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Correo $correo)
    {
        $correo = $correo->find($id);
        return view('correos.edit', compact('correo'))
            ->with('list', Correo::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Correo $correo)
    {
        $correo = $correo->find($id);
        return view('correos.duplicate', compact('correo'))
            ->with('list', Correo::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Correo $correo, updateCorreo $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $correo = $correo->find($id);
        $correo->update($input);

        return redirect()->route('correos.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Correo $correo)
    {
        $correo = $correo->find($id);
        $correo->delete();

        return redirect()->route('correos.index')->with('message', 'Registro Borrado.');
    }

    public function redactar($mail = "Sin correo", $nombre = "", $empresa = 0, $msj = "")
    {
        $mail = $mail;
        $nombre = $nombre;
        $empresa = $empresa;
        $msj = $msj;
        $from = Auth::user()->email;
        return view('correos.version2.frm_envio', compact('mail', 'nombre', 'empresa', 'msj', 'from'));
    }

    public function cargaArchivoCorreo(Request $request)
    {
        $nombre = "";
        if ($request->hasFile('file1')) {
            $file = $request->file('file1');
            $extension = $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $r = Storage::disk('tmp_correos')->put($nombre, \File::get($file));
        } else {
            return "no";
        }

        if ($r) {
            return $nombre;
        } else {
            return "Error vuelva a intentarlo";
        }
    }

    public function enviarCorreo(Request $request)
    {
        //dd($request->all());
        $pathToFile = array();
        $containfile = false;
        $paths = array();
        if ($request->hasFile('file1')) {
            $containfile = true;
            $file = $request->file('file1');
            $nombre = $file->getClientOriginalName();
            $pathToFile = storage_path('app') . "/tmp_correos/" . $nombre;
            array_push($paths, $pathToFile);
        }
        if ($request->hasFile('file2')) {
            $containfile = true;
            $file = $request->file('file2');
            $nombre = $file->getClientOriginalName();
            $pathToFile = storage_path('app') . "/tmp_correos/" . $nombre;
            array_push($paths, $pathToFile);
        }
        if ($request->hasFile('file3')) {
            $containfile = true;
            $file = $request->file('file3');
            $nombre = $file->getClientOriginalName();
            $pathToFile = storage_path('app') . "/tmp_correos/" . $nombre;
            array_push($paths, $pathToFile);
        }
        /*

        if(isset($request->input("persona_bnd"))){
        $cli=Cliente::where('mail', '=', $request->input("persona_bnd"))->first();
        }
         */
        $f = $request->all();
        //dd($f);
        $destinatario = $request->input("destinatario");
        $n = $request->input("nombre");
        $asunto = $request->input("asunto");
        $contenido = $request->input("contenido_mail");
        $from = $request->input("from");

        //dd(env('MAIL_FROM_ADDRESS'));

        $data = array('contenido' => $contenido, 'nombre' => $n, 'correo' => $from);
        $r = \Mail::send('correos.version2.correo_individual', $data, function ($message)
             use ($asunto, $destinatario, $containfile, $paths, $n, $from) {
                $message->from(env('MAIL_FROM_ADDRESS','hola@grupocedva.com'), env('MAIL_FROM_NAME','Grupo CEDVA'));
                $message->to($destinatario, $n)->subject($asunto);
                $message->replyTo($from);
                if ($containfile) {
                    foreach ($paths as $path) {
                        //dd($path);
                        $message->attach($path);
                    }
                }
            });
        /*
        if(isset($f['empresa_bnd']) and $f['empresa_bnd']==1){
        $e=Empresa::where('correo1', '=', $destinatario)->first();
        //dd($e->toArray());
        $clientes=Cliente::where('empresa_id', '=', $e->id)->get();
        //dd($clientes->toArray());
        foreach($clientes as $c){
        //dd($c);
        $data = array('contenido' => $contenido, 'nombre' => $c->nombre);
        $r = \Mail::send('correos.version2.correo_individual', $data, function ($message)
        use ($asunto, $containfile, $pathToFile, $c) {
        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $message->to($c->mail, $c->nombre)->subject($asunto);
        $message->replyTo($from);
        if ($containfile) {
        $message->attach($pathToFile);
        }
        });
        }
        }*/
        //dd($r);
        //if ($r) {
        if ($containfile) {
            Storage::disk('local')->delete($nombre);
        }
        return view("correos.version2.msj_correcto")->with("msj", "Correo enviado correctamente");
        /*} else {
    return view("correos.version2.msj_rechazado")->with("msj", "Se presentÃ³ un error vuelva a intentarlo");
    }*/
    }

    public function bandeja(Request $request)
    {
        //dd('fil');
        $datos = $request->all();
        //dd($datos);
        /*$oClient = new Client([
        'host' => 'mail.grcmexico.com.mx',
        'port' => 143,
        'encryption' => false,
        'validate_cert' => false,
        'username' => 'filprb@grcmexico.com.mx',
        'password' => 'fil2848aztec.',
        'protocol' => 'imap',
        ]);*/
        /*
        $oClient = new Client([
        'host' => 'imap.gmail.com',
        'port' => 993,
        'encryption' => 'ssl',
        'validate_cert' => true,
        'username' => 'linares82@gmail.com',
        'password' => 'fil2848aztec',
        'protocol' => 'imap',
        ]);*/
        $oClient = new Client([
            'host' => 'imap-mail.outlook.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => 'dreikdream00@hotmail.com',
            'password' => 'aztec2848fil',
            'protocol' => 'imap',
        ]);
        $utf = 'utf-8';
        if (is_integer(strpos($oClient->username, 'hotmail.com'))) {
            $utf = null;
        }

        $oClient->connect();
        $aFolder = $oClient->getFolders();
        //dd($aFolder);
        if (isset($datos['carpeta'])) {
            $oFolder = $oClient->getFolder($datos['carpeta']);
        } else {
            /*foreach ($aFolder as $oFolder) {
            if ($oFolder->name == 'Baan') {
            $datos['carpeta'] = $oFolder->name;
            //dd($datos);
            break;
            }

            }*/
            $datos['carpeta'] = 'Inbox';
            $oFolder = $oClient->getFolder($datos['carpeta']);
        }
        //dd($utf);
        //dd($oFolder->query()->unseen()->get());

        $bandejas = Bandeja::where('from', $datos['mail_from'])
            ->where('to', $datos['mail_to'])
            ->where('carpeta', $datos['carpeta'])
            ->count();
        //dd($bandejas);
        //$aMessage = $oFolder->messages()->all()->get();

        if ($bandejas == 0) {
            $aMessage = $oFolder->query($utf)->from($datos['mail_from'])->since(Carbon::now()->subDays(15))->get();

            $aMessage_count = $aMessage->count();
            if ($aMessage_count > 0) {
                foreach ($aMessage as $oMessage) {
                    $input['carpeta'] = $datos['carpeta'];
                    $input['uid'] = $oMessage->getUid();
                    $input['from'] = $oMessage->getFrom()[0]->mail;
                    $input['to'] = $oMessage->getTo()[0]->mail;
                    $input['asunto'] = $oMessage->getSubject();
                    $input['adjuntos'] = $oMessage->getAttachments()->count() > 0 ? 'SI' : 'NO';
                    $input['fecha'] = $oMessage->date->toDateTimeString();
                    $input['mensaje'] = $oMessage->getHTMLBody();
                    $input['bnd_leido'] = 0;
                    $input['usu_alta_id'] = 0;
                    $input['usu_mod_id'] = 0;
                    Bandeja::create($input);
                }
            }
        } else {
            $aMessage = $oFolder->query()->from($datos['mail_from'])->since(Carbon::now()->subDays(15))->unseen()->get();
            $aMessage_count = $aMessage->count();
            if ($aMessage_count > 0) {
                foreach ($aMessage as $oMessage) {
                    $input['carpeta'] = $datos['carpeta'];
                    $input['uid'] = $oMessage->getUid();
                    $input['from'] = $oMessage->getFrom()[0]->mail;
                    $input['to'] = $oMessage->getTo()[0]->mail;
                    $input['asunto'] = $oMessage->getSubject();
                    $input['adjuntos'] = $oMessage->getAttachments()->count() > 0 ? 'SI' : 'NO';
                    $input['fecha'] = $oMessage->date->toDateTimeString();
                    $input['mensaje'] = $oMessage->getHTMLBody();
                    $input['bnd_leido'] = 0;
                    $input['usu_alta_id'] = 0;
                    $input['usu_mod_id'] = 0;
                    Bandeja::create($input);
                }
            }
        }
        $aMessage = $aMessage->paginate($perPage = 20, $page = null, $pageName = 'imap_blade_example');
        //dd($aMessage);

        $bandejas = Bandeja::where('from', $datos['mail_from'])
            ->where('to', $datos['mail_to'])
            ->where('carpeta', $datos['carpeta'])
            ->orderBy('fecha', 'desc')
            ->get();

        //dd($bandejas->toArray());
        return view('correos.bandeja', compact('aFolder', 'aMessage'));
    }
}
