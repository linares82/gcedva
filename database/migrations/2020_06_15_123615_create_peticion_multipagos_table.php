<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionMultipagosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticion_multipagos', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('pago_id')->unsigned();
            $table->integer('mp_account')->unsigned();
            $table->string('mp_product');
            $table->string('mp_order');
            $table->index('mp_order');
            $table->string('mp_reference');
            $table->text('mp_node');
            $table->text('mp_concept');
            $table->decimal('mp_amount');
            $table->string('mp_customername');
            $table->integer('mp_currency');
            $table->text('mp_signature');
            $table->string('mp_urlsuccess');
            $table->string('mp_urlfailure');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('pago_id')->references('id')->on('pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('peticion_multipagos');
    }
}
