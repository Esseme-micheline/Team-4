<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('etat_id');
            $table->string('acteur', 50);
            $table->string('objet');
            $table->timestamps();
            $table->foreign('etudiant_id')
                    ->references('id')
                    ->on('etudiants')
                    ->onDelete('cascade');
            $table->foreign('etat_id')
                    ->references('id')
                    ->on('etats')
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
        Schema::dropIfExists('evolutions');
    }
}
