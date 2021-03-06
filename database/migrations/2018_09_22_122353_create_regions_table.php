<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200)->index();
            $table->string('slug',200);
            $table->integer('parent_id')->nullable()->references('id')->on('regions')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('sort')->default(0);
            $table->integer('depth')->default(0);
            $table->timestamps();
            $table->unique(['parent_id','slug']);
            $table->unique(['parent_id','name']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
