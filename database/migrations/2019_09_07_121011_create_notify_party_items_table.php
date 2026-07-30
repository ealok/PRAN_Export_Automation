<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifyPartyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_party_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('notify_party_id');
            $table->unsignedInteger('ci_item_id');
            $table->string('desk_item_name',191);
            $table->float('acc_rate',9,3);
            $table->float('party_rate',9,3);
            $table->float('cbm_per_ctn',9,3);
            $table->timestamps();


;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify_party_items');
    }
}
