<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTabajoToVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vinculacions', function (Blueprint $table) {
            $table->string('jefe_directo')->nullable();
            $table->integer('bnd_busca_trabajo')->nullable();
            $table->string('tel_fijo_actualizado')->nullable();
            $table->string('mail_actualizado')->nullable();
            $table->integer('bnd_requiere_empleo')->nullable();
            $table->integer('bnd_cv_actualizado')->nullable();
            $table->string('empresa')->nullable();
            $table->string('direccion')->nullable();
            $table->string('jefe_directo_trabajo')->nullable();
            $table->string('tel_fijo_trabajo')->nullable();
            $table->string('puesto_trabajo')->nullable();
            $table->integer('sueldo_id')->nullable();
            $table->string('empresas_interes')->nullable();
            $table->string('areas_interes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vinculacions', function (Blueprint $table) {
            //
        });
    }
}
