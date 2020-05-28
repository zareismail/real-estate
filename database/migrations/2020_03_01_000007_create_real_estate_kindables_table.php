<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateKindablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_kindables', function (Blueprint $table) {
            $table->bigIncrements('id');     
            $table->unsignedBigInteger('real_estate_kind_id')->index();  
            $table->morphs('kindable'); 

            $table->foreign('real_estate_kind_id', 'rs_kind_foreign_id')
                  ->references('id')->on('real_estate_kinds')
                  ->onDelete('cascade')
                  ->onUpdate('cascade'); 

            $table->index(['kindable_id', 'real_estate_kind_id'], 'rs_kk_foreign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_kindables');
    }
}
