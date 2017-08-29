<?php

namespace App\Observers;

use App\Seguimiento;
use App\Cliente;
use App\Plantel;

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
        //dd("hi fil");
        $this->Seguimiento=$Seguimiento;
        if($this->seguimiento->st_seguimiento_id==2){
            
        }
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function updating(Seguimiento $Seguimiento)
    {
        //
    }
}