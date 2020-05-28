<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateRequestAgencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_request_agency', function (Blueprint $table) {
            $table->id();     
            $table->foreignId('real_estate_agency_id')->constrainted()->index();
            $table->morphs('request');
            $table->boolean('shared')->default(true);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_request_agency');
    }
}
