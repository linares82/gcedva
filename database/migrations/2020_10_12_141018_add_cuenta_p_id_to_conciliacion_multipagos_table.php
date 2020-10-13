<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCuentaPIdToConciliacionMultipagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conciliacion_multipagos', function (Blueprint $table) {
            $table->integer('cuenta_p_id')->unsigned()->nullable();
            $table->index('cuenta_p_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conciliacion_multipagos', function (Blueprint $table) {
            //
        });
    }
}
