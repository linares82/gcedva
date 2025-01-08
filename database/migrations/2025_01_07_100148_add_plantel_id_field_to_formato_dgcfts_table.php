<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlantelIdFieldToFormatoDgcftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formato_dgcfts', function (Blueprint $table) {
            $table->unsignedInteger('plantel_id')->nullable();
            $table->string('control_parte_fija')->nullable();
            $table->string('control_inicio')->nullable();
            $table->string('fechas_emision')->nullable();
            $table->foreign('plantel_id')->references('id')->on('plantels');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formato_dgcfts', function (Blueprint $table) {
            //
        });
    }
}
