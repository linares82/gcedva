<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtiquetasTicketTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiquetas_ticket_ticket', function (Blueprint $table) {
            $table->bigInteger('etiquetas_ticket_id');
            $table->index('etiquetas_ticket_id');
            $table->bigInteger('ticket_id');
            $table->index('ticket_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etiquetas_ticket_ticket');
    }
}
