<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dossier_id');
            $table->unsignedBigInteger('nature_id');
            $table->string('documents', 100);
            $table->boolean('etat')->default(false);
            $table->timestamps();
            $table->foreign('dossier_id')
                    ->references('id')
                    ->on('dossiers')
                    ->onDelete('cascade');
            $table->foreign('nature_id')
                    ->references('id')
                    ->on('natures')
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
        Schema::dropIfExists('documents');
    }
}
