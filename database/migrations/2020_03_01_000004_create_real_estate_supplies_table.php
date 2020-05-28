<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_supplies', function (Blueprint $table) {
            $table->bigIncrements('id');   
            $table->foreignId('kind_id')->constrainted('real_estate_kinds')->index();
            $table->foreignId('use_id')->constrainted('real_estate_uses')->index();
            $table->location("settlement");
            $table->auth("agent");  
            $table->auth("applicant");  
            $table->auth(); 
            $table->detail();
            $table->string('note', 500)->nullable()->comment("just agency user can see that");
            $table->string('explanation', 500)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('marked_as')->default('pending');
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
        Schema::dropIfExists('real_estate_supplies');
    }
}
