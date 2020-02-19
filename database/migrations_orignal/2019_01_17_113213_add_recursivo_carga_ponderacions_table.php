<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecursivoCargaPonderacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carga_ponderacions', function(Blueprint $table) {
            $table->integer('tiene_detalle')->default(0);
            $table->integer('padre_id')->unsigned()->default(0);
            $table->index('padre_id');
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
