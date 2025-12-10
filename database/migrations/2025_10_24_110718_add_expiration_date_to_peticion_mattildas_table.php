<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpirationDateToPeticionMattildasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peticion_mattildas', function (Blueprint $table) {
            $table->string('expiration_date_unix')->nullable();
            $table->dateTime('expiration_date_human')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peticion_mattildas', function (Blueprint $table) {
            //
        });
    }
}
