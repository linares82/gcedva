<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditForeignToVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vinculacions', function (Blueprint $table) {
            $table->dropForeign('vinculacions_empresa_id_foreign');
            $table->dropColumn('empresa_id');
            $table->integer('empresas_vinculacion_id')->unsigned()->nullable();
            $table->foreign('empresas_vinculacion_id')->references('id')->on('empresas_vinculacions');
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
