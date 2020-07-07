<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBndConciliacionToSuccessMultipagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('success_multipagos', function (Blueprint $table) {
            $table->integer('conciliacion_multi_detalle_id')->unsigned()->nullable();
            $table->index('conciliacion_multi_detalle_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('success_multipagos', function (Blueprint $table) {
            //
        });
    }
}
