<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->tinyInteger('transferencia');
            $table->decimal('valor', 10, 2);
            $table->string('remetente')->default("sem remetente");
            $table->unsignedBigInteger('id_pessoa');
            $table->timestamps();

            $table->foreign('id_pessoa')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credito');
    }
}
