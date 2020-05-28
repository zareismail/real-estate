<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_agencies', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->slugging();
            $table->string("guild_id")->unique()->index(); 
            $table->auth("manager");
            $table->string("slogan")->nullable(); 
            $table->detail();
            $table->auth(); 
            $table->location("settlement");
            $table->string("address")->nullable();
            $table->string("zipcode")->nullable();   
            $table->coordinates();
            $table->timestamps();
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
        Schema::dropIfExists('real_estate_agencies');
    }
}
