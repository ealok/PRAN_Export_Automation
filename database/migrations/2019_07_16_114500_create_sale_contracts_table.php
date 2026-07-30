<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sales_contract_no',191)->nullable();
            $table->date('dated');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('sales_term_id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('bank_id');
            $table->string('account_number',191);
            $table->string('invoice_no',191)->nullable();
            $table->date('invoice_date',191)->nullable();
            $table->string('ci_note',191)->nullable();
            $table->string('export_no',191)->nullable();
            $table->date('export_date',191)->nullable();
            $table->string('discharge_port',191)->nullable();
            $table->unsignedInteger('importer_id');
            $table->unsignedInteger('bank_importer_id');
            $table->unsignedInteger('notify_pary_id');
            $table->unsignedInteger('carrying_mode_id');
            $table->unsignedInteger('loading_place_id');
            $table->string('final_destination',191);
            $table->unsignedInteger('approver_id')->nullable();
            $table->string('approved_at')->nullable();
            $table->unsignedInteger('desk_approver_id')->nullable();
            $table->string('desk_approve_at')->nullable();
            $table->text('terms_and_condition')->nullable();
            $table->string('container')->nullable();
            $table->string('container_1')->nullable();
            $table->string('container_2')->nullable();
            $table->string('container_3')->nullable();
            $table->float('freight_cost_1',9,3)->default(0);
            $table->float('freight_cost_2',9,3)->default(0);
            $table->float('freight_cost_3',9,3)->default(0);
            $table->float('freight_cost',9,3);
            $table->boolean('is_revised')->default(0);
            $table->boolean('is_proforma_invoice')->default(0);
            $table->boolean('is_master')->default(0);
            $table->boolean('footer_importer_address')->default(0);
            $table->unsignedInteger('creator_id');
            $table->string('importer_company',200)->nullable();
            $table->text('angikar_given_by')->nullable();
            $table->timestamps();
            
            $table->string('ad_code',191)->nullable();
            $table->date('exp_submit_date')->nullable();
            $table->string('status')->nullable();
            $table->string('office_file_ref_no',191)->nullable();
            $table->date('last_date_for_lodging_claim')->nullable();
            $table->float('non_eligible_item_total',9,3)->default(0);
            $table->date('proceeds_realization_date')->nullable();
            $table->float('amount_of_proceed_realized',9,3)->default(0);
            $table->float('short_realized',9,3)->default(0);
            $table->date('prc_issue_date')->nullable();
            $table->date('bapa_application_submit_date')->nullable();
            $table->date('bapa_certificate_date')->nullable();
            $table->date('claim_submission_date')->nullable();
            $table->float('claim_amount_usd',9,3)->default(0);
            $table->date('audit_report_date')->nullable();
            $table->float('auditted_amount',9,3)->default(0);
            $table->float('exchange_rate',9,3)->default(0);
            $table->float('auditted_amount_tk',9,3)->default(0);
            $table->date('subsidy_rece_date_30_perc')->nullable();
            $table->date('subsidy_rece_date_70_perc')->nullable();
            $table->date('subsidy_rece_date_100_perc')->nullable();
            $table->date('shipped_on_board_date')->nullable();
            $table->date('bl_date')->nullable();
            $table->date('challan_date')->nullable();
            $table->string('challan_no',191)->nullable();
            $table->string('shipping_bill_no',191)->nullable();
            $table->date('shipping_bill_date')->nullable();
            $table->date('lc_date')->nullable();
            $table->string('bb_prc_date',191)->nullable();
           
            
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_contracts');
    }
}
