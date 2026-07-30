<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\SaleContract;
use App\NotifyParty;
use App\User;
use App\POMaster;
use GuzzleHttp\Client;
use Mail;
use Auth;
use DB;
class GTDocApprovalController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
 
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=Auth::user()->id;
        $notifyParties=DB::select("select notify_parties.id,notify_parties.code,notify_parties.name
                    from notify_parties
                    join notify_party_users on notify_party_users.notify_party_id=notify_parties.id
                    where notify_party_users.user_id='$user_id'");
        return view('sale_contract.po.doc_approval',compact('notifyParties'));

    }

    public function getGtOrderlList(Request $request){
       
        $results=DB::select("SELECT
            po_master.ID as id,
            CONCAT(notify_parties.code,'-',notify_parties.name) AS party,
            notify_parties.country as country,
            po_master.PO_NO as po_no,
            po_master.REF_PO_NO as buyer_po,
            SUM(po_item_details.order_qty_ctn) AS order_qty,
            po_master.PO_DATE as order_date,
            CASE WHEN po_master.GT_STATUS='N' THEN 'Not Rcv'
                 WHEN po_master.GT_STATUS='R' THEN 'Rcv'
                 WHEN po_master.GT_STATUS='P' THEN 'Proced'
                 WHEN po_master.GT_STATUS='C' THEN 'Cancel'
            END AS status,
            CASE WHEN po_master.GT_DOC_REF is not null then gt_doc_ref else '' end as gt_doc_ref
            FROM po_master
            JOIN po_item_details on po_item_details.master_id=po_master.ID
            JOIN notify_parties ON notify_parties.id = po_master.PARTY_ID
            WHERE notify_parties.code='$request->party_code' AND APPROVED_STATUS='Y' AND po_item_details.status='Y' AND po_master.ORDER_TYPE=2
                GROUP BY po_master.ID,po_master.PO_NO,po_master.PO_DATE,po_master.APPROVED_STATUS,notify_parties.code,
                notify_parties.name,po_master.ORDER_TYPE,po_master.ORDER_STATUS,notify_parties.country,po_master.REF_PO_NO,
                po_master.GT_DOC_REF,po_master.GT_STATUS
            ORDER BY po_master.ID DESC");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }

    }

    public function receivedGtOrder(Request $request){
          
        $result=POMaster::where('id',$request->order_id)->update([
            'GT_STATUS'=>'R',
            'UPDATED_BY'=>Auth::user()->id,
            'UPDATED_DATE'=>date('Y-m-d'),
        ]);
        if($result) {

            return response()->json([
                'message' => "Successfully Received",
                "code"    => 200
            ]);

        }else{

            return response()->json([
                'message' => "Received Failed",
                "code"    => 500,
            ]);

        }  
 
    }
    public function procedGtOrder(Request $request){
        
        $file_path="";
        $stage="proced";
        $cancel_note="";
        if($request->hasFile('attachment')) { // Check for a single file input

            $file = $request->file('attachment'); // Get the file
            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName();
            $cFile = new \CURLFile($filePath, $file->getClientMimeType(), $fileName);
            $cFile->setPostFilename($fileName); // Set filename for cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://rqc.rflgroupbd.com:8016/gt_attach/upload', // Endpoint URL
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'file' => $cFile
                ),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: multipart/form-data'
                ),
            ));
    
            $response = curl_exec($curl);
            $responseData = json_decode($response, true);
            $status = $responseData['status'];
            $error = curl_error($curl);
            curl_close($curl);
            if ($status == 200) {

                $file_path=$responseData['file_path'];
                
            }

        }
        $result=POMaster::where('id',$request->order_id)->update([
            'GT_STATUS'=>'P',
            'UPDATED_BY'=>Auth::user()->id,
            'UPDATED_DATE'=>date('Y-m-d'),
            'GT_DOC_REF'=>$file_path
        ]);
        $this->gtOrderUpdateNotifictionMail($request->order_id,$stage,$cancel_note,$file_path);
        if($result){
            $this->gtOrderUpdateNotifictionMail($request->order_id,$stage,$cancel_note,$file_path);
            return response()->json([
                'message' => "Proced Done..!!",
                "code"    => 200
            ]);
        }else{
            return response()->json([
                'message' => "Proced Failed",
                "code"    => 500,
            ]);
        }
        
    }

    public function cancelGtOrder(Request $request){

        $stage="cancel";
        $file_path="";
        $cancel_note=$request->cancel_note;
        $result=POMaster::where('id',$request->order_id)->update([
            'GT_STATUS'=>'C',
            'UPDATED_BY'=>Auth::user()->id,
            'UPDATED_DATE'=>date('Y-m-d'),
            'CANCEL_NOTE'=>$cancel_note
        ]);

        if($result){
            $this->gtOrderUpdateNotifictionMail($request->order_id,$stage,$cancel_note,$file_path);
            return response()->json([
                'message' => "Cancel Done",
                "code"    => 200
            ]);

        }else{

            return response()->json([
                'message' => "Cancel Failed",
                "code"    => 500,
            ]);

        }  

    }
    
    private function gtOrderUpdateNotifictionMail($order_id,$stage,$cancel_note,$file_path){
         
           
        $orderInfo = DB::table('po_master')
                ->join('notify_parties', 'notify_parties.id', '=', 'po_master.PARTY_ID')
                ->where('po_master.ID', $order_id)
                ->select(
                    DB::raw("CONCAT(notify_parties.code, '-', notify_parties.name) AS party"),
                    'notify_parties.country as country',
                    'po_master.PO_NO as po_no',
                    'po_master.REF_PO_NO as buyer_po',
                    'po_master.PO_DATE as po_date'
                )->first();

        $orderDetails=DB::select("SELECT
                ci_items.ci_item_code AS item_code,
                ci_items.ci_item_name AS item_name,
                ci_items.factor AS unit_per_ctn,
                npi.acc_rate AS purchase_rate,
                npi.party_rate AS sales_rate,
                po_item_details.order_qty_ctn AS order_qty,
                po_item_details.order_qty_ctn * npi.party_rate AS value,
                po_item_details.coding_matter AS coding_matter,
                po_item_details.special_requirement AS special_requirement,
                po_item_details.specifition AS remarks
            FROM po_master
            JOIN po_item_details ON po_item_details.master_id = po_master.ID
            JOIN ci_items ON ci_items.id = po_item_details.item_id
            JOIN notify_party_items npi ON npi.notify_party_id = po_master.PARTY_ID AND npi.ci_item_id = ci_items.id
            WHERE po_master.ID = $order_id AND po_item_details.status='Y'");

        $po_master=POMaster::where('id',$order_id)->value('APPROVED_BY');
        $data = array(
            'orderInfo'=>$orderInfo,
            'orderDetails'=>$orderDetails,
            'stage'=>$stage,
            'cancel_note'=>$cancel_note,
            'user'=>User::where('id',Auth::user()->id)->first(),
            'file_path'=>$file_path,
            'to_mail'=>User::where('id',POMaster::where('ID',$order_id)->value('APPROVED_BY'))->value('email'),
            'cc_mail'=>Auth::user()->email,
            'subject'=>"GT Order Update Notification");

        $from_mail=env('MAIL_FROM_ADDRESS');
        try {

            Mail::send('mail.gt_order_notification_template', $data, function($message) use ($from_mail,$data){
                $message->from($from_mail, 'GTOrderNotification@prangroup.com');
                $message->to($data['to_mail']);
                $message->cc($data['cc_mail']);  // Pass the correct email as cc
                $message->subject($data['subject']);
            });

            return 'Mail sent successfully';

        } catch (\Exception $e) {

            return 'Mail failed to send. Error: ' . $e->getMessage();

        }
        

    }

    public function downloadFile(Request $request){

        
        $docRef = $request->input('docRef');
        $fileUrl = "http://localhost:8082/storage/" . $docRef;
    
        // Initialize cURL session
        $ch = curl_init();
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $fileUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects if any
        curl_setopt($ch, CURLOPT_HEADER, false); // Exclude headers from the response
    
        // Execute cURL session and get the file content
        $fileContent = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            return response()->json(['error' => 'File not found or error occurred: ' . curl_error($ch)], 404);
        }
    
        // Specify the file path where you want to save the file
        $savePath = public_path('downloads/' . basename($fileUrl));
    
        // Save the file to the specified path
        file_put_contents($savePath, $fileContent);
    
        // Close the cURL session
        curl_close($ch);
    
        // Return the file path or send the file to the user for download
        return response()->download($savePath);
        
       

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
