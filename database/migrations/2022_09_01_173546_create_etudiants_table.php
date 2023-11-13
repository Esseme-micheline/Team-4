<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filiere_id');
            $table->unsignedBigInteger('niveau_id');
            $table->string('matricule', 25)->unique();
            $table->string('noms',100);
            $table->integer('telephone')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('photo')->nullable();
            $table->string('password');
            $table->timestamps();
            $table->foreign('filiere_id')
                    ->references('id')
                    ->on('filieres')
                    ->onDelete('cascade');
            $table->foreign('niveau_id')
                    ->references('id')
                    ->on('niveaux')
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
        Schema::dropIfExists('etudiants');
    }
}
