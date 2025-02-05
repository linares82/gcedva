<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBndSatisfactorioToFormatoDgcftDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formato_dgcft_detalles', function (Blueprint $table) {
            $table->integer('bnd_satisfactorio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formato_dgcft_detalles', function (Blueprint $table) {
            //
        });
    }
}
