<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Zareismail\RealEstate\RealEstateDeal;

class CreateRealEstateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_deals', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->naming(); 
            $table->labeling("supply")->comment("label of supply");
            $table->labeling("demand")->comment("label of demand");
            $table->enum('pricing', array_keys(RealEstateDeal::pricings()));
            $table->enum('period', array_keys(RealEstateDeal::periods()));
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
        Schema::dropIfExists('real_estate_deals');
    }
}
