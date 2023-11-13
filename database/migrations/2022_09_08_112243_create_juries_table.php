<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juries', function (Blueprint $table) {
            $table->id();
            $table->string('noms', 100);
            $table->string('grade', 50)->nullable();
            $table->integer('telephone')->nullable();
            $table->string('email', 100)->unique();
            $table->string('universite', 60)->nullable();
            $table->string('faculte', 60)->nullable();
            $table->string('departement', 60)->nullable();
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
        Schema::dropIfExists('juries');
    }
}
