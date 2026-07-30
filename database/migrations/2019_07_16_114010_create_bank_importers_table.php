<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankImportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_importers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name',191);
            $table->string('account_name',191);
            $table->text('branch');
            $table->text('ac_or_iban');
            $table->string('swift_code',191);
            $table->text('other')->nullable();
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
        Schema::dropIfExists('bank_importers');
    }
}
