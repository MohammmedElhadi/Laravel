<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modeles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('marque_id')->index('marque_id');
            $table->string('nom_ar')->index('nom_ar');
            $table->string('nom_fr')->index('nom_fr');
            $table->timestamps();
        });
        // Schema::create('modeles', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('marque_id')->constrained()
        //                                     ->onUpdate('cascade')
        //                                     ->onDelete('cascade');;
        //     $table->string('nom_ar')->nullable();
        //     $table->string('nom_fr')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modeles');
    }
}
