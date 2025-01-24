<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepGrupoSepMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sep_grupo_sep_materia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sep_grupo_id')->unsigned()->nullable();
            $table->integer('sep_materia_id')->unsigned()->nullable();
            $table->string('grado')->nullable();
            $table->string('duracion_horas')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('sep_materia_id')->references('id')->on('sep_materias');
            $table->foreign('sep_grupo_id')->references('id')->on('sep_grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materia_sep_grupo_sep_materia');
    }
}
