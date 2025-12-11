<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuditoriaEmpleadoToInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscripcions', function (Blueprint $table) {
            $table->unsignedInteger('emp_alta_id')->nullable()->after('usu_mod_id');
            $table->unsignedInteger('emp_mod_id')->nullable()->after('emp_alta_id');
            $table->unsignedInteger('emp_delete_id')->nullable()->after('emp_mod_id');

            $table->foreign('emp_alta_id')->references('id')->on('empleados');
            $table->foreign('emp_mod_id')->references('id')->on('empleados');
            $table->foreign('emp_delete_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            //
        });
    }
}
