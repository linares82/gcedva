<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirResPlantelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantels', function(Blueprint $table) {
            $table->integer('director_id')->unsigned()->default(0);
            $table->integer('responsable_id')->unsigned()->default(0);
            $table->foreign('director_id')->references('id')->on('empleados');
            $table->foreign('responsable_id')->references('id')->on('empleados');
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
