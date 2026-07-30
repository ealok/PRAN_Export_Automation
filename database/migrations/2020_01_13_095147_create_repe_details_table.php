<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repe_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rcpe_id');
            $table->string('ingredient');
            $table->string('source_of_material');
            $table->text('source_address');
            $table->string('qty');
            $table->string('percentage');
            $table->string('wqty');
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
        Schema::dropIfExists('repe_details');
    }
}
