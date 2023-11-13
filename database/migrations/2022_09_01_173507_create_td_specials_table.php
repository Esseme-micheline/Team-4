<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('td_specials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ue_id');
            $table->string('code', 25);
            $table->string('intitule', 50);
            $table->float('prix');
            $table->timestamps();
            $table->foreign('ue_id')
                    ->references('id')
                    ->on('ues')
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
        Schema::dropIfExists('td_specials');
    }
}
