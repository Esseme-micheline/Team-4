<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filiere_id');
            $table->unsignedBigInteger('niveau_id');
            $table->string('code', 25)->unique();
            $table->string('intitule', 100);
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
        Schema::dropIfExists('ues');
    }
}
