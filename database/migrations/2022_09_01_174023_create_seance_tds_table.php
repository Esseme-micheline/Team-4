<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeanceTdsTable extends Migration
{
    /**sceance
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seance_tds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupe_td_id');
            $table->string('intitule', 100);
            $table->mediumText('description');
            $table->date('date');
            $table->string('heureDebut', 10);
            $table->string('heureFin', 10);
            $table->string('salle', 20);
            $table->timestamps();
            $table->foreign('groupe_td_id')
                    ->references('id')
                    ->on('groupe_tds')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seance_tds');
    }
}
