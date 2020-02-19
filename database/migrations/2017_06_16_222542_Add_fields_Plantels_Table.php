<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPlantelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantels', function(Blueprint $table) {
            $table->integer('tpo_plantel_id')->unsigned();
            $table->string('rvoe')->nullable();
            $table->string('cct')->nullable();
            $table->string('calle')->nullable();
            $table->string('no_int')->nullable();
            $table->string('no_ext')->nullable();
            $table->string('colonia')->nullable();
            $table->string('cp')->nullable();
            $table->string('municipio')->nullable();
            $table->string('estado')->nullable();
            $table->integer('meta_venta')->nullable();
            $table->string('cve_plantel')->nullable()->nullable();
            $table->integer('cns_empleado')->unsigned()->nullable();
            $table->integer('cns_alumno')->unsigned()->nullable();
            $table->integer('meta_total')->unsigned()->nullable();
            $table->integer('st_plantel_id')->unsigned();
            $table->foreign('tpo_plantel_id')->references('id')->on('tpo_plantels');
            $table->index('st_plantel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plantels', function(Blueprint $table) {
        $table->dropColumn('tpo_plantel_id');
        $table->dropColumn('rvoe');
        $table->dropColumn('cct');
        $table->dropColumn('calle');
        $table->dropColumn('no_int');
        $table->dropColumn('no_ext');
        $table->dropColumn('colonia');
        $table->dropColumn('cp');
        $table->dropColumn('municipio');
        $table->dropColumn('estado');
        $table->dropIndex('plantels_tpo_plantel_id_foreign');
        $table->dropColumn('tpo_plantel_id');
        });
    }
}
