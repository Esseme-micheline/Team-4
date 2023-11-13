<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id')->unique();
            $table->unsignedBigInteger('encadreur_id');
            $table->unsignedBigInteger('coEncadreur_id')->nullable();
            $table->unsignedBigInteger('cooEncadreur_id')->nullable();
            $table->unsignedBigInteger('filiere_id');
            $table->unsignedBigInteger('niveau_id');
            $table->unsignedBigInteger('unite_recherche_id');
            $table->unsignedBigInteger('annee_id');
            $table->unsignedBigInteger('president_jury_id')->nullable();
            $table->unsignedBigInteger('examinateur_jury_id')->nullable();
            $table->unsignedBigInteger('coexaminateur_jury_id')->nullable();
            $table->string('reference', 50)->nullable();
            $table->string('theme_recherche', 150);
            $table->integer('note_lecture_Pr')->nullable();
            $table->integer('note_lecture_En')->nullable();
            $table->integer('note_lecture_Ex')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('etat')->default(true);
            $table->string('observation')->nullable();
            $table->integer('uid')->nullable();
            $table->timestamps();
            $table->foreign('etudiant_id')
                    ->references('id')
                    ->on('etudiants')
                    ->onDelete('cascade');
            $table->foreign('filiere_id')
                    ->references('id')
                    ->on('filieres')
                    ->onDelete('cascade');
            $table->foreign('niveau_id')
                    ->references('id')
                    ->on('niveaux')
                    ->onDelete('cascade');
            $table->foreign('unite_recherche_id')
                    ->references('id')
                    ->on('unite_recherches')
                    ->onDelete('cascade');
            $table->foreign('annee_id')
                    ->references('id')
                    ->on('annees')
                    ->onDelete('cascade');
            $table->foreign('encadreur_id')
                    ->references('id')
                    ->on('juries')
                    ->onDelete('cascade');
            $table->foreign('coEncadreur_id')
                    ->references('id')
                    ->on('juries')
                    ->onDelete('cascade');
            $table->foreign('cooEncadreur_id')
                    ->references('id')
                    ->on('juries')
                    ->onDelete('cascade');
            $table->foreign('president_jury_id')
                    ->references('id')
                    ->on('juries')
                    ->onDelete('cascade');
            $table->foreign('examinateur_jury_id')
                    ->references('id')
                    ->on('juries')
                    ->onDelete('cascade');
            $table->foreign('coexaminateur_jury_id')
                    ->references('id')
                    ->on('juries')
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
        Schema::dropIfExists('archives');
    }
}
