<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNetworkAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->bigInteger('user_id')->references('id')->on('users')->onDelete('CASCADE')->change();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->bigInteger('user_id')->change();
        });
    }
}
