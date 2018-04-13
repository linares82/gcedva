<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanPagoLnReglaRecargo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_pago_ln_regla_recargo', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_pago_ln_id')->unsigned();
            $table->integer('regla_recargo_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
