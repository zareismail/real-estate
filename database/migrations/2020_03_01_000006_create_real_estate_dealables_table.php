<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateDealablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_dealables', function (Blueprint $table) {
            $table->bigIncrements('id');     
            $table->unsignedBigInteger('real_estate_deal_id')->index();  
            $table->morphs('dealable');
            $table->boolean("adaptive")->default(false);
            $table->price("min_certain", 15);
            $table->longPrice("min_periodical");
            $table->price("max_certain", 15);
            $table->longPrice("max_periodical");

            $table->foreign('real_estate_deal_id', 'rs_deal_foreign_id')
                  ->references('id')->on('real_estate_deals')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->index(['dealable_id', 'real_estate_deal_id'], 'rs_dd_foreign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_dealables');
    }
}
