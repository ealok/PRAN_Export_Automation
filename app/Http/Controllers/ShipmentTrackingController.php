<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Area;
use Excel;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use DB;
class ShipmentTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
        return view('shipment_tracking.index')->with('regions',$regions);
    }

    public function getPartiesByCountries(Request $request){
        
        $countries = $request->input('countries', []);
        if (empty($countries)) {
            return response()->json(['status' => 'error', 'message' => 'No countries selected', 'data' => []]);
        }

        $parties = DB::table('notify_parties')
            ->whereIn('country', $countries)
            ->select('id', 'code','name')
            ->distinct()
            ->get();
        
        return response()->json(['status' => 'success', 'data' => $parties]);

    }

    public function getShipmentTrackingData(Request $request)
    {
        
        try {

            $partyIds = implode(',', $request->input('party_list', []));
            $fromDate = $request->has('fromDate') && $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : null;
            $toDate = $request->has('toDate') && $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : null;
            $data = DB::select("CALL GET_SHIPMENT_TRACKING_DATA(?, ?, ?)", [$partyIds, $fromDate, $toDate]);
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'total' => count($data)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

    }
    
    public function saveShipmentHeaderData(Request $request)
    {

        try {
            DB::beginTransaction();

            $invoiceData = json_decode($request->invoice_data, true);

            if (!$invoiceData || !is_array($invoiceData)) {
                return response()->json(array(
                    'status' => 'error',
                    'message' => 'Invalid invoice data format'
                ), 400);
            }

            $savedCount = 0;
            $errors = array();

            foreach ($invoiceData as $data) {

                if (empty($data['invoice_no'])) {
                    $errors[] = 'Invoice number is required';
                    continue;
                }

                // Get invoice_id (sc_id from procedure)
                $invoiceId = isset($data['invoice_id']) ? $data['invoice_id'] : null;
                $invoiceNo = $data['invoice_no'];
                
                // ===== Get all fields from data =====
                $stuffingDate = isset($data['stuffing_date']) ? $data['stuffing_date'] : null;
                $scheduledReaching = isset($data['scheduled_reaching']) ? $data['scheduled_reaching'] : null;
                $blNo = isset($data['bl_no']) ? $data['bl_no'] : null;
                $containerQty = isset($data['container_qty']) ? $data['container_qty'] : 0;

                // ===== Check if header exists using invoice_id (sc_id) =====
                $existingHeader = null;
                
                if (!empty($invoiceId)) {
                    $existingHeader = DB::table('shipment_headers')
                        ->where('invoice_id', '=', $invoiceId)
                        ->first();
                }

                // If not found by invoice_id, try by invoice_no
                if (!$existingHeader) {
                    $existingHeader = DB::table('shipment_headers')
                        ->where('invoice_no', '=', $invoiceNo)
                        ->first();
                }

                $headerId = null;

                if ($existingHeader) {
                    // ===== UPDATE existing header =====
                    $headerId = $existingHeader->id;
                    
                    $updateData = array(
                        'invoice_id' => !empty($invoiceId) ? $invoiceId : $existingHeader->invoice_id,
                        'invoice_no' => $invoiceNo,
                        'stuffing_date' => $this->parseDate($stuffingDate),
                        'container_qty' => $containerQty,
                        'scheduled_reaching' => $this->parseDate($scheduledReaching),
                        'bl_no' => $blNo,
                        'updated_by' => auth()->id(),
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    DB::table('shipment_headers')
                        ->where('id', '=', $headerId)
                        ->update($updateData);

                    // ===== Delete existing items =====
                    DB::table('shipment_items')
                        ->where('shipment_header_id', '=', $headerId)
                        ->delete();

                } else {
                    // ===== INSERT new header =====
                    $headerId = DB::table('shipment_headers')->insertGetId(array(
                        'invoice_id' => $invoiceId,
                        'invoice_no' => $invoiceNo,
                        'stuffing_date' => $this->parseDate($stuffingDate),
                        'container_qty' => $containerQty,
                        'scheduled_reaching' => $this->parseDate($scheduledReaching),
                        'bl_no' => $blNo,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ));
                }

                // ===== Insert Shipment Items =====
                if (isset($data['items']) && is_array($data['items']) && !empty($data['items'])) {
                    $itemsToInsert = array();
                    
                    foreach ($data['items'] as $item) {
                        if (empty($item['item_code'])) {
                            continue;
                        }

                        $factor = isset($item['factor']) ? $item['factor'] : 0;
                        $ctnQty = isset($item['ctn_qty']) ? $item['ctn_qty'] : 0;
                        $pcsQty = $ctnQty * $factor;
                        $deliveryQty = isset($item['delivery_qty']) ? $item['delivery_qty'] : 0;
                        $pendingQty =  0;

                        // Determine status
                        // if ($pendingQty == 0 && $pcsQty > 0) {
                        //     $status = 'Delivered';
                        // } elseif ($deliveryQty > 0 && $pendingQty > 0) {
                        //     $status = 'Partial';
                        // } else {
                        //     $status = 'Pending';
                        // }

                        $status = 'Delivered';

                        $itemsToInsert[] = array(
                            'shipment_header_id' => $headerId,
                            'item_code' => $item['item_code'],
                            'item_name' => isset($item['item_name']) ? $item['item_name'] : null,
                            'hs_code' => isset($item['hs_code']) ? $item['hs_code'] : null,
                            'unit' => isset($item['unit']) ? $item['unit'] : 'PCS',
                            'factor' => $factor,
                            'ctn_qty' => $ctnQty,
                            'pcs_qty' => $pcsQty,
                            'delivery_qty' => $pcsQty,
                            'pending_qty' => 0,
                            'status' => $status,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                    }

                    if (!empty($itemsToInsert)) {
                        DB::table('shipment_items')->insert($itemsToInsert);
                    }
                }

                $savedCount++;
            }

            DB::commit();
            $message = $savedCount . ' invoice(s) updated successfully';
            return response()->json(array(
                'status' => 'success',
                'message' => $message,
                'saved' => $savedCount,
                'errors' => $errors
            ));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Shipment save error: ' . $e->getMessage(), array(
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ));

            return response()->json(array(
                'status' => 'error',
                'message' => 'Failed to save: ' . $e->getMessage()
            ), 500);
        }
    }

    private function parseDate($date)
    {
        if (empty($date)) return null;
        
        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return $date;
            }
            
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
                $parts = explode('-', $date);
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            $timestamp = strtotime($date);
            if ($timestamp) {
                return date('Y-m-d', $timestamp);
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function exportShipmentTracking(Request $request)
    {
        try {
            // Get parameters
            $partyIds = implode(',', $request->input('party_list', array()));
            $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : null;
            $toDate   = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : null;

            // Call stored procedure
            $data = collect(DB::select(
                "CALL GET_SHIPMENT_TRACKING_DATA(?,?,?)",
                array($partyIds, $fromDate, $toDate)
            ));

            // Check if data exists
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'No data found to export');
            }

            $grouped = $data->groupBy('invoice_no');
            
            // Direct Excel Download
            return Excel::create('Shipment_Tracking_'.date('YmdHis'), function ($excel) use ($grouped) {

                $excel->sheet('Shipment Tracking', function ($sheet) use ($grouped) {

                    $sheet->setOrientation('landscape');
                    $sheet->setFontFamily('Calibri');
                    $sheet->setFontSize(10);

                    $row = 1;

                    foreach ($grouped as $invoiceNo => $items) {

                        $header = $items->first();

                        //================ TITLE ==================
                        $sheet->mergeCells("A{$row}:L{$row}");
                        $sheet->row($row, array("Invoice : {$invoiceNo}"));
                        $sheet->cells("A{$row}:L{$row}", function ($cells) {
                            $cells->setBackground('#1F4E78');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setFontWeight('bold');
                            $cells->setFontSize(12);
                        });

                        $row++;

                        //================ INFORMATION =============
                        $invoiceDate = isset($header->invoice_date) ? $header->invoice_date : '';
                        $stuffingDate = isset($header->stuffing_date) ? $header->stuffing_date : '';
                        $container = isset($header->container) ? $header->container : '';
                        $blNo = isset($header->bl_no) ? $header->bl_no : '';

                        $sheet->row($row, array(
                            'Invoice Date', $invoiceDate,
                            'Stuffing Date', $stuffingDate,
                            'Container', $container,
                            'BL No', $blNo
                        ));

                        $sheet->cells("A{$row}:H{$row}", function ($cells) {
                            $cells->setBackground('#EAF2F8');
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });

                        $row++;

                        $reachingDate = isset($header->reaching_date) ? $header->reaching_date : '';
                        $actualReaching = isset($header->actual_reaching) ? $header->actual_reaching : '';
                        $cleanInGodown = isset($header->clean_in_godown) ? $header->clean_in_godown : '';
                        $startedSelling = isset($header->started_selling) ? $header->started_selling : '';

                        $sheet->row($row, array(
                            'Scheduled Reach', $reachingDate,
                            'Actual Reach', $actualReaching,
                            'Godown', $cleanInGodown,
                            'Started Selling', $startedSelling
                        ));

                        $sheet->cells("A{$row}:H{$row}", function ($cells) {
                            $cells->setBackground('#EAF2F8');
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });

                        $row += 2;

                        //================ ITEM HEADER =================
                        $sheet->row($row, array(
                            'SL', 'Product Code', 'Description', 'Factor',
                            'CTN', 'PCS', 'Delivered', 'Undelivered'
                        ));

                        $sheet->cells("A{$row}:H{$row}", function ($cells) {
                            $cells->setBackground('#D9EAD3');
                            $cells->setFontWeight('bold');
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });

                        $row++;

                        $sl = 1;
                        $totalCTN = 0;
                        $totalPCS = 0;
                        $totalDelivered = 0;
                        $totalUndelivered = 0;

                        foreach ($items as $item) {

                            $ctn = isset($item->ctn_qty) ? floatval($item->ctn_qty) : 0;
                            $pcs = isset($item->pcs_qty) ? floatval($item->pcs_qty) : 0;
                            $delivered = isset($item->delivery_qty) ? floatval($item->delivery_qty) : 0;
                            
                            // ===== FIX: Undelivered = PCS - Delivered =====
                            $undelivered = $pcs - $delivered;

                            $sheet->row($row, array(
                                $sl++,
                                isset($item->item_code) ? $item->item_code : '',
                                isset($item->item_name) ? $item->item_name : '',
                                isset($item->factor) ? $item->factor : 0,
                                $ctn,
                                $pcs,              // PCS as is from database
                                $delivered,
                                $undelivered       // ===== FIX: Calculated = PCS - Delivered =====
                            ));

                            $sheet->cells("A{$row}:H{$row}", function ($cells) {
                                $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            });

                            $totalCTN += $ctn;
                            $totalPCS += $pcs;
                            $totalDelivered += $delivered;
                            $totalUndelivered += $undelivered;

                            $row++;
                        }

                        //================ TOTAL ====================
                        $sheet->row($row, array(
                            '', '', 'TOTAL', '',
                            $totalCTN, $totalPCS, $totalDelivered, $totalUndelivered
                        ));

                        $sheet->cells("A{$row}:H{$row}", function ($cells) {
                            $cells->setBackground('#F2F2F2');
                            $cells->setFontWeight('bold');
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });

                        $row += 3;
                    }

                    //================ AUTO WIDTH =================
                    foreach (range('A', 'H') as $col) {
                        $sheet->setWidth($col, 18);
                    }
                    $sheet->setWidth('C', 45);
                });

            })->download('xlsx');

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function shipTrackingReport(Request $request){
          
        $regions = Area::whereNotIn('id', [3, 7, 17, 20])->get();
        return view('shipment_tracking.tracking_report')->with('regions',$regions); 

    }

    public function getShipTrackingData(Request $request)
    {
        try {
            
            $regionId = $request->region_id ? $request->region_id : null;
            $countryNames = $request->country_list ? implode(',', $request->country_list) : null;
            $partyIds = $request->party_list ? implode(',', $request->party_list) : null;
            $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : null;
            $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : null;
            $data = DB::select("CALL GET_SHIPMENT_STATUS_REPORT_DETAIL(?, ?, ?, ?, ?)", [
                $regionId, 
                $countryNames, 
                $partyIds, 
                $fromDate, 
                $toDate
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'total' => count($data)
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportShipmentReport(Request $request)
    {
        try {
            // ===== Get Filter Parameters (Ternary Operator) =====
            $regionId = $request->region_id ? $request->region_id : null;
            $countryNames = $request->country_list ? implode(',', $request->country_list) : null;
            $partyIds = $request->party_list ? implode(',', $request->party_list) : null;
            $fromDate = $request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : null;
            $toDate = $request->toDate ? date('Y-m-d', strtotime($request->toDate)) : null;

            // ===== Call Procedure =====
            $data = DB::select("CALL GET_SHIPMENT_STATUS_REPORT_DETAIL(?, ?, ?, ?, ?)", [
                $regionId,
                $countryNames,
                $partyIds,
                $fromDate,
                $toDate
            ]);

            // ===== Check if data exists =====
            if (empty($data)) {
                return redirect()->back()->with('error', 'No data found to export');
            }

            // ===== Group Data by Invoice =====
            $grouped = array();
            foreach ($data as $row) {
                $invoiceNo = isset($row->invoice_no) ? $row->invoice_no : 'Unknown';
                if (!isset($grouped[$invoiceNo])) {
                    $grouped[$invoiceNo] = array();
                }
                $grouped[$invoiceNo][] = $row;
            }

            // ===== Direct Excel Download =====
            return Excel::create('Shipment_Status_Report_' . date('Ymd_His'), function ($excel) use ($grouped) {

                $excel->sheet('Shipment Status Report', function ($sheet) use ($grouped) {

                    $sheet->setOrientation('landscape');
                    $sheet->setFontFamily('Calibri');
                    $sheet->setFontSize(10);

                    // ============================================================
                    // COLLECT ALL INVOICES AND ITEMS FOR PIVOT
                    // ============================================================
                    $allInvoices = array();
                    $allItems = array();
                    $invoiceMeta = array();
                    $pivotData = array();

                    foreach ($grouped as $invoiceNo => $items) {
                        $header = isset($items[0]) ? $items[0] : null;
                        $allInvoices[] = $invoiceNo;

                        $invoiceMeta[$invoiceNo] = array(
                            'invoice_date' => isset($header->invoice_date) ? $header->invoice_date : '',
                            'stuffing_date' => isset($header->stuffing_date) ? $header->stuffing_date : '',
                            'container' => isset($header->container_qty) ? $header->container_qty : '',
                            'scheduled_reaching' => isset($header->scheduled_date) ? $header->scheduled_date : '',
                            'bl_no' => isset($header->bl_no) ? $header->bl_no : '',
                            'shipment_status' => isset($header->shipment_status) ? $header->shipment_status : 'In-Transit',
                            'party_name' => isset($header->party_name) ? $header->party_name : '',
                            'party_code' => isset($header->party_code) ? $header->party_code : ''
                        );

                        foreach ($items as $item) {
                            $itemCode = isset($item->item_code) ? $item->item_code : '';
                            if (!in_array($itemCode, $allItems)) {
                                $allItems[] = $itemCode;
                            }
                            $pivotData[$itemCode][$invoiceNo] = array(
                                'ctn_qty' => isset($item->ctn_qty) ? $item->ctn_qty : 0,
                                'delivered_ctn' => isset($item->delivered_ctn) ? $item->delivered_ctn : 0,
                                'pending_ctn' => isset($item->pending_ctn) ? $item->pending_ctn : 0,
                                'item_name' => isset($item->item_name) ? $item->item_name : '',
                                'hs_code' => isset($item->hs_code) ? $item->hs_code : '',
                                'factor' => isset($item->factor) ? $item->factor : 0
                            );
                        }
                    }

                    // ============================================================
                    // HEADER SECTION (6 Rows - Like Your Report Page)
                    // ============================================================
                    $row = 1;

                    // Row 1: Invoice Numbers + TOTAL column
                    $headerRow1 = array('PRODUCT NAME', 'ITEM CODE', 'HS CODE', 'UNIT', 'FACTOR');
                    foreach ($allInvoices as $invoice) {
                        $headerRow1[] = $invoice;
                    }
                    $headerRow1[] = 'TOTAL';

                    $sheet->row($row, $headerRow1);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($headerRow1) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#1a3a6a');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setFontWeight('bold');
                        $cells->setFontSize(10);
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setAlignment('center');
                    });
                    $row++;

                    // Row 2: Stuffing Date
                    $row2 = array('Stuffing Date', '', '', '', '');
                    foreach ($allInvoices as $invoice) {
                        $meta = isset($invoiceMeta[$invoice]) ? $invoiceMeta[$invoice] : array();
                        $row2[] = isset($meta['stuffing_date']) ? $meta['stuffing_date'] : '';
                    }
                    $row2[] = '';

                    $sheet->row($row, $row2);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($row2) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#eef2f7');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setFontSize(9);
                        $cells->setAlignment('center');
                    });
                    $sheet->cells("A{$row}:A{$row}", function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('right');
                        $cells->setBackground('#eef2f7');
                    });
                    $row++;

                    // Row 3: Container
                    $row3 = array('Container', '', '', '', '');
                    foreach ($allInvoices as $invoice) {
                        $meta = isset($invoiceMeta[$invoice]) ? $invoiceMeta[$invoice] : array();
                        $row3[] = isset($meta['container']) ? $meta['container'] : '';
                    }
                    $row3[] = '';

                    $sheet->row($row, $row3);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($row3) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#eef2f7');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setFontSize(9);
                        $cells->setAlignment('center');
                    });
                    $sheet->cells("A{$row}:A{$row}", function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('right');
                        $cells->setBackground('#eef2f7');
                    });
                    $row++;

                    // Row 4: Scheduled Reaching
                    $row4 = array('Scheduled Reaching', '', '', '', '');
                    foreach ($allInvoices as $invoice) {
                        $meta = isset($invoiceMeta[$invoice]) ? $invoiceMeta[$invoice] : array();
                        $row4[] = isset($meta['scheduled_reaching']) ? $meta['scheduled_reaching'] : '';
                    }
                    $row4[] = '';

                    $sheet->row($row, $row4);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($row4) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#eef2f7');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setFontSize(9);
                        $cells->setAlignment('center');
                    });
                    $sheet->cells("A{$row}:A{$row}", function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('right');
                        $cells->setBackground('#eef2f7');
                    });
                    $row++;

                    // Row 5: BL/Booking No
                    $row5 = array('BL/Booking No', '', '', '', '');
                    foreach ($allInvoices as $invoice) {
                        $meta = isset($invoiceMeta[$invoice]) ? $invoiceMeta[$invoice] : array();
                        $row5[] = isset($meta['bl_no']) ? $meta['bl_no'] : '';
                    }
                    $row5[] = '';

                    $sheet->row($row, $row5);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($row5) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#eef2f7');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setFontSize(9);
                        $cells->setAlignment('center');
                    });
                    $sheet->cells("A{$row}:A{$row}", function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('right');
                        $cells->setBackground('#eef2f7');
                    });
                    $row++;

                    // Row 6: Status Row
                    $row6 = array('STATUS', '', '', '', '');
                    foreach ($allInvoices as $invoice) {
                        $meta = isset($invoiceMeta[$invoice]) ? $invoiceMeta[$invoice] : array();
                        $status = isset($meta['shipment_status']) ? $meta['shipment_status'] : 'In-Transit';
                        $icon = ($status == 'Reached') ? '✅' : '⏳';
                        $row6[] = $icon . ' ' . $status;
                    }
                    $row6[] = '';

                    $sheet->row($row, $row6);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($row6) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#eef2f7');
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setFontSize(9);
                        $cells->setAlignment('center');
                    });
                    $sheet->cells("A{$row}:A{$row}", function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('right');
                        $cells->setBackground('#eef2f7');
                    });

                    // Color status cells
                    $colIndex = 5;
                    foreach ($allInvoices as $invoice) {
                        $meta = isset($invoiceMeta[$invoice]) ? $invoiceMeta[$invoice] : array();
                        $status = isset($meta['shipment_status']) ? $meta['shipment_status'] : 'In-Transit';
                        $statusColor = ($status == 'Reached') ? '#e8f5e9' : '#fff3e0';
                        $col = $this->getExcelColumn($colIndex);
                        $sheet->cells("{$col}{$row}:{$col}{$row}", function ($cells) use ($statusColor) {
                            $cells->setBackground($statusColor);
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                        });
                        $colIndex++;
                    }
                    $row++;

                    // ============================================================
                    // BODY - ITEM ROWS (Unit = CTN)
                    // ============================================================
                    $grandTotalCtn = 0;
                    $invoiceTotals = array();
                    foreach ($allInvoices as $invoice) {
                        $invoiceTotals[$invoice] = 0;
                    }

                    foreach ($allItems as $itemCode) {
                        $itemInfo = isset($pivotData[$itemCode]) ? $pivotData[$itemCode] : array();
                        $firstItem = reset($itemInfo);
                        $itemName = isset($firstItem['item_name']) ? $firstItem['item_name'] : $itemCode;
                        $hsCode = isset($firstItem['hs_code']) ? $firstItem['hs_code'] : '';
                        $factor = isset($firstItem['factor']) ? $firstItem['factor'] : 0;

                        // ===== UNIT DEFAULT CTN =====
                        $rowData = array($itemName, $itemCode, $hsCode, 'CTN', $factor);
                        $totalCtn = 0;

                        foreach ($allInvoices as $invoice) {
                            $cellData = isset($itemInfo[$invoice]) ? $itemInfo[$invoice] : null;
                            $ctn = ($cellData && isset($cellData['ctn_qty'])) ? $cellData['ctn_qty'] : 0;
                            $delivered = ($cellData && isset($cellData['delivered_ctn'])) ? $cellData['delivered_ctn'] : 0;
                            $pending = ($cellData && isset($cellData['pending_ctn'])) ? $cellData['pending_ctn'] : 0;

                            $rowData[] = $ctn;
                            $totalCtn += $ctn;
                            $invoiceTotals[$invoice] += $ctn;
                        }

                        $rowData[] = $totalCtn;
                        $grandTotalCtn += $totalCtn;

                        $sheet->row($row, $rowData);
                        $sheet->cells("A{$row}:" . $this->getExcelColumn(count($rowData) - 1) . "{$row}", function ($cells) {
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            $cells->setFontSize(10);
                        });

                        // Color CTN cells based on status
                        $colIndex = 5;
                        foreach ($allInvoices as $invoice) {
                            $cellData = isset($itemInfo[$invoice]) ? $itemInfo[$invoice] : null;
                            $delivered = ($cellData && isset($cellData['delivered_ctn'])) ? $cellData['delivered_ctn'] : 0;
                            $pending = ($cellData && isset($cellData['pending_ctn'])) ? $cellData['pending_ctn'] : 0;

                            $bgColor = ($pending == 0) ? '#e8f5e9' : (($delivered > 0) ? '#fff3e0' : '#fce4ec');
                            $textColor = ($pending == 0) ? '#2e7d32' : (($delivered > 0) ? '#e65100' : '#c62828');
                            $col = $this->getExcelColumn($colIndex);
                            $sheet->cells("{$col}{$row}:{$col}{$row}", function ($cells) use ($bgColor, $textColor) {
                                $cells->setBackground($bgColor);
                                $cells->setFontColor($textColor);
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });
                            $colIndex++;
                        }
                        $row++;
                    }

                    // ============================================================
                    // GRAND TOTAL ROW
                    // ============================================================
                    $grandRow = array('GRAND TOTAL', '', '', '', '');
                    foreach ($allInvoices as $invoice) {
                        $grandRow[] = isset($invoiceTotals[$invoice]) ? $invoiceTotals[$invoice] : 0;
                    }
                    $grandRow[] = $grandTotalCtn;

                    $sheet->row($row, $grandRow);
                    $sheet->cells("A{$row}:" . $this->getExcelColumn(count($grandRow) - 1) . "{$row}", function ($cells) {
                        $cells->setBackground('#0b2a4a');
                        $cells->setFontColor('#ffd700');
                        $cells->setFontWeight('bold');
                        $cells->setFontSize(11);
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        $cells->setAlignment('center');
                    });

                    // ============================================================
                    // COLUMN WIDTHS
                    // ============================================================
                    $sheet->setWidth('A', 30);  // Product Name
                    $sheet->setWidth('B', 18);  // Item Code
                    $sheet->setWidth('C', 15);  // HS Code
                    $sheet->setWidth('D', 10);  // Unit (CTN)
                    $sheet->setWidth('E', 12);  // Factor

                    // Set dynamic column widths for invoices
                    $colIndex = 5;
                    foreach ($allInvoices as $invoice) {
                        $col = $this->getExcelColumn($colIndex);
                        $sheet->setWidth($col, 15);
                        $colIndex++;
                    }
                    $sheet->setWidth($this->getExcelColumn($colIndex), 15); // Total column

                });

            })->download('xlsx');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }


    // ============================================================
    // HELPER FUNCTION: Get Excel Column Letter
    // ============================================================
    private function getExcelColumn($index)
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($index < 26) {
            return $letters[$index];
        }
        return $letters[floor($index / 26) - 1] . $letters[$index % 26];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
