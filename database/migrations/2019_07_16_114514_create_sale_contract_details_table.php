<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleContractDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_contract_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ccq');
            $table->unsignedInteger('ci_item_id');
            $table->string('ci_item_name',191);
            $table->unsignedInteger('sale_contract_id');
            $table->float('rate_per_ctn',9,3);
            $table->float('rate_per_ctn_for_acc',9,3);
            $table->float('rate_per_ctn_for_party',9,3);
            $table->float('ctn',9,3);
            $table->integer('pcs_in_ctn');

            $table->date('mfg')->nullable();
            $table->date('exp')->nullable();
            $table->string('hs_code',191);
            $table->string('hs_code_2',191)->nullable();
            $table->string('desk_item_name',191);
          
           
            $table->float('net_weight_kg',9,3);
            $table->float('gross_weight_kg',9,3);
            
            
            
            $table->float('cbm_per_ctn',12,8);
            $table->float('total_cbm',14,8);
            $table->float('freigh_x_tcbm_by_sum_total_cbm',12,8);

            $table->float('per_ctn_freight',12,8);
            $table->float('ci_rate_pl_freight',9,3);

            $table->float('total_amount',9,3); //ci
            $table->float('total_amount_party',9,3);
            $table->float('total_amount_acc',9,3);
            
            $table->unsignedInteger('bu_id');
            $table->float('bapa_percent',9,3);
            $table->float('claim_amount',9,3);
            $table->boolean('is_eligible')->default(0);
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
        Schema::dropIfExists('sale_contract_details');
    }
}
