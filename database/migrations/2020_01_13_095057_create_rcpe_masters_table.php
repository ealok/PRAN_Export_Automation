<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRcpeMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcpe_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rcpe_name');
            $table->string('rcpe_fgid');
            $table->unsignedInteger('version');
            $table->unsignedInteger('status');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('rcpe_masters');
    }
}
