<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marques', function (Blueprint $table) {
            $table->id();
            $table->integer('continent_id')->nullable();
            $table->string('url_hash')->index('url_hash');
            $table->text('url');
            $table->string('nom_ar')->index('nom_ar');
            $table->string('nom_fr')->index('nom_fr');
            $table->text('logo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        // Schema::create('marques', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('nationality_id')->nullable();
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
        Schema::dropIfExists('marques');
    }
}
