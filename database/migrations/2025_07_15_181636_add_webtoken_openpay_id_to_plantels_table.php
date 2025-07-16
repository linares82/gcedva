<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWebtokenOpenpayIdToPlantelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantels', function (Blueprint $table) {
            $table->integer('webhook_openpay_id')->unsigned()->nullable();
            $table->foreign('webhook_openpay_id')->references('id')->on('webhook_openpays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plantels', function (Blueprint $table) {
            //
        });
    }
}
