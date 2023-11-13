<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dossier_id');
            $table->unsignedBigInteger('encadreur_id')->nullable();
            $table->unsignedBigInteger('coEncadreur_id')->nullable();
            $table->unsignedBigInteger('cooEncadreur_id')->nullable();
            $table->string('theme', 100)->nullable();
            $table->boolean('etat')->default(false);
            $table->timestamps();
            $table->foreign('dossier_id')
                    ->references('id')
                    ->on('dossiers')
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('changements');
    }
}
