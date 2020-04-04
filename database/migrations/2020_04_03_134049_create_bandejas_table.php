<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandejasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandejas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('carpeta');
            $table->bigInteger('uid');
            $table->index('uid');
            $table->string('from');
            $table->index('from');
            $table->string('to');
            $table->index('to');
            $table->string('asunto');
            $table->string('adjuntos');
            $table->datetime('fecha');
            $table->longText('mensaje');
            $table->integer('bnd_leido')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bandejas');
    }

}
