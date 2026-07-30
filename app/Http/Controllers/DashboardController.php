<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\SaleContract;
use App\LandPortDashboard;
use App\seaPortdashboard;
use App\JobOrderMaster;
use App\NotifyParty;
use Mail;
class DashboardController extends Controller
{
 
   public function tnaDashboard(){

      return view('dashboard.tna_dashboard'); 

   }

   public function globalOrderMonitoringBoard(){
      
      // return view('dashboard.global_order'); 
      return view('tna_mail_template'); 

   }


   public function jsonLoadTNAData(){

      $land_Port_history=DB::select("CALL TNA_LAND_PORT_HISTORY()");
      $see_Port_history=DB::select("CALL TNA_SEE_PORT_HISTORY()");
      $land_menu_name=DB::select("CALL PROC_TNA_LAND_MENU_NAME()");
      $sea_menu_name=DB::select("CALL PROC_TNA_SEA_MENU_NAME()");
      return response()->json([
         'land_port_history'=>$land_Port_history,
         'see_port_history'=>$see_Port_history,
         'land_menu_name'=>$land_menu_name,
         'sea_menu_name'=>$sea_menu_name
      ],200);

   }

   public function checkDashboardStatus(Request $request){
       
      if($request->event==1){
          
            // $saleContract=SaleContract::where('id',$request->sc_id)->first(['notify_pary_id']);
            // $notifyParty=NotifyParty::where('id',$saleContract->notify_pary_id)->first(['special_approval']);
            // if($notifyParty->special_approval=="Y"){
                
            //    $status=1;

            // }else{
           
            //    $status='';
            //    if(LandPortDashboard::where('sc_id',$request->sc_id)->exists()){
                  
            //       $joRecvDateLand=LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',2)->first(['action_date']);
            //       if(!empty($joRecvDateLand->action_date)){
                  
            //          $status= 1;

            //       }else{

            //          $status= 0; 
            //       }

            //    }else if(seaPortdashboard::where('sc_id',$request->sc_id)->exists()){
                  
            //       $joRecvDateSea =seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',2)->first(['action_date']);
            //       if(!empty($joRecvDateSea->action_date)){

            //          $status= 1;

            //       }else{

            //          $status= 0;
                     
            //       }
               
            //    }else{

            //       $status= 1;
                  
            //    }

            // }

            $status= 1;

            return response()->json(['status'=>$status,'event'=>1], 200);

      }

      if($request->event==3){
          
         // $job_order=JobOrderMaster::where('id', $request->jo_id)->first(['sale_contract_id']);
         // $status='';
         // $special_approval=LandPortDashboard::where('sc_id',$job_order->sale_contract_id)->first();
         // if(!is_null($special_approval)){
            
         //    $special_approval=LandPortDashboard::where('sc_id',$job_order->sale_contract_id)->where('Task_ID',34)->first(['action_date']);
         //    if(!empty($special_approval->action_date)){

         //          $status= 1;

         //    }else{
              
         //          $status= 0; 

         //    } 

         // }else{

         //    $status= 1;

         // }

         $status= 1;

         return response()->json(['status'=>$status,'event'=>3], 200);

      }   

      if($request->event==4){
          
         // $status='';
         // if(LandPortDashboard::where('sc_id',$request->sc_id)->exists()){
            
         //    $special_approval=LandPortDashboard::where('sc_id',$request->sc_id)->where('Task_ID',34)->first(['action_date']);
         //    if(!empty($special_approval->action_date)){

         //          $status= 1;

         //    }else{
               
         //       $count = LandPortDashboard::where('sc_id', $request->sc_id)
         //                ->where('Task_ID', '<>', 10)
         //                ->where('Task_ID', '<>', 11)
         //                ->where(function ($query) {
         //                   $query->whereNull('action_date')
         //                         ->orWhere('action_date', '');
         //                })
         //                ->count('id');

         //       if(empty($count)){

         //          $status= 1;

         //       }else{

         //          $status= 0; 

         //       }

         //    }

         // }else if(seaPortdashboard::where('sc_id',$request->sc_id)->exists()){
             
         //    $special_approval=seaPortdashboard::where('sc_id',$request->sc_id)->where('Task_ID',33)->first(['action_date']);
         //    if(!empty($special_approval->action_date)){

         //          $status= 1;

         //    }else{
             
         //       $count = seaPortdashboard::where('sc_id', $request->sc_id) 
         //       ->where('Task_ID', '<>', 10)
         //       ->where('Task_ID', '<>', 11)
         //       ->where(function ($query) {
         //          $query->whereNull('action_date')
         //                ->orWhere('action_date', '');
         //       })->count('id');

         //       if(empty($count)){

         //          $status= 1;

         //       }else{

         //          $status= 0; 

         //       }

         //    }
            
         // }else{

         //    $status= 0;

         // }

         $status= 1;

         return response()->json(['status'=>$status,'event'=>4], 200);
  
      }

      
   }

   public function tnaDashboardMailSend(Request $request){

      $headContentLand = $request->input('head_content_land'); 
      $bodyContentLand = $request->input('body_content_land');
      $headContentSea = $request->input('head_content_sea');
      $bodyContentSea = $request->input('body_content_sea');
      $data = array(
         'headContentLand'=>$headContentLand,
         'bodyContentLand'=>$bodyContentLand,
         'headContentSea'=>$headContentSea,
         'bodyContentSea'=>$bodyContentSea

      );
      Mail::send('tna_mail_template', $data, function($message) use ($data){

         $message->from('Export-tna-Mail@prangroup.com');
         //$message->from($from_mail,'export-tna-Mail@prangroup.com');
         // $message->to('mis10@prangroup.com');
         $message->to('mis94@mis.prangroup.com');
         $message->subject('TNA Dashbaord Demo Mail');  
         
      });

   }
    
}
