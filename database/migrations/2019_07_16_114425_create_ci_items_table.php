<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ci_item_name',191);
            $table->string('ci_item_code',191)->unique();
            $table->float('p_net_weight');
            $table->integer('factor');
            $table->integer('ci_factor');
            $table->float('d_net_weight');
            $table->float('d_gross_weight');
            $table->float('ci_item_rate');
            $table->string('hs_code',191);
            $table->float('bapa_percent')->default(20);
            $table->unsignedInteger('bu_id');
            $table->boolean('is_ci_eligible')->default(0);
            $table->timestamps();



    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ci_items');
    }
}
