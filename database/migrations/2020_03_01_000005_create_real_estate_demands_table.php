<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_demands', function (Blueprint $table) {
            $table->bigIncrements('id');    
            $table->auth("agent"); 
            $table->auth("applicant");  
            $table->string('note', 500)->nullable()->comment("just user can see");
            $table->string('explanation', 500)->nullable();
            $table->auth(); 
            $table->string('marked_as')->default('pending');
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
        Schema::dropIfExists('real_estate_demands');
    }
}
