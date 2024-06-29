<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionOpenpaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticion_openpays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pago_id')->unsigned()->nullable();
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->string('pname')->nullable();
            $table->string('plast_name')->nullable();
            $table->string('pphone_number')->nullable();
            $table->string('pemail')->nullable();
            $table->string('pmethod')->nullable();
            $table->string('pamount')->nullable();
            $table->string('pdescription')->nullable();
            $table->boolean('psend_mail')->default(false);
            $table->boolean('pconfirm')->default(false);
            $table->string('predirect_url')->nullable();
            $table->string('ppreferencia')->nullable();
            $table->string('porder_id')->nullable();
            $table->string('rid')->nullable();
            $table->string('rauthorization')->nullable();
            $table->string('rmethod')->nullable();
            $table->string('roperation_type')->nullable();
            $table->string('rtransaction_type')->nullable();
            $table->string('rstatus')->nullable();
            $table->string('rconciliated')->nullable();
            $table->datetime('rcreation_date')->nullable();
            $table->datetime('roperation_date')->nullable();
            $table->string('rdescription')->nullable();
            $table->string('rerror_message')->nullable();
            $table->string('ramount')->nullable();
            $table->string('rcurrency')->nullable();
            $table->string('rpayment_method_type')->nullable();
            $table->string('rpayment_method_url')->nullable();
            $table->string('rpayment_method_barcode_url')->nullable();
            $table->string('rpayment_method_reference')->nullable();
            $table->text('rcustomer')->nullable();
            $table->string('rorder_id')->nullable();
            $table->string('dispositivo')->nullable();
            $table->string('navegador')->nullable();
            $table->integer('contador_peticiones')->unsigned()->default(1);
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->foreign('usu_alta_id')->references('id')->on('usuario_clientes');
            $table->foreign('usu_mod_id')->references('id')->on('usuario_clientes');
            $table->foreign('pago_id')->references('id')->on('pagos');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peticion_openpay');
    }
}
