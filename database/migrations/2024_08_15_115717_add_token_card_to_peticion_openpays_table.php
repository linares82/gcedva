<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenCardToPeticionOpenpaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peticion_openpays', function (Blueprint $table) {
            $table->boolean('use_3d_secure')->nullable();
            $table->string('token_3d_secure')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peticion_openpays', function (Blueprint $table) {
            //
        });
    }
}
