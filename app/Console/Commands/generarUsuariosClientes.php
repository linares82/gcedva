<?php

namespace App\Console\Commands;

use App\Cliente;
use App\UsuarioCliente;
use Illuminate\Console\Command;
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
        $matriculas=Cliente::select('clientes.id as cliente_id','clientes.matricula','clientes.mail',
        'uc.name')
        ->leftJoin('usuario_clientes as uc', 'uc.name', 'clientes.matricula')
        ->where('clientes.matricula', 'like', '0923%')
        ->where('clientes.id',88896)
        ->whereNull('clientes.deleted_at')
        ->get();

        $counter=0;
        foreach($matriculas as $matricula)
        {
            if(is_null($matricula->name)){
                $input['name']=$matricula->matricula;
                $input['email']=$matricula->mail;
                $input['password']=Hash::make('123456');
                UsuarioCliente::create($input);       
            }
        }
        
    }
}
