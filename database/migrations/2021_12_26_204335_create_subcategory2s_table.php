<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategory2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategory2s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained()
                                            ->onUpdate('cascade')
                                            ->onDelete('cascade');;
            $table->string('nom_ar')->nullable();
            $table->string('nom_fr')->nullable();
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
        Schema::dropIfExists('subcategory2s');
    }
}
