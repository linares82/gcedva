<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCertToTpoExamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tpo_examens', function (Blueprint $table) {
            $table->integer('sep_cert_observacion_id')->unsigned()->nullable();
            $table->foreign('sep_cert_observacion_id')->references('id')->on('sep_cert_observacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tpo_examens', function (Blueprint $table) {
            //
        });
    }
}
