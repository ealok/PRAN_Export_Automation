<?php

// admin start 
Auth::routes();
Route::get('/admin', 'AdminController@index');
Route::get('/admin/{id}/edit', 'AdminController@edit');
Route::put('/admin/{id}', 'AdminController@update');
Route::get('/profile', 'AdminController@profile');
Route::get('/profile/reset_profile_password', 'AdminController@reset_profile_password_view');
Route::post('/profile/reset_profile_password', 'AdminController@reset_profile_password_update');
Route::get('/admin/access/{id}', 'AdminController@access_edit');
Route::post('/admin/access', 'AdminController@access_set');
Route::post('/admin/access/del_user_feature','AdminController@delete_user_feature');
Route::get('/admin/reset_password/{Id}', 'AdminController@reset_password_view');
Route::post('/admin/reset_password', 'AdminController@reset_password');
Route::get('/active_user/permission','AdminController@activeUserPermission');
Route::resource('/feature', 'FeaturesController');
Route::get('/return/direct/{param1}/{param2}','SaleContractController@returnDirect');
Route::resource('production', 'ProductionController');
Route::get('/jo_receive','ProductionController@joReceiveGetView');
Route::get('/production/do/query','ProductionController@factoryDOQueryGetView');
Route::get('/json/get/production_floor/sc','ProductionController@productionFoorScList');
Route::get('/json/get/sc_wise/jo/details','ProductionController@jsonGetScWiseJODetails');
Route::get('/json/get/sc/jo/task_list','ProductionController@jsonGetScJOTaskList');
Route::POST('/json/save/jo_status','ProductionController@jsonSaveJoStatus');
Route::get('/factory/jo/report/{id}','JobOrderController@factoryJOReport');
Route::get('/factory/sc/report/{id}','JobOrderController@factorySCReport');
Route::get('/update/po_details','ProductionController@updatePoDetails');
Route::get('/update/po/user','ProductionController@updatePoUser');
Route::get('/update/po/user_details','ProductionController@updatePoUserDetails');
Route::get('/manual/po/create','ProductionController@manualPOCreate');
Route::get('/manual/tna/data','ProductionController@manualTnaData');
Route::get('/save/manual/tna','ProductionController@saveManualTna');
Route::get('/manual/data/update','ProductionController@manualDataUpdate');
Route::get('/json/manual/data/update','ProductionController@jsonManualDataUpdate');
Route::get('/update/ci/total_value','ProductionController@updateCiTotalValue');
Route::resource('currency','CurrencySetupController');
Route::get('/json/get_currency_rate','CurrencySetupController@getCurrencyRate');
Route::resource('role','RoleController');
Route::resource('menu','MenuSetupController');


Route::resource('permission','PermissionController');
Route::get('/get-permissions','PermissionController@getRolePermission');
Route::resource('user-permission','UserPermissionController');
Route::post('/update/user_role', 'UserPermissionController@updateUserRole');

Route::get('/json/getUserRoles', 'UserPermissionController@getUserRole');
Route::get('/json/getUserPermissions', 'UserPermissionController@getUserPermissions');
Route::post('/json/resetUserPermissions', 'UserPermissionController@resetUserPermissions');
Route::post('/json/saveUserPermissions', 'UserPermissionController@saveUserPermissions');
Route::post('/delete/user_role','UserPermissionController@removeUserRole');



Route::get('/pwd_reset','UserPermissionController@passwordReset');
Route::post('/reset/user_password','UserPermissionController@resetUserPassword');
Route::get('/user-reg','AdminController@UserReg');
Route::post('/user-reg','AdminController@regUser');
Route::post('/inactive_user','AdminController@inactiveUser');
Route::get('/json/get/user_list','AdminController@getUserList');

Route::resource('cnf','CNFconfroller');
Route::get('/cnf_list','CNFconfroller@getCNFList');
Route::get('/json/get/cnf_list','CNFconfroller@jsonGetCnfList');
Route::get('/cnf_report','CNFconfroller@cnfReprotView');
Route::get('/json/get/cnf/report_date','CNFconfroller@cnfReprotData');
Route::get('/json/get/cnf/edit_details','CNFconfroller@cnfEditDetails');
Route::get('/json/cnf/get/invoie_value','CNFconfroller@jsonGetInvoieValue');
Route::post('cnf_update','CNFconfroller@cnfUpdate');
Route::get('/json/check/cnf/job_no','CNFconfroller@checkingCnfJobNo');


Route::get('/production/report/view','ProductionController@productionReport');
Route::get('/json/load/production/report','ProductionController@jsonLoadProdReport');
Route::get('/json/get/production_floor/job_order','ProductionController@productionFloorWiseJOB');
Route::get('/json/get/production_floor/sc_jo_list','ProductionController@productionFloorWiseJOSCList');
Route::get('/json/get/jo_details','ProductionController@jsonGetJOBDetails');
Route::post('/store/prod/details','ProductionController@storeProdDetails');
Route::get('/tna/dashboard','DashboardController@tnaDashboard');
Route::get('/global_order','DashboardController@globalOrderMonitoringBoard');
Route::get('/json/load/tna/data','DashboardController@jsonLoadTNAData');
Route::get('/check_dashboard/status','DashboardController@checkDashboardStatus');
Route::POST('/pass/tna_dashbaord/content/mail_send','DashboardController@tnaDashboardMailSend');

Route::resource('costing','CostingController');
Route::get('/costing_report','CostingController@costingReportView');
Route::post('/update/costing','CostingController@updateCosting');
Route::get('/prime_cost/upload/view','CostingController@uploadPrimeCostView');
Route::POST('/prime_cost/upload','CostingController@uploadPrimeCost');
Route::get('/costing/upload/view','CostingController@costingUploadView');
Route::POST('/upload/costing','CostingController@uploadCosting');
Route::get('/jsonGetAllCosting','CostingController@getAllCosting');
Route::get('/approve/costing/{id}','CostingController@approveCosting');
Route::get('/get/costing/cvr_and_hd/cost','CostingController@getCostingCvrAndHdCost');
Route::get('/json/get_costing/reprot_data','CostingController@jsonGetCostingReportData');
Route::get('/json/get/costing/freight_details','CostingController@jsonGetCostingFreightDetails');


Route::resource('/cvr','CVRController');
Route::get('/jsonGetListOfCvr','CVRController@jsonGetListOfCVR')->middleware('auth');
Route::get('/json/get/cvr/edit_data','CVRController@getCrvEditData')->middleware('auth');
Route::post('/update/cvr','CVRController@cvrUpdate');

Route::resource('/carrying_chg','CarryingChgSetupController');
Route::get('/jsonGetListOfCarryingChg','CarryingChgSetupController@jsonGetListOfCarringChg')->middleware('auth');
Route::get('/json/get/carrying_chg/edit_data','CarryingChgSetupController@getCarringChgEditData')->middleware('auth');
Route::post('/update/carrying_chg','CarryingChgSetupController@updateCarringCharge');

Route::resource('/costing_others_hd','CostingOthersHeadSetup');
Route::get('/get/costing/others/hd','CostingOthersHeadSetup@getCostingOtherHd');
Route::get('/json/get/costing/other_hd','CostingOthersHeadSetup@getCarringChgEditData');
Route::post('/update/costing/other_hd','CostingOthersHeadSetup@updateCostingOtherHd');

// admin end 

Route::resource('/depot_chg','DepotChargeController');
Route::get('/jsonGetListOfDepotChg','DepotChargeController@jsonGetListOfDepotChg');
Route::get('/json/get/depo_chg/edit_data','DepotChargeController@getDepotChgEditData');
Route::post('/update/depot_chg','DepotChargeController@updateDepotCharge');


Route::get('/home', 'HomeController@index');
Route::post('/api/save-category-order', 'HomeController@saveCategoryOrder');
Route::post('/api/save-item-order', 'HomeController@saveItemOrder');
Route::get('/api/get-software-orders', 'HomeController@getOrders');

Route::post('/software/list', 'HomeController@getSoftwareList');
Route::get('/', function () {

    return redirect('/home');

});

Route::resource('/group', 'GroupController');
Route::resource("/company", "CompanyController");
Route::resource("/bank", "BankController");
Route::resource('/desk','DeskController');
Route::resource('/desk_setup','DeskSetupController');
Route::resource('/desk_permssion','DeskWiseUserController');
Route::get('/json/get/desk_wise/user_list','UserAreaSetupController@getDeskUserList');
Route::get('/json/delete/desk_wise/user','UserAreaSetupController@deleteDeskUser');
Route::resource("/country", "CountryController");
Route::resource('/user_area','UserAreaSetupController');
Route::resource('pfp','PFPController');
Route::get('/json/get/pfp/user_list','PFPController@pfpUserList');
Route::get('/json/active_inactive/pfp','PFPController@activeInactivePfp');
Route::resource('odp','ODPController');
Route::get('/json/get/odp/user_list','ODPController@odpUserList');
Route::get('/json/active_inactive/odp','ODPController@activeInactiveOdp');
Route::resource('trading','TradingController');
Route::get('/json/get/trading/jo_list','TradingController@getTradingJoList');
Route::get('/json/get/trading/details/{id}','TradingController@getTradingDetails');
Route::get('/json/trading/rcv_jo','TradingController@tradingRcvJo');
Route::get('/json/download/trading/jo/detials','TradingController@jsonDownloadTradingJoDetails');


//====================CI Setting=====================
Route::resource("/ci_item", "CiItemController");
Route::get('/json/ci_item/details/{item_code}','CiItemController@getCiItemDetils');
Route::get('/json/get/item/details/{item_code}','CiItemController@getCiItemDetailsLocal');
Route::get('/item_inactive/{id}','CiItemController@itemInactive');
Route::get('/item_active/{id}','CiItemController@itemActive');
Route::get('/get/ci_itemList','CiItemController@getCiItemList');
Route::post('/update/ci_item','CiItemController@updateCiItem');

Route::get('/ci_item/inactive','CiItemController@ciItemInactive');
Route::get("/ci_item_inactive/excel/upload/view","CiItemController@ciItemInactiveExcelView");
Route::post("/ci_item_inactive/excel/upload","CiItemController@ciItemInactiveExcel");
Route::get('/bapa_rate_update/get_view','CiItemController@getBapaRateUpdate');
Route::get('/save/ci_item/details','CiItemController@saveCiItemDetails');
Route::post('/bapa_rate_update','CiItemController@bapaRateUpdate');
Route::resource('bapa_percentage_setup','BapaPercentageSetupController');
Route::get('/sale_contract/{id}/imp_setting/{party_id}','SaleContractController@updateImpValue');
Route::post('/update/imp','SaleContractController@updateImp');
Route::get('/ci_item/excel/upload','CiItemController@ciItemView');
Route::post("/ci_item/upload","CiItemController@ciItemUpload");


//====@@@@@End Ci Setting Controller@@@@@@@@=========

Route::resource("/company_bank", "CompanyBankController");
Route::resource("/importer", "ImporterController");
Route::resource("/carrying_mode", "CarryingModeController");
Route::resource("/sales_term", "SalesTermController");
Route::resource("/loading_place", "LoadingPlaceController");
Route::resource("/sc_item", "ScItemController");
Route::resource("/notify_party", "NotifyPartyController");
Route::get('/json/get/notify_party','NotifyPartyController@jsonGetNotifyPartyList');
Route::get('/json/get/notify_party/list','NotifyPartyController@getNotifyPartylist');
Route::get('/json/notify_party/details/{party_code}','NotifyPartyController@jsonGetNotifyPartyDetails');
Route::get('/json/get/party/details/{party_code}','NotifyPartyController@jsonGetPartyDetailsLocal');
Route::get('/notify_party_excel/upload_view','NotifyPartyController@notifyPartyExcelUploadView');
Route::post('/notify_party/upload','NotifyPartyController@uploadNotifyParty');
Route::get('/get/view/update/party/item_rate','NotifyPartyController@updatePartyPrice');
Route::post('/update/party/item_rate/excel','NotifyPartyController@updatePartyItemRateExcel');
Route::get('/update/item_rate/view','NotifyPartyController@updatePartyPrice');

Route::resource("/sale_contract", "SaleContractController");
Route::post('/sc_update','SaleContractController@update');
Route::get('/sale_contract/create/{pram}','SaleContractController@create');
Route::get('/view/sale_contact/{id}/{id2}','SaleContractController@show');
Route::get('/sale_contract/{pram1}/edit','SaleContractController@edit');
Route::get('/sale_contract/{pram1}/delete/{parm2}','SaleContractController@deleteSalesContact');
Route::get('/get/ci/sc_details/{id}/{id2}','SaleContractController@getCIScDetails');


Route::get('/desk_sales_contract','SaleContractController@index');
Route::get('/party/sc_list','SaleContractController@getPartyWiseSCList');
Route::get('/party/sc_list/for_ci','SaleContractController@getPartyWiseSCListCi');

Route::get("/sale_contract_ci_doc", "SaleContractController@access_notify_party_com");
Route::get('/notify/party/list/desk/{id}','SaleContractController@index');
Route::get('/notify/party/list/com/{id}','SaleContractController@comInvList');


Route::get('/access_notify_party_list',"SaleContractController@access_notify_party_list");
Route::get('/json/get/notify/party/items_list','NotifyPartyItemController@getNofityPartyItems');
Route::get('/json/get/party_item/edit/details','NotifyPartyItemController@partyItemEditDetails');
Route::post('/copy/notify_party/items','NotifyPartyItemController@copyNotifyPartyItem');
Route::post('/update/notify_party/items','NotifyPartyItemController@updatePartyItems');
Route::get("/sale_contract/{id}/ci_sale_contract", "SaleContractController@ci_sale_contract");
Route::get("/sale_contract/{id}/ci_sale_contract_pad","SaleContractController@ci_sale_contract_pad");
Route::get("/sale_contract/{id}/ci_com_inv", "SaleContractController@ci_com_inv");
Route::get("/sale_contract/{id}/ci_com_inv_pad", "SaleContractController@ci_com_inv_pad");
Route::get("/sale_contract/{id}/ci_packaging", "SaleContractController@ci_packaging");
Route::get("/sale_contract/{id}/ci_com_inv_pack_weight", "SaleContractController@ci_com_inv_pack_weight");
Route::get("/sale_contract/{id}/hscode_wise_com_inv_report", "SaleContractController@getHsCodeWiseComInvReport");
Route::get('/get/item/gross/weight','NotifyPartyItemController@getItemGrossWeight');
Route::get('/check/invoice/number/exist/ornot','SaleContractController@checkInvoiceNumberExistOrNot');
Route::get('/check/invoice/number/exist_ornot/on_edit','SaleContractController@checkInvoiceNumberExistOrNotOnEdit');
Route::get('/sale_contract/{id}/ci_sc_pad','SaleContractController@padCISalesContract');
Route::get('/sale_contract/{id}/pad_pwl','SaleContractController@padPacketAndWeightList');
Route::get('/sale_contract/{id}/pad_pi','SaleContractController@padPI');
Route::get('/sale_contract/{id}/sc_desk_pad','SaleContractController@scDeskPad');
Route::get('/get/view/update/party/item_rate','NotifyPartyItemController@partyItemUpload');
Route::get('/sale_contract/{id}/desk_all_pad','SaleContractController@deskAllPad');

//---------------------KSA Report--------------------------------------


Route::get("/sale_contract/{id}/ksa_sale_contract", "SaleContractController@ksa_sale_contract");
Route::get("/sale_contract/{id}/ksa_com_inv", "SaleContractController@ksa_com_inv");
Route::get("/sale_contract/{id}/ksa_com_inv_pack_weight", "SaleContractController@ksa_com_inv_pack_weight");
Route::get("/sale_contract/{id}/ksa_health_certificate", "SaleContractController@ksa_health_certificate");
Route::get("/sale_contract/{id}/ksa_bci", "SaleContractController@ksa_bci");


//---------------------Task Definition--------------------------------------

Route::resource('task','TaskDefinitionController');
Route::get('/task_list','TaskDefinitionController@index');
Route::post('/json/save/task_definition','TaskDefinitionController@store');
Route::post('/json/update/task_definition','TaskDefinitionController@updateTaskDefinition');


//---------------------Task Template --------------------------------------

Route::resource('template','TaskTemplateController');
Route::get('/json/get/task/details/{id}','TaskTemplateController@jsonGetTaskDetails');
Route::resource('mytask','TaskForMeController');
Route::get('/task_query','TaskForMeController@taskQuery');
Route::get('/task_query/approval','TaskForMeController@taskQueryApproval');
Route::get('/json/get/task_query/details','TaskForMeController@getLandPortTaskQuery');
Route::get('/json/get/tna/report/date','ReportController@jsonGetTnaReport');
Route::get('/get/task_list','TaskForMeController@getTaskList');
Route::resource('task_permission','TaskPermissionController');
Route::get('/json/get/upgrade/mytask/details','TaskForMeController@getUpgradeMytaskDetails');
Route::get('/update/landport/special/task','TaskForMeController@updatedSpecialTaskLand');
Route::get('/update/seaport/special/task','TaskForMeController@updatedSpecialTaskSea');
Route::get('/json/load/syn_task','TaskForMeController@jsonLoadSynTask');
Route::get('/tna_hit_rate/report','TaskForMeController@tnaHitRateReport');
Route::get('/json/get/tna_hit_rate/report_data','TaskForMeController@getHitrateReportData');

//---------------------Demand Controller--------------------------------------
Route::resource('demand','DemandController');
Route::get('/order/party_item','DemandController@demandPartyItemView');
Route::get('/get/order/partyItems','DemandController@getOrderPartyItems');
Route::post('/save/order/items','DemandController@saveOrderItems');
Route::get('/getPOs','DemandController@getPOs');
Route::get('/approve/po','DemandController@approvePO');
Route::get('/cancel/po','DemandController@cancelPO');
Route::get('/update/single/demand','DemandController@updateSingleDemnad');
Route::post('/update/all/demand','DemandController@updateAllDemnad');
Route::get('/inactive/demand/item','DemandController@inactiveDemandItem');
//@@@--End--
Route::resource('gt_smtp','GTSmtpSetupController');
Route::get('/json/get/gt_smtp/user_list','GTSmtpSetupController@gtSMTPList');
Route::get('/json/active_inactive/gt_smtp','GTSmtpSetupController@activeInactiveGTSmtp');
Route::resource('gt_order','GTDocApprovalController');
Route::get('/json/get/gt_order/list','GTDocApprovalController@getGtOrderlList');
Route::get('/gt_doc/sc_details/{id}','GTDocApprovalController@getGtApprovalScDetails');
Route::get('/received/gt_order','GTDocApprovalController@receivedGtOrder');
Route::post('/proced/gt_order','GTDocApprovalController@procedGtOrder');
Route::get('/cancel/gt_order','GTDocApprovalController@cancelGtOrder');
Route::get('/download/gt_attach','GTDocApprovalController@downloadFile');


Route::group(['middleware' => 'auth'], function () {

    Route::resource('shipping_line', 'ShippingLineController');
    Route::get('/json/get/shipping/line_details','ShippingLineController@getShippingLinedetails');
    Route::get('/json/get/edit_details','ShippingLineController@jsonGetEditDetails');
    Route::post('/shipping_line/update','ShippingLineController@shippingLineUpdate');
    Route::get('/freight_revise/view','SaleContractController@getViewFreightRevise');
    Route::get('/json/get/party/sc_list','SaleContractController@getPatyWiseSCList');
    Route::get('/revise/freight','SaleContractController@reviseFreight');
    Route::get('/json/get/party/last_shipment/histroy','SaleContractController@getPartyLastShipmentHistory');
    Route::get('/json/get/region_wise/country_list','CostingController@jsonGetRegionWisePartyList');
    Route::get('/json/get/region_wise/party_list','CostingController@jsonCountryWisePartyList');
    Route::get('/json/get/carrying/charge','CostingController@getCarryingCharge');
    Route::get('/json/get/depot/charge','CostingController@getDepotCharge');
    Route::get('/json/get/sc_party/list','SaleContractController@getScPartyList');
    Route::get('/json/get/job_order/list','JobOrderController@getJobOrderList');
    Route::get('/json/get/notify_parties','SaleContractController@getNotifyParties');
    Route::get('/search/ci_items','NotifyPartyItemController@searchCiItem');
    Route::get('/api/top-menus','HomeController@getTopMenus');
    Route::post('/api/save-user-menus','HomeController@saveUserMenus');
    Route::get('/api/user-dashboard','HomeController@getUserDashboard');
    Route::post('/check_unique/item_name','CiItemController@checkUniqueItem');
    
});


Route::get('/json/excel/download/party_item','DemandController@downloadPartyItemExcel');
Route::get('/json/code_wise/item_details','DemandController@codeItemDetails');
Route::get('/json/get/po_details','DemandController@getPoDetails');
Route::post('/json/add/master/item','DemandController@addedPoMaterItem');
Route::get('/json/download/po/item','DemandController@jsonDownloadPoItem');
Route::get('/json/get/desk/user','DeskWiseUserController@getDeskuser');


//---------------------PO--------------------------------------

Route::resource('po','POController');
Route::get('/poLists','POController@poLists');
Route::get('/json/get/template/details','POController@jsonGetTemplateDetails');



Route::resource('new_item_requistion','RequistionController');
Route::get('/requisitions/list', 'RequistionController@getList');
// Route::get('/requisitions/details/{requisitionNumber}', [RequisitionController::class, 'getDetails'])->name('requisitions.details');
// Route::delete('/requisitions/delete/{requisitionNumber}', [RequisitionController::class, 'delete'])->name('requisitions.delete');
// Route::get('/requisitions/edit/{requisitionNumber}', [RequisitionController::class, 'edit'])->name('requisitions.edit');
Route::get('/get_new_requisition_number','RequistionController@getNewRequisitionNumber');
Route::get('/delete-requisition-sequence','RequistionController@deleteRequisitionSequence');
Route::get('/items/search','RequistionController@search');
Route::get('/regions/list','RequistionController@jsonGetRegionPartyList');
Route::get('/bu/list','RequistionController@getBusList');
Route::post('/requisitions/details','RequistionController@getReqDetails');




//-----------------------TR Dubai Report------------------------------------

Route::get("/sale_contract/{id}/ci_sale_contract_tr", "SaleContractController@ci_sale_contract_tr");
Route::get("/sale_contract/{id}/ci_com_inv_tr", "SaleContractController@ci_com_inv_tr");
Route::get("/sale_contract/{id}/ci_packaging_tr", "SaleContractController@ci_packaging_tr");

//--End---
Route::get("/sale_contract/{id}/exp_lien", "SaleContractController@application_for_exp_lien");
Route::get("/sale_contract/{id}/phyto", "SaleContractController@phyto");
Route::get("/sale_contract/{id}/bank_for", "SaleContractController@bank_for");
Route::get("/sale_contract/{id}/noc", "SaleContractController@noc");
Route::get("/sale_contract/{id}/exp_cancel", "SaleContractController@exp_cancel");
Route::get("/sale_contract/{id}/noc_india", "SaleContractController@noc_india");

Route::get("/sale_contract/{id}/noc_usa_canada", "SaleContractController@nocReportUsaCanada");
Route::get("/sale_contract/{id}/noc_maersk", "SaleContractController@nocMaersk");
Route::get("/sale_contract/{id}/noc_msc", "SaleContractController@nocMsc");
Route::get("/sale_contract/{id}/noc_cma_cgm", "SaleContractController@nocCMACGM");
Route::get("/sale_contract/{id}/risk_bond", "SaleContractController@riskBondFun");
Route::get("/sale_contract/{id}/cfr_certificate", "SaleContractController@cfrCertificate");
Route::get("/sale_contract/{id}/cfr_certificate_ind", "SaleContractController@cfrCertificateInd");
Route::get('/make/fixed/bank/for/date','SaleContractController@makeFixedBankForDate');
Route::get('/make/fixed/noc_report/date','SaleContractController@makeFixedNocReportDate');

Route::get("/sale_contract/{id}/acc_sale_contract", "SaleContractController@acc_sale_contract");
Route::get("/sale_contract/{id}/acc_sale_contract_with_code", "SaleContractController@acc_sale_contract_with_code");
Route::get("/sale_contract/{id}/acc_com_invoice", "SaleContractController@acc_com_invoice");
Route::get("/sale_contract/{id}/acc_packaging", "SaleContractController@acc_packaging");

Route::get("/sale_contract/{id}/desk_sale_contract", "SaleContractController@desk_sale_contract");
Route::get("/sale_contract/{id}/desk_sale_contract_with_cbm", "SaleContractController@desk_sale_contract_cbm");
Route::get("/sale_contract/{id}/desk_invoice", "SaleContractController@desk_invoice");
Route::get("/sale_contract/{id}/desk_invoice_pad", "SaleContractController@desk_invoice_pad");
Route::get("/sale_contract/{id}/desk_packaging", "SaleContractController@desk_packaging");
Route::get("/sale_contract/{id}/desk_packaging_with_cbm", "SaleContractController@desk_packing_cbm");
Route::get("/sale_contract/{id}/desk_packaging_code", "SaleContractController@desk_packaging_with_code");
Route::get("/sale_contract/{id}/desk_packing_pad", "SaleContractController@desk_packing_pad");
Route::get("/sale_contract/{id}/desk_packaging_2", "SaleContractController@desk_packaging_2");
Route::get("/sale_contract/{id}/desk_packaging_3", "SaleContractController@desk_packaging_3");
Route::get("/sale_contract/{id}/desk_packaging_uk", "SaleContractController@desk_packaging_uk");
Route::get("/sale_contract/{id}/desk_com_inv_pack", "SaleContractController@desk_com_inv_pack");
Route::get("/sale_contract/{id}/pi_report", "SaleContractController@pi_report");
Route::get("/sale_contract/{id}/uae_report", "SaleContractController@uae_report");
Route::get("/sale_contract/{id}/uae_pad", "SaleContractController@uae_pad");

//----------------------Malayisa-----------------------------

Route::get("/sale_contract/{id}/desk_sale_contract_maly", "SaleContractController@desk_sale_contract_maly");
Route::get("/sale_contract/{id}/desk_sc_pad_maly", "SaleContractController@deskSCPadMaly");
Route::get("/sale_contract/{id}/desk_invoice_maly", "SaleContractController@desk_invoice_maly");
Route::get("/sale_contract/{id}/desk_com_inv_pad_maly", "SaleContractController@desk_invoice_pad_maly");
Route::get("/sale_contract/{id}/desk_packaging_maly", "SaleContractController@desk_packaging_maly");

//----------------------End----------------------------------

//----------------------Malayisa-----------------------------

Route::get("/sale_contract/{id}/desk_sale_contract_ind", "SaleContractController@desk_sale_contract_ind");
Route::get("/sale_contract/{id}/desk_sc_ind_pad", "SaleContractController@desk_sc_ind_pad");
Route::get("/sale_contract/{id}/desk_invoice_ind", "SaleContractController@desk_invoice_ind");
Route::get("/sale_contract/{id}/desk_invoice_ind_pad", "SaleContractController@desk_invoice_ind_pad");
Route::get("/sale_contract/{id}/desk_packaging_maly", "SaleContractController@desk_packaging_maly");
Route::get("/sale_contract/{id}/desk_packaging_pad_maly", "SaleContractController@desk_packaging_pad_maly");

//----------------------End----------------------------------



Route::get("/sale_contract/{id}/annesure", "SaleContractController@annesure");
Route::get("/sale_contract/{id}/bapa_forwarding", "SaleContractController@bapa_forwarding");
Route::get("/sale_contract/{id}/cal_sheet", "SaleContractController@cal_sheet");
Route::get("/sale_contract/{id}/value_addition", "SaleContractController@valueAdditionReport");
Route::get("/sale_contract/{id}/f_kha", "SaleContractController@f_kha");
Route::get("/sale_contract/{id}/f_kha_2", "SaleContractController@f_kha_2");
Route::get("/sale_contract/{id}/forwarding", "SaleContractController@forwarding");
Route::get("/sale_contract/{id}/declaration", "SaleContractController@declaration");
Route::get("/sale_contract/{id}/mcci", "SaleContractController@mcci");
Route::get('/sale_contract/{id}/mcci/land','SaleContractController@mcciLand');
Route::get('/sale_contract/{id}/mcci/land/india','SaleContractController@mcciLandIndia');
Route::get('/sale_contract/{id}/truck_recipt','SaleContractController@truck_receipt');
Route::get('/sale_contract/{id}/truck_recipt_india','SaleContractController@truck_recipt_india');
Route::get('/sale_contract/{id}/truck_recipt_details','SaleContractController@truck_recipt_details');
Route::get('/sale_contract/{id}/health_certificate','SaleContractController@health_certificate');
Route::get('/sale_contract/{id}/custom_cer','SaleContractController@customCER');
Route::get('/sale_contract/{id}/custom_cer_ctg','SaleContractController@customCERCtg');
Route::get('/sale_contract/{id}/custom_cer2','SaleContractController@customCER2');
Route::get('/sale_contract/{id}/custom_cer3','SaleContractController@customCER3');
Route::get('/sale_contract/{id}/gt_bill','SaleContractController@gt_bill');
Route::get('/sale_contract/{id}/for_bank_lc','SaleContractController@forBankLc');
Route::get('/sale_contract/{id}/app_for_arv','SaleContractController@appForARV');
Route::get("/sale_contract/{id}/bci", "SaleContractController@bci");
Route::get("/sale_contract/{id}/bci_ind", "SaleContractController@bci_india");
Route::get("/sale_contract/{id}/land_freight_ind", "SaleContractController@landFreightInd");
Route::get("/sale_contract/{id}/arv_india", "SaleContractController@arvIndiaReport");
Route::get("/sale_contract/{id}/app_for_cnf", "SaleContractController@appForCnf");
Route::get("/sale_contract/{id}/custom_autho", "SaleContractController@customAuthorization");
Route::get("/sale_contract/{id}/arv_for_all", "SaleContractController@arvReportForAll");
Route::get("/sale_contract/{id}/b_certi", "SaleContractController@b_certi");
Route::get("/ci_make_price_same", "SaleContractController@ci_make_price_same");
Route::get("/sale_contract/{id}/angikar", "SaleContractController@angikar");
Route::get("/sale_contract/{id}/ingredient_report", "SaleContractController@ingredient_report");
Route::get("/sale_contract/{id}/ingredient_report_uk", "SaleContractController@ingredient_report_uk");
Route::get("/sale_contract/{id}/ingredient_pad", "SaleContractController@ingredientPadReport");
Route::get("/sale_contract/{id}/ingredient_pad_uk", "SaleContractController@ingredientUkPadReport");
Route::get("/sale_contract/{id}/safta", "SaleContractController@safta");


Route::get("/sale_contract/{param1}/duplicate/{param2}", "SaleContractController@duplicate");
Route::get("/sale_contract/{id}/approve", "SaleContractController@approve");
Route::get("/sale_contract/{param1}/cancel_approve_desk/{param2}", "SaleContractController@cancel_approve_desk");
Route::resource("/sale_contract_detail", "SaleContractDetailController");
Route::get("/sale_contract_detail/{pram1}/edit_desk/{param2}", "SaleContractDetailController@edit_desk");


Route::get("/sale_contract_detail/{pram1}/edit_ci/{param2}/sc_id/{param3}", "SaleContractDetailController@edit_ci");
Route::post("/sale_contract_detail/update_ci",'SaleContractDetailController@update_ci');
Route::post("/sale_contract_detail/update_desk", "SaleContractDetailController@update_desk");
Route::get("/sale_contract_detail/{pram1}/edit/{param2}", "SaleContractDetailController@edit");
Route::get("/sale_contract/{id}/party_id/{party_id}","SaleContractController@CIMakeUnposted");
Route::get('/approve_desk','SaleContractController@approve_desk');
Route::delete('/delete/sales/contact/item','SaleContractController@deleteSalesContactItem');
Route::get('/sale_contract/{param1}/edit/{param2}','SaleContractController@edit');
Route::get("/download_format",'DownloadFormatController@download_format');
Route::get('/show_video','VideoController@showVideo');

Route::get('/json/get_company_bank',"CompanyBankController@get_company_bank");
Route::get('/json/get_ci_select_search',"CiItemController@get_ci_select_search");
Route::get('/json/get_item_of_notify_party',"NotifyPartyItemController@get_item_of_notify_party");
Route::get('/json/order/get_item_of_notify_party','NotifyPartyItemController@get_order_item_of_notify_party');
Route::get('/json/get_item_reate_for_notify_party',"NotifyPartyItemController@get_item_reate_for_notify_party");
Route::get('/json/po_wise/party_item','NotifyPartyItemController@poWisePartyItem');
Route::get('/json/get/item/factor','NotifyPartyItemController@getItemFactor');
Route::get('/json/get_sc_create_po_list','SaleContractController@getScCreatePoList');
Route::get('/json/get_sc_edit_po_list','SaleContractController@getScEditPoList');

Route::resource("/bank_importer", "BankImporterController");
Route::get('/ci/update/view','SaleContractController@ci_edit_view');
Route::get("/json/get/invoice_details","SaleContractController@jsonGetInvoiceDetails");
Route::get("/json/post/invoice_details","SaleContractController@saveInvoiceDetails");
Route::get("/sale_contract/{id}/sci_edit", "SaleContractController@sci_edit");
Route::get("/sale_contract/{id}/sci_com_inv", "SaleContractController@sciComInv");
Route::get('/json/save_com_inv_details','SaleContractController@saveComInvDetails');
Route::get('/json/edit_com_inv_details','SaleContractController@editComInvDetails');
Route::get("/sale_contract/{id}/sci_com_inv_upgrade", "SaleContractController@sci_com_inv_upgrade");
Route::post("/sale_contract/{id}/sci_update", "SaleContractController@sci_update");
Route::get('/json/getlastdate/for_proced_realize','SaleContractController@getLastDateForProcedRealize');
Route::get('/master_book/bulk_upload','SaleContractController@masterBookBulkUpload');
Route::post('/save_master_book/bulk_upload','SaleContractController@saveMasterBookUpload');

Route::resource("/bu", "BuController");
Route::resource("/notify_party_item", "NotifyPartyItemController");
Route::get('/delete/notify_party_item','NotifyPartyItemController@deletePartyItem');
Route::get('/json/get/ci_item_List','NotifyPartyItemController@getCiActiveItemList');
Route::get('/manage/party_items','NotifyPartyItemController@managePartyItems');
Route::post('/upload/party_items','NotifyPartyItemController@uploadPartyItems');
Route::resource("/notify_party_user", "NotifyPartyUserController");
Route::post("/json/get/party_user/list","NotifyPartyUserController@getPartyUserList");
Route::post("/activate/notify/party_user","NotifyPartyUserController@activateNotifyPartyUser");
Route::post("/delete/notify/party_user","NotifyPartyUserController@deleteNotifyPartyUser");
Route::get('/notify/party/list/doc/{id}','SaleContractController@sale_contract_ci_doc_list');
Route::get("/sale_contract_ci_list", "SaleContractController@sale_contract_ci_list");
Route::get("/notify/party/ci/list/{id}", "SaleContractController@sale_contract_ci");

//-------------------------JOB order Controller---------------

Route::resource('/job_order','JobOrderController');
Route::get("/job_order/create/{id}","JobOrderController@create");
Route::get('/jo/create/{id1}/{id2}','JobOrderController@create');
Route::post('/save/distributor/information/details','ExportDistributorInformationController@saveExportDistInfo');
Route::get('/getimporter/details/forjoborder','JobOrderController@getImporterDetailsForJobOrder');
Route::get('/get/job_order/belog/tosalecontact','JobOrderController@getJobOrderItemBelogToSaleContact');
Route::post('/save/job_order/information/details','JobOrderController@saveJobOrderInformationDetails');
Route::get('/job/order/edit/{id}','JobOrderController@edit');
Route::post('/update/job_order/information/details','JobOrderController@update');
Route::get('/job_order/list','JobOrderController@getJobOrderList');
Route::get('/job_order/approval_list','JobOrderController@jobOrderApprovalList');
Route::post('/job_order/approve','JobOrderController@AppvoveJobOrder');
Route::post('/job/order/rate_matching','JobOrderController@jobOrderRateMatching');
Route::post('/job/order/rate_matching/edit','JobOrderController@jobOrderRateMatchingEdit');
Route::get('/jo/cancel','JobOrderController@cancelJo');
Route::get('/jo/cancel/inv_wise','JobOrderController@cancelJoInvWise');
Route::get('/jo/revise','JobOrderController@joRevise');
Route::get('/getParty/PendingJO','JobOrderController@getPartyPendingJO');
Route::post('/job/order/view_matching','JobOrderController@rateMatchingView');
Route::post('/job_order/cancel','JobOrderController@jobOrderCancel');
Route::get('/jo/soft_cancel','JobOrderController@joSoftCancel');
Route::get('/job_order/show/{id}','JobOrderController@jobOrderDetails');
Route::get('/job/order/add_item/edit_option','JobOrderController@jobOrderAddItemEditOption');
Route::delete('/delete/job/order/item','JobOrderController@deleteJobOrderItemInEdit');
Route::delete('/delete/do/order/item','JobOrderController@deleteDoOrderItem');
Route::post('/add_new/job_order/item','JobOrderController@addNewJobOrderItem');
Route::get('/job_order/do/create/{id}','JobOrderController@doCreate');
Route::get('/check/do_balance','JobOrderController@checkDoBalance');
Route::post('/getJobOrder/request/item','JobOrderController@getJobOrderRequestItem');
Route::get('/desk/wise/jo','JobOrderController@deskWiseJoList');
Route::get('/notify/party/job/order/list','JobOrderController@notifyPartyJobOrderList');
Route::get('/json/get/party_wise/jo_list','JobOrderController@getPartyWiseJoList');
Route::get('/revise/jo','JobOrderController@reviseJo');
Route::get('/json/get/party_wise/cancel_list','JobOrderController@getPartyWiseJoCancelList');
Route::get('/json/get/invoice/jo_list','JobOrderController@jsonGetInvoiceJoList');
Route::get('/json/get/jo/details/{id}','JobOrderController@jsonGetJoDetails');
Route::get('/jo/special_approval','JobOrderController@getViewSpecialApproval');
Route::get('/create/job_order','JobOrderController@createJobOrder');


Route::post('/send/approval_mail','JobOrderController@sendingApprovalMail');
Route::resource('do','DoController');
Route::resource('deport','DepotController');
Route::resource('bl','BLController');
Route::get('/bl_report','BLController@blReport');
Route::get('/bl_excel','BLController@blExcelView');
Route::post('/upload/bl_excel','BLController@uploadBlExcel');


Route::get('/india/desk/approval/view','ApprovalController@indiaDeskApprovalView');
Route::get('/json/PendigAllJobOrderListEd','ApprovalController@jsonPendingJOBListEd');
Route::get('/json/PendigAllJobOrderListMd','ApprovalController@jsonPendingJOBListMd');
Route::get('/ed/approval_list','ApprovalViewController@pedingJobOrderEd');
Route::get('/md/approval_list','ApprovalViewController@pedingJobOrderMD');
Route::get('/management/approval_list','ApprovalViewController@managementApproval');

Route::get('/approval_pending/sc_list','ApprovalController@approvalPendingScList');
Route::get('/approve/pending/job_order_ed','ApprovalController@approvePendingJobOrderEd');
Route::get('/approve/pending/job_order_md','ApprovalController@approvePendingJobOrderMd');
Route::get('/balance_breaker/approval/mail','PendingDOApprovalController@balanceBreakerApprovalMail');
Route::get('/pending/do/approval_list','PendingDOApprovalController@showListDOPending');
Route::get('/approve/pending/do_list','PendingDOApprovalController@approvePendingDoList');
Route::get("/undelivred/mail_send","SendMail@undeliveredMailSend");
Route::get("/undelivered/data_generate","SendMail@generateUndeliveredData");
Route::get("/distributor_information/create","ExportDistributorInformationController@create");


Route::post('/delete/job_order/approval_item','JobOrderController@deleteJOBOrderApprovalItem');
Route::get('/data/syn','ApprovalController@getSynchronization');
Route::get('/syn/trading_item','SyncronizationController@synTradingItem');
Route::get('/ci_value/syn','ApprovalController@ciValueSyn');
Route::get('/jo_receive/by/jo','ApprovalController@joSingleReceive');



//@@@------KYV Controller----------------------

Route::get('/kyv/jo_order/receive','ApprovalController@kyvJobOrderReceive');
Route::get('/kyv/jo/updated/receive','ApprovalController@kyvJobOrderUpdateReceive');
Route::get('/kyv/do/updated/receive','ApprovalController@kyvDOUpdatedReceive');
Route::get('/oc/updated','ApprovalController@ocUpdate');
Route::get('/crm/order_receive','ApprovalController@crmOrderReceive');
Route::get('/crm/order_update_receive','ApprovalController@crmOrderUpdateReceive');

//@@@-End--

//@@@------KYV Controller----------------------

Route::get('/invoice/freight/fatching','ApprovalController@invoiceFreightFatching');

//@@@------End KYV-----@@@@

//@@@------API Controller----------------------

Route::get('/json/get/vat/job_order/details/{asdf}','JobOrderAPIController@vatJOBOrderInfo');
Route::get('/json/get/vat/sale_contact/details/{asdf}','JobOrderAPIController@vatSaleContactInfo');
Route::get('/json/get/vat/sale_contact_list/{dfsdf}','JobOrderAPIController@vatGetSaleContactList');

//@@@End API

//---------------------DO Report---------------------------------

Route::get('/do/report/home','DoController@doReportHome');
Route::get('/json/get/do/report/details','DoController@getDoReportDetails');


//---------------------------Receipe-----------------------------

Route::resource('recipe','MaterialReceipeController');
Route::post('update/recipe/master','MaterialReceipeController@updateRecipeMaster');
Route::get('/recipe/details/edit/{id}','MaterialReceipeController@getRecipeDetailseditView');
Route::get('/recipe/details/update','MaterialReceipeController@recipeDetailsUpdate');
Route::get('/recipe/{id}/addnew','MaterialReceipeController@addNewIngredient');
Route::post('/save/add/new/ingredient','MaterialReceipeController@saveAddNewIngredient');
Route::get('/recipe/details/delete/{id}','MaterialReceipeController@deleteReceipeIngredient');

//@@@----------------Item Group Controlller---------

Route::resource('item_group','ItemGroupController');
Route::resource('item_group_assign','ItemGroupAssignController');
Route::resource('assign_item_gorup_india','ItemGroupAssignIndiaController');
Route::resource('ci_cvr','CIConversionRateController');
Route::get('/jsonGetListOfCiCvr','CIConversionRateController@jsonGetListOfCVR')->middleware('auth');
Route::get('/json/get/ci_cvr/edit_data','CIConversionRateController@getCrvEditData')->middleware('auth');
Route::post('/update/ci_cvr','CIConversionRateController@updateCiCVr');

//@@@----------------CI Item Claim Controller-------

Route::resource('ci_item_claim','CiItemCalimController');
Route::resource('ci_date_claim','CiDateClaimController');
Route::resource('assign_item_claim','AssignItemClaimController');

//@@----------------Bapa Bill Processing------------------

Route::resource('bapa_bill_setup','BapaBillSetupController');
Route::resource('bapa_receive','BapaBillReceivController');
Route::get('/json/get/master/comInv/list','BapaBillReceivController@jsonGetComMasterInvList');
Route::get('/json/get/company/list','BapaBillReceivController@jsonGetCompanyList');
Route::get('/json/bapa/rcv/details','BapaBillReceivController@jsonBapaRcvDetails');
Route::get('/json/get/bapa/rev_list','BapaBillReceivController@getBapaRcvList');
Route::get('/bapa_forwarding/print','BapaBillReceivController@bapaPrintPadView');
Route::get('/json/update/bapa_print/status','BapaBillReceivController@bapaUpdatePrintStatus');
Route::get('/bapa_bill','BapaBillReceivController@bapaBillView');
Route::get('/json/get/bapa_bill','BapaBillReceivController@jsonBapaBill');
Route::get('/json/update/bapa_bill/status','BapaBillReceivController@updateBapaBillStatus');
Route::get('/bill_report','BapaBillReceivController@bapaBillReport');



//-----@@@--Search Sales Contact--@@@@@@@@@@@@@----------

Route::resource('factroy_user','FactoryUserController');
Route::post('/update/truck/numbers','FactoryUserController@updateTruckNumbers');
Route::get('/json/get/truck/numbers','FactoryUserController@jsonGetTruckNumber');
Route::get('/search/sales_contact','FactoryUserController@searchSalesContact');
Route::resource('transportagency','TransportAgencyController');


Route::resource('case_insentive','CaseInsentiveController');
Route::get('/cash/insentive/report/view','CaseInsentiveController@cashInsentiveReportView');
Route::post('/cash/insentive/report/show','CaseInsentiveController@cashInsentiveReportShow');
Route::get('/cash/insentive/summary/report/view','CaseInsentiveController@caseInsentiveSummaryReportView');
Route::get('/cash/insentive/summary/report','CaseInsentiveController@insentiveSummaryReport');
Route::get('/case/insentive/toList','CaseInsentiveController@topListView');
Route::get('/json/invoice/search','CaseInsentiveController@jsonGetInvoiceList');
Route::get('/json/invoice/search/prc_list','CaseInsentiveController@jsonGetPrcList');
Route::get('/json/invoice/search/masterbook','CaseInsentiveController@jsonGetInvoiceListForMasterBook');
Route::get('/json/invoice/search/masterbook/all','CaseInsentiveController@jsonGetInvoiceListForMasterBookAll');
Route::get('/master/book','CaseInsentiveController@masterBookView');
Route::get('/master/book/all','CaseInsentiveController@masterBookViewAll');
Route::get('/download/master_book/record/current','CaseInsentiveController@downloadMasterBookRecordCurrent');
Route::get('/download/master_book/record','CaseInsentiveController@downloadMasterBookRecord');
Route::get('/over/due/list','CaseInsentiveController@overDueList');
Route::get('/prc','CaseInsentiveController@prcList');
Route::post('/prc','CaseInsentiveController@getPrc');
Route::resource('over_due','OverDueController');
Route::get('/json/get/over_due','SaleContractController@jsonGetOverDue');
Route::resource('swift_update','SwiftUpdateController');
Route::post('/swift/excel/update','SwiftUpdateController@swiftExcelUpdate');
Route::get('/swift_list','SwiftUpdateController@swiftList');
Route::get('/json/get/swift/list','SwiftUpdateController@jsonGetSwiftList');
Route::get('/ci_com_inv/list','SaleContractController@ciComInvList');
Route::get('/ci_com_inv/list/all','SaleContractController@ciComInvListAll');
Route::get('/ci_com_inv/list/excel/download','SaleContractController@ciComInvListDownloadExcel');
Route::get('/ci_com_inv/list/all/excel/download/{fromDate}/{toDate}','SaleContractController@ciComInvListAllDownloadExcel');
// Route::get('/ci_com_inv_show/{id}/show','SaleContractController@ciComInvShow');
// Route::get('/ci_com_inv/{id}/edit','SaleContractController@ciComInvEdit');
Route::get('/unposted/ci/file/view','SaleContractController@getViewCiUnposted');
Route::get('/unposted/ci_file','SaleContractController@unpostedCiFile');
Route::get('/json/create_case_insentive','SaleContractController@createCaseInsentive');
Route::get('/json/com_inv/search','SaleContractController@jsonComInvSearch');
Route::get('/json/get_edit_insentive_details','SaleContractController@jsonGetInsentiveDetails');
Route::get('/json/edit_insentive_details','SaleContractController@jsonEditInsentiveDetails');
Route::get('/incentive/excel/upload/view','SaleContractController@ciIncentiveExcelUPloadview');
Route::post('/incentive/excel/upload','SaleContractController@incentiveExcelUpload');


Route::get('/json_load/caseInsentiveValue','CaseInsentiveController@jsonLoadCaseInsentiveValue');
Route::get('/master/book/edit/view/{id}','CaseInsentiveController@masterBookEditView');
Route::get('/json/edit/invoice_details','CaseInsentiveController@jsonEditInvoiceDetails');

Route::resource('mrp','MrpController');
Route::resource('product_percentage','ProductPercentageController');
Route::resource('percentage_setup','ProductPercentageSetupController');
Route::resource('/factory/job_order/setup','FactoryJobOrderSetupController');
Route::post('/factory/job_order/setup/update/{id}','FactoryJobOrderSetupController@update');
Route::get('/json/saveProduction/floor/details','FactoryJobOrderSetupController@saveProductionFloorDetails');
Route::resource('factroy_job_order','FactoryJobOrderController');
Route::get('/sale_contract/{id}/annexure_c','SaleContractController@annexure_c');
Route::get('/sale_contract/{id}/annexure_d','SaleContractController@annexure_d');
Route::get('/sale_contract/{id}/date_setting/{party_id}','SaleContractController@reportDateSetting');
Route::post('/save/date_formeting/details','SaleContractController@saveDateFormetingDetails');
Route::get('/json/edit_insentive_amount','SaleContractController@editInvoiceTotalAmount');
Route::get('/sale_contract/factory_details/{id}','SaleContractController@saleContractFactroyDetails');
Route::get('/export/details_report','DeskController@exportDetailsReport');
Route::get('/export/details_report/data','DeskController@exportDetailsReportData');
Route::resource('/signature','SignatureSetupController');
Route::get('/json/get/user_singature','SignatureSetupController@getUserSignature');
Route::get('/json/get/signature_edit/data','SignatureSetupController@signatureEditData');
Route::post('/update/signature','SignatureSetupController@updateSignature');

//---@@@Report Controller@@@@-----------

Route::get('/ci_report_index','ReportController@ci_report_index');
Route::get('/mcb_report_view','ReportController@mcb_report_view');
Route::get('/get/order/party/wise_po','ReportController@getOrderWisePO');
Route::post('/get/trucking/report/details','ReportController@getTruckingReportDetails');
Route::get('/order/trucking/report','ReportController@orderTruckingReport');
Route::get('/jo/report','ReportController@joReport');
Route::post('/json/get/jo/report_date','ReportController@jsonGetJoReportData');
Route::get('/jo_details','ReportController@jo_details');
Route::get('/json/get/jo/invoice/details','ReportController@getJoInvoiceDetails');
Route::get('/export-jo-invoice-details','ReportController@exportJOInvoiceDetails');
Route::get('/jo/cancel/report','ReportController@getCancelJoData');
Route::get('/freight_report','ReportController@freightReport');
Route::get('/json/get/freight/report_date','ReportController@getFreightReportData');
Route::get('/json/get/jo/cancel_report','ReportController@jsonGetCancelReportData');
Route::get('/tna_report','ReportController@tnaReportView');
Route::get('/tna_progress/report','ReportController@tnaProgressReport');
Route::get('/json/get/tna_progress/report_data','ReportController@getTNAProgReportData');
Route::get('/po_details/report','ReportController@poDetailsReport');
Route::post('/json_get/po_details/data','ReportController@poPoDetailsReportData');
Route::get('/sc_details/report','ReportController@scDetailsReport');
Route::get('/gp_summary/report','ReportController@gpSummaryReport');
Route::post('/json_get/gp_summary/data','ReportController@getGpSummaryDate');
Route::get('/gp_details','ReportController@gpDetailsReport');
Route::post('/json_get/gp_details/data','ReportController@getGpDetailsDate');
Route::post('/json_get/invoice/gp_details','ReportController@jsonGetGpDetails');
Route::get('/sc_jo/details','ReportController@scVsJoReport');
Route::post('/json_get/sc_vs_jo/data','ReportController@jsonGetScVsJOData');
// Route::get('/sc_jo/details','ReportController@scVsJoReport');
// Route::post('/json_get/sc_vs_jo/data','ReportController@jsonGetScVsJOData');
Route::get('/sc_jo_do/report','ReportController@scVsJoVsDoReport');
Route::post('/json_get/sc_vs_jo_do/data','ReportController@jsonGetScVsJOVsDoData');


// Route
Route::resource('/shipment_tracking','ShipmentTrackingController');
Route::post('/json/get_party/by_country','ShipmentTrackingController@getPartiesByCountries');
Route::post('/json_get/shipment_tracking_data','ShipmentTrackingController@getShipmentTrackingData');
Route::post('/json_save/shipment_header_data','ShipmentTrackingController@saveShipmentHeaderData');
Route::get('/export-shipment-tracking','ShipmentTrackingController@exportShipmentTracking');
Route::get('/ship_tracking_report','ShipmentTrackingController@shipTrackingReport');
Route::post('/json_get/shipment_status_report','ShipmentTrackingController@getShipTrackingData');
Route::get('/export-shipment-report','ShipmentTrackingController@exportShipMentReport');


//---@@@IPU Controller@@@@-----------

Route::resource('riu','RIUController');
Route::post('/save-riu-data','RIUController@saveRiuData');

// Category routes
Route::name('categories.')->prefix('categories')->middleware('auth')->group(function () {

    Route::get('/', 'CategoryController@index')->name('index');
    Route::get('/get_category_list', 'CategoryController@getCategoryList')->name('getCatList');
    Route::post('/create', 'CategoryController@store')->name('store');
    Route::put('/{id}', 'CategoryController@update')->name('update');
    Route::delete('/{id}', 'CategoryController@destroy')->name('delete');
    Route::get('/{id}', 'CategoryController@show')->name('show');

});

// Update task route list
Route::middleware('auth')->group(function () {
    Route::get('/update/task/exp_duplicate', 'TaskForMeController@updateExpDuplicate');
    Route::get('/update/phyto/task_date', 'TaskForMeController@updatePhytoTaskDate');
    Route::get('/search/inv/for/tna_approval','TaskForMeController@invoiceSearchTnaApprovalFun');
    Route::get('/json/make/tna/final_approval','TaskForMeController@makeTnaFinalApproval');
    Route::get('/json/get_bl/invoice_list','BLController@getBlInvoiceList');
    Route::post('/search/bl_copy','BLController@searchBLCopy');
    Route::get('/json/get/bl/report_data','BLController@getBLReportData');
    Route::get('/json/get/sc_party/list','SaleContractController@getScPartyList');
    Route::get('/json/get/notify_parties','SaleContractController@getNotifyParties');
    Route::get('/json/get/job_order/list','JobOrderController@getJobOrderList');
    Route::get('/search/ci_items','NotifyPartyItemController@searchCiItem');
    Route::post('/sale_contract/{id}/soft-delete/{party_id}','SaleContractController@softDelete');
    Route::post('/sale_contract/{id}/desk-post/{party_id}','SaleContractController@deskPost');
    Route::post('/update/truck/details','FactoryUserController@updateTruckDetails');
    Route::post("/ajax/add-sale-contract-item","SaleContractDetailController@store");
    Route::get("/ajax/get-sale-contract-details/{id}","SaleContractDetailController@getSaleContractDetails");
    Route::post("/update/report_percentage",'SaleContractController@updateReportPercent');
    Route::get('/json/get_region_wise_country_list','NotifyPartyUserController@jsonGetRegionWiseCountryList');
    Route::get('/json/get_region_wise_party_list','NotifyPartyUserController@jsonGetRegionPartyList');
});

// SubCategory routes
Route::name('subcategories.')->prefix('subcategories')->middleware('auth')->group(function () {
    
    // Subcategory routes
    Route::get('/', 'SubCategoryController@index')->name('index');
    Route::get('/get_subcategory_list', 'SubCategoryController@getSubcategoryList')->name('getSubList');
    Route::post('/create', 'SubCategoryController@store')->name('store');
    Route::put('/{id}', 'SubCategoryController@update')->name('update');
    Route::delete('/{id}', 'SubCategoryController@destroy')->name('delete');
    Route::get('/{id}', 'SubCategoryController@show')->name('show');

});

//@@@@--End--@@@

//@@@@Process Data@@@@-----------
Route::get('/pfp_gen','ProcessDataController@pfpDataGen');
Route::get('/odp_gen','ProcessDataController@odpDataGen');

//@@@@--End--@@@
Route::get('/update_party/items','CiItemController@updateNotifyPartyItem');
Route::get('/error-page','ErrorController@index');


//@@@@--Quick Sales Contract------- 
Route::get('/quick_sc/create','TestController@sales_contract');
Route::get('/quick_sc','TestController@quickSc');
Route::get('/sales_contract_form','TestController@sales_contract');
Route::get('/sales_contact/edit','TestController@saleContractEidt');
Route::get('/sales_contact/details','TestController@show');
Route::get("/duplicate/sc", "TestController@duplicate");
Route::get('/sc/inactive','TestController@inactiveSalesContact');
Route::get('/approve/sale_contract','TestController@approveSalesContract');
Route::post('/json/save/temp_table/sc_items','TestController@SaveTempScItems');
Route::post('/json/save/temp_table/sc_items/onedit','TestController@SaveTempScItemsOnEidt');
Route::post('/delete/sc_temp/item','TestController@deleteScTempItem');
Route::post('/delete/quick_sc/item','TestController@deleteQuickScItem');
Route::get('/json/get/party_items/ship_details','TestController@partyItemList');
Route::get('/json/get/imp/ship_details','TestController@impShipDetails');
Route::get('/json/get/sc_edit/items','TestController@getScEditItem');
Route::get('/json/get/sales_contract/edit/item_details','TestController@getScEditItemDetails');
Route::post('/update/desk_item','TestController@updateScDeskItem');
Route::post('/add/sc/temp_item','TestController@addScTempItem');
Route::post('/add/sc/temp_item/onedit','TestController@addScTempItemOnEdit');
Route::post('/xyz','TestController@createSalesContract');
Route::post('/xyz/update','TestController@updateSalesContract');
Route::post('/add/quick_sc/edit_item','TestController@addQuickScEditAddItem');
Route::get('/page_load/delete/temp_item','TestController@pageLoadDeleteTempItem');
Route::get('/json/get_buyer/po_list','TestController@getBuyerPoList');
Route::get('/json/handle/freight/control','TestController@jsonHandleFreight');
Route::get('/sales_contact/edit_doc','TestController@salesContractEditDoc');
Route::get('/json/get/sales_contract/doc_item','TestController@updateDocItem');
Route::post('/update/item_info/for_doc','TestController@updateItemDocInfo');
Route::get("/doc_make_price_same", "TestController@doc_make_price_same");
Route::get('/party_wise/doc/sc_list','TestController@partyWiseDocScList');
Route::get('/docsale_contract','TestController@docApproveSalesContract');
Route::get('/unposted/approve_desk','TestController@unpostedApproveDesk');
Route::get('/json/get/po_items','TestController@jsonGetPoItems');
Route::get("/sci_doc", "SaleContractController@sciDocProcess");

//@@@@--Quick Job Order Controller------------
Route::get("/quick_jo","QuickJobOrderController@create");
Route::get('/party_wise/sc_jo/list','QuickJobOrderController@getPartyWiseSCJoList');
Route::get('/create_new/jo','QuickJobOrderController@createNew');
Route::post('/quick_order/rate_matching','QuickJobOrderController@jobOrderRateMatching');
Route::post('/create/job_order','QuickJobOrderController@storeJobCreateInfo');
Route::get('/edit_jo','QuickJobOrderController@editJobOrder');
Route::delete('/delete/quick_job/order/item','QuickJobOrderController@deleteJobOrderItemInEdit');
Route::post('/update/quick/job_order','QuickJobOrderController@update');
Route::get('/quick/create_do','QuickJobOrderController@doCreateView');
Route::post('/quick/create_do','QuickJobOrderController@createDO');
Route::get('/quick/jo_order/approve','QuickJobOrderController@AppvoveJobOrder');
Route::get('/job_report/view','QuickJobOrderController@viewJOreport');
Route::get('/get/available/items/for/jo','QuickJobOrderController@getAvaiableItemForJo');
Route::post('/job_order/add_item','QuickJobOrderController@jobOrderAddItem');
Route::get('/update/wh','QuickJobOrderController@updateWh');
Route::get('do_query','QuickJobOrderController@doQuery');
Route::get('/buyer/do_summary','QuickJobOrderController@buyerDOsummary');
Route::get('/buyer/do_details','QuickJobOrderController@buyerDODetails');
Route::get('/create_do','JobOrderController@doCreateView');
Route::get('/check/do_balance','JobOrderController@checkDoBalance');
Route::post('/create_do','JobOrderController@createDO');

//@@@@--Commercial Invoice List------------
Route::get("/doc_sales_contract", "TestController@comAccessPartyList");
Route::get('/com_inv/details','TestController@comInvDetails');

//@@@@--Update Value------------
Route::get('/update_gwt','ReportController@updateGrossWeight');
Route::get('/update_cbm','ReportController@updateCBM');
Route::get('/manual_item_requistion','RequistionController@updateManualRequistion');




//@@@@--Logout Route------------
Route::post('/logout', 'Auth\LoginController@logout');


