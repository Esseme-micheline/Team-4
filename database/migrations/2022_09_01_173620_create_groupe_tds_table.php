<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupeTdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupe_tds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('td_id')->nullable();
            $table->unsignedBigInteger('td_special_id')->nullable();
            $table->unsignedBigInteger('charge_td_id');
            $table->string('intitule', 100);
            $table->string('periode', 100);
            $table->integer('capacite');
            $table->string('salle', 20);
            $table->timestamps();
            $table->foreign('td_id')
                    ->references('id')
                    ->on('tds')
                    ->onDelete('cascade');
            $table->foreign('td_special_id')
                    ->references('id')
                    ->on('td_specials')
                    ->onDelete('cascade');
            $table->foreign('charge_td_id')
                    ->references('id')
                    ->on('charge_tds')
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
        Schema::dropIfExists('groupe_tds');
    }
}
