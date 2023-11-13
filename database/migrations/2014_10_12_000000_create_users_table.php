<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enseignant_id')->nullable();
            $table->unsignedBigInteger('charge_td_id')->nullable();
            $table->unsignedBigInteger('profil_id')->default(6);
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('enseignant_id')
                ->references('id')
                ->on('enseignants')
                ->onDelete('cascade');
            $table->foreign('charge_td_id')
                ->references('id')
                ->on('charge_tds')
                ->onDelete('cascade');
            $table->foreign('departement_id')
                    ->references('id')
                    ->on('departements')
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
        Schema::dropIfExists('users');
    }
}
