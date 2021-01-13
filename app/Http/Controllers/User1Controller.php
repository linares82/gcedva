<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;

class User1Controller extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    private $apiToken;
    public function __construct()
    {
        $this->apiToken = uniqid(base64_encode(str_random(60)));
    }

    public function apiLoginCliente(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $usuario = User::where('email', $data['email'])->first();
        //dd($data);
        if (is_null($usuario)) {
            return response()->json(['error' => 'Correo no encontrado'], 405);
        }

        $cliente = Cliente::find($data['cliente']);
        if (is_null($cliente)) {
            return response()->json(['error' => 'Cliente no encontrado'], 405);
        }

        if (password_verify($data['password'], $usuario[0]->password)) {
            $cliente->api_token = $this->apiToken;
            $cliente->update();

            $array = array(
                //"id" => $usuario[0]->id,
                "api_token" => $cliente->api_token
            );
            return response()->json($array, 201);
        } else {
            return response()->json(['error' => 'Usuario no autorizado'], 401, []);
        }
    }

    public function apiLoginUsuario(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $usuario = User::where('email', $data['email'])->first();
        //dd($data);
        if (is_null($usuario)) {
            return response()->json(['error' => 'Correo no encontrado'], 405);
        }

        if (password_verify($data['password'], $usuario->password)) {
            if ($usuario->api_token == "") {
                $usuario->api_token = $this->apiToken;
                $usuario->save();
            }

            $array = array(
                //"id" => $usuario[0]->id,
                "api_token" => $usuario->api_token
            );
            return response()->json($array, 201);
        } else {
            return response()->json(['error' => 'Usuario no autorizado'], 401, []);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function editPerfil($id, User $user)
    {
        $user = $user->find($id);
        return view('auth.perfil', compact('user'));
    }

    public function updatePerfil(User $user, Request $request)
    {
        //update data
        $input = $request->all();
        //dd($input);
        $user = $user->find($input['id']);
        $user->email = $input['email'];
        $user->id_telegram = $input['id_telegram'];
        if (isset($input['password1'])) {
            $user->password = Hash::make($input['password1']);
        }
        $user->update();
        return redirect()->route('home')->with('message', 'Item updated successfully.');
    }

    public function index(Request $request)
	{
        $input=$request->all();
		$r=User::where('id', '<>', '0');
		if(isset($input['name']) and $input['name']<>""){
			$r->where('name', 'like', "%".$input['name']."%");
		}
        if(isset($input['email']) and $input['email']<>""){
			$r->where('email', 'like', "%".$input['email']."%");
		}
                /*$entity=Entity::find(Auth::user()->entity_id);
                if (Auth::user()->canDo('filtro_entity') or $entity->filtred_by_entity==1) {
                    //dd('si puede');
                    $r->where('entity_id', '=', Auth::user()->entity_id);
                }*/
		
		$users = $r->paginate(100);
		//$users = User::paginate(25);

        return view('users.index', compact('users'));
	}    
}
