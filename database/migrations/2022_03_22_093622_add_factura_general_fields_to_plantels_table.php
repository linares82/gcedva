<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturaGeneralFieldsToPlantelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantels', function (Blueprint $table) {
            $table->string('fact_global_id_cuenta')->nullable();
            $table->string('fact_global_pass_cuenta')->nullable();
            $table->string('fact_global_id_usu')->nullable();
            $table->string('fact_global_pass_usu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plantels', function (Blueprint $table) {
            //
        });
    }
}
