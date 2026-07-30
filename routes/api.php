<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ItemRequisitionController;
Route::get('/json/get/invoice_list','ApiController@getInvoiceList');
Route::post('/export/item/requisition/pran', 'Api\ItemRequisitionController@createItemRequisition')->middleware('basic.auth');
Route::post('/exports/items/openings/status', 'Api\ItemRequisitionController@updateItemOpeningStatus')->middleware('basic.auth');
Route::post('/export/order_list', 'Api\JobOrderController@updateJobOrderList')->middleware('basic.auth');