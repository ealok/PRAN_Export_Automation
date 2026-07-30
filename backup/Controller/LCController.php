<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Excel;
use App\LC;
use Session;
use App\DeliverType;
use App\Lcc3;
use App\ApproveType;
use App\Production;
use Mail;
use App\ProdEntry;
use DB;
use App\MonthlyTarget;
use App\MonthlyStatus;
class LCController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function getViewForLcUpload(){

       if($request->ouId=="All" || $request->ouId==""){
             
            $list_of_lc=LC::all();
            $list_of_lc=\DB::select("SELECT * FROM `productions`");
            $ous=DB::select("SELECT DISTINCT `location` FROM productions Order By location ASC");
            return view('dashboard_lc')
                   ->with('list_of_lc',$list_of_lc)
                   ->with('ous',$ous); 

        }else{

            $list_of_lc=LC::all();
            return $list_of_lc=\DB::select("SELECT * FROM `productions` where location='$request->ouId'");
            $ous=DB::select("SELECT DISTINCT `location` FROM productions Order By location ASC");
            return view('dashboard_lc')
                   ->with('list_of_lc',$list_of_lc)
                   ->with('ous',$ous);  


        } 
       return view('lc.lc_upload_view');

    }

    public function uploadLcData(Request $request){

        $formated_file = $request->file('formated_file');
        $this->validate($request, [
        
           "formated_file"=>"required",
        ]);   
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        LC::truncate(); 
        $this->save_excel($datas);
        Session::flash("success", "Upload Succcessfully !");
        return redirect("/lc/upload/view");

    }

    public function save_excel($datas){
         
        foreach ($datas as $key => $value){
        
            // $LC=new Lcc2();
            // $LC->REQ_ID=$value->req_id;
            // $LC->U_OU=$value->u_ou;
            // $LC->BUYER=$value->buyer;
            // $LC->RA_DT=$value->ra_dt;
            // $LC->R_NUM=$value->r_num;
            // $LC->LINE=$value->line;
            // $LC->ITEM=$value->item;
            // $LC->UOM=$value->uom;
            // $LC->QTY=$value->qty;
            // $LC->T_RATE=$value->t_rate;
            // $LC->T_VALUE=$value->t_value;
            // $LC->CUR=$value->cur;
            // $LC->V_OU=$value->v_ou;
            // $LC->VA_DT=$value->va_dt;
            // $LC->F_BANK=$value->f_bank;
            // $LC->FA_DT=$value->fa_dt;
            // $LC->LC_NO=$value->lc_no;
            // $LC->LC_FILE_NO=$value->lc_file_no;
            // $LC->LC_SDT=$value->lc_sdt;
            // $LC->ETA=$value->eta;
            // $LC->ETD=$value->etd;
            // $LC->DPAY_DT=$value->dpay_dt;
            // $LC->BSEND_DT=$value->bsend_dt;
            // $LC->BSUB_DT=$value->bsub_dt;
            // $LC->save(); 


        }
        

    }

    public function jsonGetDeliveryType(Request $request,$id){

       $array1=array();
       $lcc=Lcc3::where('REQ_ID',$id)->first();
       $deliveryTypeId=$lcc->delivery_type_id;
       $approve_type=$lcc->approve_type;
       $singleDeliveryType=DeliverType::where('id',$deliveryTypeId)->get();
       $loadStatus=0;
       if(count($singleDeliveryType)>0){
            
          $loadStatus=1;  
          foreach($singleDeliveryType as $value){

            $array1[] = array('id' => $value->id, 'name' =>$value->name);

          }

          $deliveryTypes=DeliverType::all();

          foreach($deliveryTypes as $value){

              if($value->id!=$deliveryTypeId){

                $array1[] = array('id' => $value->id, 'name' =>$value->name); 

              }

          }

       }else{

         $loadStatus=2; 
         $deliveryTypes=DeliverType::all();
         foreach($deliveryTypes as $value){

              if($value->id==$deliveryTypeId){

                $array1[] = array('id' => $value->id, 'name' =>$value->name); 

              }else{

                $array1[] = array('id' => $value->id, 'name' =>$value->name); 
              }

          }


       }
       return $array=array('delivery_types'=>$array1,'approve_type'=>$approve_type,'loadStatus'=>$loadStatus);

    }

    public function saveLcHistoryData(Request $request){
       
          $curl = curl_init();
          curl_setopt_array($curl, array(
              CURLOPT_URL => "https://runner.prangroup.com:4001/elc/api/ELcMaster/getLcMaster",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
          ));

          $response = curl_exec($curl);
          $x= json_decode($response,true);
          foreach ($x as $key => $value) {
            
            $existOrNot=Lcc3::where('REQ_ID',$value['REQ_VAT_ID'])->first();
            if(!$existOrNot){

                $LC=new Lcc3();
                $LC->REQ_ID=$value['REQ_VAT_ID'];
                $LC->U_OU=$value['USER_OU_NAME'];
                $LC->BUYER=$value['ALLOCATE_BUYER'];
                $LC->RA_DT=date("Y-m-d", strtotime($value['RA_DT']));
                $LC->R_NUM=$value['REQ_NO'];
                $LC->ITEM=$value['ITEM_NAME'];
                $LC->UOM=$value['UOM'];
                $LC->QTY=$value['QTY'];
                $LC->T_RATE=$value['RAT'];
                $LC->T_VALUE=$value['AMNT'];
                $LC->CUR=$value['CURR'];
                $LC->V_OU=$value['VT_OU_NAME'];
                $LC->VA_DT=$value['VA_DT'];
                $LC->F_BANK=$value['FA_BANK_AC'];
                $LC->FA_DT=$value['FA_DT'];
                $LC->LC_NO=$value['LC_NO'];
                $LC->LC_FILE_NO=$value['LC_FILE_NO'];
                $LC->LC_SDT=$value['LC_SDT'];
                $LC->ETA=$value['ETA'];
                $LC->ETD=$value['ETD'];
                $LC->DPAY_DT=$value['DPAY_DT'];
                $LC->BSEND_DT=$value['BSEND_DT'];
                $LC->TNT=$value['TNT'];
                $LC->STOK=$value['STOK'];
                $LC->TYP=$value['TYP'];
                $LC->VEN_NAME=$value['VEN_NAME'];
                $LC->FND_BU_OWN=$value['FND_BU_OWN'];
                $LC->LC_STATUS=$value['LC_STATUS'];
                $LC->ED_APPROVED=$value['ATTRIBUTE20'];
                $LC->ED_APPROVED_DATE=$value['ATTRIBUTE18'];
                $LC->save();


              }else{
                   
                  $LC=Lcc3::findorfail($existOrNot->id);
                  $LC->REQ_ID=$value['REQ_VAT_ID'];
                  $LC->U_OU=$value['USER_OU_NAME'];
                  $LC->BUYER=$value['ALLOCATE_BUYER'];
                  $LC->RA_DT=date("Y-m-d", strtotime($value['RA_DT']));
                  $LC->R_NUM=$value['REQ_NO'];
                  $LC->ITEM=$value['ITEM_NAME'];
                  $LC->UOM=$value['UOM'];
                  $LC->QTY=$value['QTY'];
                  $LC->T_RATE=$value['RAT'];
                  $LC->T_VALUE=$value['AMNT'];
                  $LC->CUR=$value['CURR'];
                  $LC->V_OU=$value['VT_OU_NAME'];
                  $LC->VA_DT=$value['VA_DT'];
                  $LC->F_BANK=$value['FA_BANK_AC'];
                  $LC->FA_DT=$value['FA_DT'];
                  $LC->LC_NO=$value['LC_NO'];
                  $LC->LC_FILE_NO=$value['LC_FILE_NO'];
                  $LC->LC_SDT=$value['LC_SDT'];
                  $LC->ETA=$value['ETA'];
                  $LC->ETD=$value['ETD'];
                  $LC->DPAY_DT=$value['DPAY_DT'];
                  $LC->BSEND_DT=$value['BSEND_DT'];
                  $LC->TNT=$value['TNT'];
                  $LC->STOK=$value['STOK'];
                  $LC->TYP=$value['TYP'];
                  $LC->VEN_NAME=$value['VEN_NAME'];
                  $LC->FND_BU_OWN=$value['FND_BU_OWN'];
                  $LC->LC_STATUS=$value['LC_STATUS'];
                  $LC->ED_APPROVED=$value['ATTRIBUTE20'];
                  $LC->ED_APPROVED_DATE=$value['ATTRIBUTE18'];
                  $LC->save(); 

              } 
            

          }
        

    }

    public function saveMonthlyHistoryData(){
      
      $total_monthly_target = MonthlyTarget::OrderBy('id','desc')->first()->target;
      $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
      $last_day_this_month  = date('Y-m-t'); 
      $prod_entries=ProdEntry::select(DB::raw('SUM(prod_entries.production_qty) as production_qty'),DB::raw('SUM(prod_entries.hourly_target) as target_qty') )
             ->join('order_styles','order_styles.id','prod_entries.order_style_id')
             ->join('lines','lines.id','prod_entries.line_id')
             ->join('units','units.id','lines.unit_id')
             ->where('prod_entries.created_at', '>=',$first_day_this_month)
             ->where('prod_entries.created_at', '<=',$last_day_this_month)
             ->get();

      $asoftoday_target=$prod_entries->first()->target_qty;
      $asoftoday_prod=$prod_entries->first()->production_qty;
      $asof_today_target_percent=round(($asoftoday_target*100/$total_monthly_target),2);
      $asof_today_prod_percent=round(($asoftoday_prod*100/$total_monthly_target),2);
      $percent=round($asoftoday_prod*100/$asoftoday_target,2);
      $status=-1;
      if($percent>90){

        $status=0;

      }elseif($percent>=100) {
        
        $status=2;        

      }
      
      $monthlyStatus=new MonthlyStatus();
      $monthlyStatus->monthy_target=$total_monthly_target;
      $monthlyStatus->asoftoday_target=$asoftoday_target;
      $monthlyStatus->asoftoday_target_percent=$asof_today_target_percent;
      $monthlyStatus->asoftoday_prod=$asoftoday_prod;
      $monthlyStatus->asoftoday_prod_percent=$asof_today_prod_percent;
      $monthlyStatus->create_date=date("Y-m-d");
      $monthlyStatus->status=$status;
      $monthlyStatus->save();
    }

    public function jsonUpdateLcDetails(Request $request){
        
        $checkEdApproved=Lcc3::where('REQ_ID',$request->ou)->first(['ed_approve_date']);
        if(!is_null($checkEdApproved->ed_approve_date)){
           
          return $array=array('status'=>'exist');

        }
        $OU_ID=$request->ou;
        $lcc=Lcc3::where('REQ_ID',$request->ou)->first();
        $bu_own=$lcc->FND_BU_OWN;
        $deliveryTypes=DeliverType::where('id',$request->type_id)->first();
        $deliveryType=$deliveryTypes->name;
        $ed_comments=$request->ed_comments;    
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://server.prangroup.com:8440/mywebapi/api/ELcMaster",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"[\"update XXPRG_POLCBANK_DETAILS_VAT  vt\r\nset\r\nvt.ATTRIBUTE17 = '".$bu_own."',\r\nvt.ATTRIBUTE19 = '".$ed_comments."',\r\nvt.ATTRIBUTE20 = '".$deliveryType."',\r\nvt.ATTRIBUTE24 = '".''."',\r\nvt.ATTRIBUTE18 = sysdate\r\nwhere vt.REQ_VAT_ID='".$OU_ID."'\"]",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        if(!empty($response)){

            $date=date('Y-m-d');
            $approve_date=date("Y-m-d", strtotime($date));  
                  $result =\DB::table('l_c_s_3')
                    ->where('REQ_ID', $request->ou)
                    ->update([
                        'delivery_type_id' => $request->type_id,
                        'ed_approve_date' =>$approve_date
                    ]);   

            if($result==true){
                
               return $array=array('status'=>'success');

            }else{

               return $array=array('status'=>'fail');
            }  

        }else{

          return $array=array('status'=>'fail');
             
        }

    }

    public function jsonUpdateFcDetails(Request $request){
         
        $checkEdApproved=Lcc3::where('REQ_ID',$request->ou)->first(['fc_approve']);
        if(!is_null($checkEdApproved->fc_approve)){
            
          return $array=array('status'=>'exist');

        }
        $approve_type=$request->fc_approve;
        $fc_comments=$request->fc_comments;
        $OU_ID=$request->ou;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://server.prangroup.com:8440/mywebapi/api/ELcMaster",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"[\"update XXPRG_POLCBANK_DETAILS_VAT\r\nSET ATTRIBUTE23 = '".$approve_type."',\r\nATTRIBUTE25 = '".$fc_comments."',\r\nATTRIBUTE22 = '".''."',\r\nATTRIBUTE21 = sysdate\r\nwhere REQ_VAT_ID ='".$OU_ID."'\"]",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if(!empty($response)){

            $result =\DB::table('l_c_s_3')
                    ->where('REQ_ID', $request->ou)
                    ->update([
                        'fc_approve' => $request->fc_approve,
                        'fc_comments' =>$request->fc_comments
                    ]);
            
            if($result==true){
                
               return $array=array('status'=>'success');

            }else{

               return $array=array('status'=>'fail');
            }   

        }else{

            return $array=array('status'=>'fail');
             
        }


    } 


}
