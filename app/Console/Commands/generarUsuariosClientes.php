<?php

namespace App\Console\Commands;

use App\Cliente;
use App\UsuarioCliente;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class generarUsuariosClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:GenerarUsuariosClientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica Matriculas existentes en usuarios de clientes y las genera si no existen';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $matriculas=Cliente::select('clientes.id as cliente_id','clientes.matricula','clientes.mail','uc.name')
        ->leftJoin('usuario_clientes as uc', 'uc.name', 'clientes.matricula')
        //->where('clientes.matricula', 'like', '0923%')
        //->where('clientes.id',88896)
        ->whereNotNull('clientes.matricula')
        ->whereNull('clientes.deleted_at')
        ->get();
        //dd($matriculas->toArray());
        $counter=0;
        foreach($matriculas as $matricula)
        {
            if(is_null($matricula->name)){
                /*if(!is_null($matricula->mail) and $matricula<>""){
                    $matriculas_anteriores=UsuarioCliente::where('email',$matricula->mail)->get();
                    dd($matriculas_anteriores->toArray());
                    if($matriculas_anteriores->count()>0){
                        foreach($matriculas_anteriores as $matricula){
                            
                            $matricula->delete();
                        }
                    }
                    dd($matriculas_anteriores->toArray());
                }*/
                
                $input['name']=$matricula->matricula;
                $input['email']=$matricula->mail;
                $input['password']=Hash::make('123456');
                UsuarioCliente::create($input);  
                echo $matricula->matricula." - ";     
            }
        }
        
        $usuariosSinMatricula=UsuarioCliente::select('usuario_clientes.id','usuario_clientes.name','c.matricula')
        ->leftJoin('clientes as c', 'c.matricula', 'usuario_clientes.name')
        ->orderBy('usuario_clientes.name')
        ->get();

        Log::info('usuario_clientes borrados');
        foreach($usuariosSinMatricula as $usuario){
            if(is_null($usuario->matricula)){
                $u=UsuarioCliente::find($usuario->id);
                Log::info($u);
                echo $u->id."-";
                $u->delete();
            }
        }
    }
}
