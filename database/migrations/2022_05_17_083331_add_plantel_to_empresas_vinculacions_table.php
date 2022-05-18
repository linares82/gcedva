<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlantelToEmpresasVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_vinculacions', function (Blueprint $table) {
            $table->integer('plantel_id')->unsigned()->nullable();
            $table->string('sucursal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_cinculacions', function (Blueprint $table) {
            //
        });
    }
}
