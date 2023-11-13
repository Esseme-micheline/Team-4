<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantGroupeTdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiant_groupe_td', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('groupe_td_id');
            $table->timestamps();
            $table->foreign('etudiant_id')
                    ->references('id')
                    ->on('etudiants')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('etudiant_groupe_td');
    }
}
