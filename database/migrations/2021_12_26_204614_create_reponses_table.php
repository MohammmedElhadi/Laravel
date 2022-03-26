<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            $table->foreignId('demande_id')->constrained()
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            $table->foreignId('wilaya_id')->constrained()
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            // $table->unsignedBigInteger('piece_id')->nullable();
            $table->unsignedBigInteger('etat_id')->nullable();
            $table->integer('quantity_fourni')->nullable();
            $table->string('disponibility')->nullable();
            $table->integer('prix_offert');
            $table->boolean('is_choosen')->default(false);
            $table->string('note' , 500)->nullable();
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
        Schema::dropIfExists('reponses');
    }
}
