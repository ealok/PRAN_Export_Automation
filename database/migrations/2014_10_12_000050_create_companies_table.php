<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',191)->unique();
            $table->string('code',191)->unique();
            $table->string('erc_no',191)->unique();
            $table->string('bin_no',191)->unique();
            $table->text('factory_name');
            $table->text('factory_address');
            $table->text('ho_address');
            $table->unsignedInteger('group_id');
            $table->timestamps();



            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
