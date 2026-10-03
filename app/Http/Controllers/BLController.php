<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SaleContract;
use DB;
use App\BlCopy;
use App\POMaster;
use Session;
use Auth;
use App\seaPortdashboard;
use App\LandPortDashboard;
use Excel;
class BLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        return view('bl.index');
    }

    public function getBlInvoiceList(){

        $results=DB::select("SELECT id,invoice_no
            FROM sale_contracts
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            and sale_contracts.inactive='N'");
       
        return response()->json([
            'results'=>$results
        ]);

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

        return $this->uploadBLAttachedDocument($request,$request->input('invoice_id'));

    }


    public function uploadBLAttachedDocument($request,$invoice_id){
       
        $sales_contract=SaleContract::where('id',$invoice_id)->first(['invoice_no','id']);
        if(BlCopy::where('sc_id',$invoice_id)->count()>0){
            return response()->json(
                [
                    'msg' => 'File already exists',
                    'status' => 409,
                ]
            );
        } 
        if($request->hasFile('files')){

            foreach ($request->file('files') as $file) {

                $filePath = $file->getRealPath();
                $fileName = $file->getClientOriginalName();
                $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
                $cFile->setPostFilename($fileName); // Set filename for cURL
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://rqc.rflgroupbd.com:8016/upload/bl', // Endpoint URL
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'file' => $cFile,
                        'inv_no' => $sales_contract->invoice_no // Pass invoice as a POST parameter
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: multipart/form-data'
                    ),
                ));

                $response = curl_exec($curl);
                $responseData = json_decode($response, true);
                $status = $responseData['status'];
                if($status==200){
                    
                    $blCopy=new BlCopy();
                    $blCopy->sc_id=$sales_contract->id;
                    $blCopy->invoice= $sales_contract->invoice_no;
                    $blCopy->file_name=$responseData['file_path'];
                    $blCopy->rcv_date=date('Y-m-d', strtotime('-1 day'));
                    $blCopy->bl_type=$request->bl_type;
                    $blCopy->remark=$request->remark;
                    $blCopy->iuser=Auth::user()->id;
                    $blCopy->save();
                    $this->sendDraftBlApi($blCopy->id, $sales_contract->invoice_no, $responseData['file_path']);   
                    $saleContract=SaleContract::where('id',$sales_contract->id)->first(['id','po_number']);    
                    if($saleContract->po_number){
            
                        if(POMaster::where('PO_NO',$saleContract->po_number)->count()>0){
                             
                            $poMaster=POMaster::where('PO_NO',$saleContract->po_number)->first(['id','TEMPLATE_ID']);
                            if($poMaster->TEMPLATE_ID==1){
                                
                                if(LandPortDashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->count()>0){
                                    
                                    $landPortDash=LandPortDashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->first(['action_date']);
                                    if(is_null($landPortDash->action_date)){
                                    
                                        LandPortDashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->update([
                                            'action_date'=>date('Y-m-d', strtotime('-1 day')) 
                                        ]);

                                    }

                                }
                                
                            }elseif($poMaster->TEMPLATE_ID==3) {
                                
                                if(seaPortdashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->count()>0){

                                    $seaPortDash=seaPortdashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->first(['action_date']);
                                    if(is_null($seaPortDash->action_date)){
                                    
                                        seaPortdashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->update([
                                            'action_date'=>date('Y-m-d', strtotime('-1 day'))
                                        ]);
                    
                                    } 

                                }

                            }

                        } 

                    } 
                    
                }

                $error = curl_error($curl);
                curl_close($curl);
            }

            if($blCopy){

                return response()->json(
                [
                    'msg' => 'File uploaded successfully',
                    'status' => 200,
                ]);  

            }
            
        }else{

            return "No File";

        }
        
    }


    private function sendDraftBlApi($blCopyId, $invoice_no, $file_path)
    {
        $curl = curl_init();
        $base_url='http://rqc.rflgroupbd.com:8016/storage/'.$file_path;
        $postData = json_encode([
            "invoice_no" => $invoice_no,
            "preview_link" => $base_url,
            "notes" => ""
        ]);

        //Basic Auth
        $username = "auth";
        $password = "12Pran@123456$";

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crm.prangroup.com/api/job-orders/draft-bl',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_USERPWD => $username . ':' . $password, // Add Basic Auth
        CURLOPT_HTTPHEADER => array(
            'ss: order_list',
            'yy: HJDyh876Yhdsf543GFOYSAL',
            'Content-Type: application/json',
            'Accept: application/json',
            'Cookie: XSRF-TOKEN=eyJpdiI6InQyRGhjQnRKT2VjZktuYXltcDVKbHc9PSIsInZhbHVlIjoiQjNsWmNlNDBHcTRBSjNBTm5DT3pYU2tMc3JESURDek05TnJ2T3JLS1czcEttajRNcDNaYS9yU2pWMW9hT1F3WEN4Tm5zYzF5eVc1UDMvdGlnNGdUOTUrWDd1a1BtZnZUTTdacGdPTzBkenRqMGMzUVg3SkNJcytudEJMc0ZwSWEiLCJtYWMiOiI4MmIzZWI2MjVkY2YyOGU5ODk2Y2VjYjQ4YTI1NTEwOGE5MjE0YjYxMWY2YWM2YmNmODNkOTIxMzg5NDU5MzEwIiwidGFnIjoiIn0%3D; crm_session=eyJpdiI6InpjK0NZdS9mR3pwWFFpUlVBRUVkUEE9PSIsInZhbHVlIjoiUUpxTDlySG9UV3NDUEpiMFVSam9kSnlwZUlydm9GcjNTVWpsRzZyWnlpL1pNVW1qYzI3VXVlT0M5TXN5MVRmdW5mS1h0VUlUUlFUTkQyZEZuRDBDZDY3ZEMwOVhwRU5OWmlHODBCUmdoS2RsWE9oVnBpYlFaV3NxTWhXanI4OFoiLCJtYWMiOiIwYWJlMTkxMTU2Y2QxZjVjZDc5MTM4NWM3YmZkNjg0MTIxNGQ1MTkxMjliNjliY2QyYmIyZDNkZGFmMTExNjE3IiwidGFnIjoiIn0%3D'
        ),
        ));
    
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $responseData = json_decode($response, true);
        $blCopy = BlCopy::find($blCopyId);
        if($blCopy){
            $blCopy->api_status = $responseData['status'] ? $responseData['status'] : 'failed';
            $blCopy->api_response = $responseData['message'] ? $responseData['message'] :  $response;
            $blCopy->base_url = $base_url;
            $blCopy->save();
        }
    }

    public function searchBLCopy(Request $request){
       
        $searchTerm=$request->inv_no; 
        $results = BlCopy::where('invoice', 'like', '%' . $searchTerm . '%')
                  ->select('invoice', 'file_name')
                  ->get();

        return response()->json([
            'results'=>$results
        ]);          

    }

    public function blExcelView(Request $request)
    {
        return view('bl.bl_excel');

    }

    public function uploadBlExcel(Request $request){
       
        $formated_file = $request->file('file');
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->upload_BL_Excel($datas);
        Session::flash("success", "Upload Succcessfully..!");
        return redirect("/bl_excel");

    }

    private function upload_BL_Excel($datas){

        $user_id=Auth::user()->id;  
        foreach($datas as $key => $value){

            $bl_date=SaleContract::where('invoice_no',trim($value->invoice_no))->whereNull('bl_date')->count();    
            if($bl_date>0){

                $sales_contract=SaleContract::where('invoice_no',trim($value->invoice_no))->first(['id','po_number']);
                if(POMaster::where('PO_NO',$sales_contract->po_number)->count()>0){
                     
                    $poMaster=POMaster::where('PO_NO',$sales_contract->po_number)->first(['id','TEMPLATE_ID']);
                    if($poMaster->TEMPLATE_ID==1){
                        
                        if(LandPortDashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->count()>0){
                            
                            $landPortDash=LandPortDashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->first(['action_date']);
                            if(is_null($landPortDash->action_date)){
                            
                                LandPortDashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->update([
                                    'action_date'=>date('Y-m-d', strtotime('-1 day')) 
                                ]);

                            }

                        }
                        
                    }elseif($poMaster->TEMPLATE_ID==3) {
                        
                        if(seaPortdashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->count()>0){

                            $seaPortDash=seaPortdashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->first(['action_date']);
                            if(is_null($seaPortDash->action_date)){
                            
                                seaPortdashboard::where('sc_id',$sales_contract->id)->where('Task_ID',20)->update([
                                    'action_date'=>date('Y-m-d', strtotime('-1 day'))
                                ]);
            
                            } 

                        }

                    }

                }

                DB::table('sale_contracts')->where('id',$sales_contract->id)->update([
                    'bl_date'=>date('Y-m-d', strtotime($value->bl_date))
                ]);

            } 
       
        }

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

    public function blReport(){

        return view('bl.report');
    }
    
    public function getBLReportData(Request $request){
        
        $from_date=NULL; 
        if($request->from_date){
           
            $from_date=date("Y-m-d", strtotime($request->from_date));
            
        } 

        $to_date=NULL;
        if($request->to_date){
           
            $to_date=date("Y-m-d", strtotime($request->to_date));
 
        }
        $results=DB::select("select
            date_format(bl_copies.rcv_date,'%d-%m-%Y') as rcv_date,
            sale_contracts.invoice_no,
            date_format(sale_contracts.invoice_date,'%d-%m-%Y') as invoice_date,
            notify_parties.name as party,
            companies.code as company,
            notify_parties.country,
            ROUND(sale_contracts.total_ci_value,2) as ci_value,
            banks.short_name as bank,
            if(sale_contracts.bl_date,date_format(sale_contracts.bl_date,'%d-%m-%Y'),'') as ship_on_board,
            bl_copies.bl_type,
            if(bl_copies.remark,bl_copies.remark,'') as remark
        from bl_copies
        join sale_contracts on sale_contracts.id = bl_copies.sc_id
        join notify_parties on notify_parties.id=sale_contracts.notify_pary_id
        join companies on companies.id=sale_contracts.company_id
        join banks on banks.id=sale_contracts.bank_id
        where bl_copies.rcv_date>='$from_date' and bl_copies.rcv_date<='$to_date'
        group by sale_contracts.invoice_no,sale_contracts.invoice_date");

        return response()->json([
            'results'=>$results
        ],200);

    }

}
