<?php

namespace App\Observers;

use App\Cliente;
use App\Hactividade;
use App\HEstatus;
use App\Seguimiento;
use App\StSeguimiento;
use Auth;
use Carbon\Carbon;

class SeguimientoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $Seguimiento;
    public function created(Seguimiento $Seguimiento)
    {
        $this->Seguimiento = $Seguimiento;
        $h = new Hactividade();

        $h->cliente_id = $this->Seguimiento->cliente_id;
        $h->seguimiento_id = $this->Seguimiento->id;
        $h->tarea = 'Seguimiento';
        $h->fecha = Carbon::now();
        $h->hora = Carbon::now();
        $h->asunto = 'Creacion';
        $h->detalle = $this->Seguimiento->stSeguimiento->name;
        $h->usu_alta_id = $this->Seguimiento->usu_alta_id;
        $h->usu_mod_id = $this->Seguimiento->usu_mod_id;

        //dd($hactividad);

        $h->save();
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(Seguimiento $Seguimiento)
    {
        /*$this->Seguimiento=$Seguimiento;
    $s=Seguimiento::find($this->Seguimiento->id);
    //dd($s->toArray());
    if($this->Seguimiento->st_seguimiento_id<>$s->st_seguimiento_id){
    $hs['seguimiento_id']=$this->Seguimiento->id;
    $hs['cliente_id']=$this->Seguimiento->cliente_id;
    $hs['st_seguimiento_id']=$this->Seguimiento->st_seguimiento_id;
    $hs['st_anterior_id']=$s->st_seguimiento_id;
    $hs['mes']=$this->Seguimiento->mes;
    $hs['usu_alta_id']=$this->Seguimiento->usu_alta_id;
    $hs['usu_mod_id']=$this->Seguimiento->usu_mod_id;
    $hs['created_at']=$this->Seguimiento->created_at;
    $hs['updated_at']=$this->Seguimiento->updated_at;
    $hs['deleted_at']=$this->Seguimiento->deleted_at;
    $h=new HsSeguimiento();
    $h->save($hs);
    }
     *
     */
    }

    public function updating(Seguimiento $seguimiento)
    {
        $this->seguimiento = $seguimiento;
        $vseguimiento = Seguimiento::find($seguimiento->id);
        if ($vseguimiento->st_seguimiento_id != $this->seguimiento->st_seguimiento_id) {
            $st_seguimiento = StSeguimiento::find($this->seguimiento->st_seguimiento_id);
            $input['tabla'] = 'seguimientos';
            $input['cliente_id'] = $vseguimiento->cliente_id;
            $input['seguimiento_id'] = $vseguimiento->id;
            $input['estatus'] = $st_seguimiento->name;
            $input['estatus_id'] = $st_seguimiento->id;
            $input['fecha'] = Date('Y-m-d');
            $input['usu_alta_id'] = Auth::user()->id;
            $input['usu_mod_id'] = Auth::user()->id;
            HEstatus::create($input);
        }
    }

    public function updated(Seguimiento $Seguimiento)
    {
        $this->Seguimiento = $Seguimiento;
        $h = new Hactividade();

        $h->cliente_id = $this->Seguimiento->cliente_id;
        $h->seguimiento_id = $this->Seguimiento->id;
        $h->tarea = 'Seguimiento';
        $h->fecha = Carbon::now();
        $h->hora = Carbon::now();
        $h->asunto = 'Cambio estatus ';
        $h->detalle = $this->Seguimiento->stSeguimiento->name;
        $h->usu_alta_id = $this->Seguimiento->usu_alta_id;
        $h->usu_mod_id = $this->Seguimiento->usu_mod_id;

        //dd($hactividad);

        $h->save();

        if ($this->Seguimiento->st_seguimiento_id == 3) {
            $cliente = Cliente::find($this->Seguimiento->cliente_id);
            $cliente->st_cliente_id = 19;
            $cliente->save();
        }
    }

}
