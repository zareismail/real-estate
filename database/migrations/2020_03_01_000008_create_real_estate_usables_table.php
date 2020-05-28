<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateUsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_usables', function (Blueprint $table) {
            $table->bigIncrements('id');     
            $table->unsignedBigInteger('real_estate_use_id')->index();  
            $table->morphs('usable'); 

            $table->foreign('real_estate_use_id', 'rs_use_foreign_id')
                  ->references('id')->on('real_estate_uses')
                  ->onDelete('cascade')
                  ->onUpdate('cascade'); 

            $table->index(['usable_id', 'real_estate_use_id'], 'rs_uu_foreign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_usables');
    }
}
