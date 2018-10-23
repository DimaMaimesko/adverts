<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advert_id')->references('id')->on('advert_adverts')->onDelete('CASCADE');;
            $table->string('photo', 100);
            $table->string('title', 100)->nullable();
            $table->string('size', 20)->nullable();
            $table->string('description', 200)->nullable();
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
        Schema::dropIfExists('advert_photos');
    }
}
