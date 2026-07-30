<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Mail;
use App\User;
use DB;
use App\Line;
use App\MailList;
use App\QcEntry;
use Excel;
use App\Undelivered;

class SendMail extends Controller{


    public function generateUndeliveredData(Request $request){
          
        ini_set('max_execution_time', 300); //5 minutes
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://runner.prangroup.com:4005/api/ssapi',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "actionName": "EXP_UNDL",
		    "ComId": "PRAN",
		    "Param1": "",
		    "Param2": "",
		    "Param3": "",
		    "Param4": "",
		    "Param5": "",
		    "Param6": "",
		    "Param7": "",
		    "Param8": ""
		  }',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'ss: SSA',
		    'yy: HJDyh876Yhd765JHdgeoOsdesIUh9876KKLjfkusYhGHS'
		  ),
	    )); 

        $response = curl_exec($curl);
        $result= json_decode($response,true);
        if(sizeof($result)>0){
            
            \DB::select("TRUNCATE TABLE undelivered"); 

        	foreach ($result as $key => $value){

	           $undelivered=new Undelivered();
		       $undelivered->S_GROUP=$value['S_GROUP'];
		       $undelivered->AREA=$value['AREA'];
		       $undelivered->PARTY_CODE=$value['PARTY_CODE'];
		       $undelivered->PARTY_NAME=$value['PARTY_NAME'];
		       $undelivered->ADDR1=$value['ADDR1'];
		       $undelivered->ADDR4=$value['ADDR4'];
		       $undelivered->SALES_CONTACT=$value['SALES_CONTACT'];
		       $undelivered->JOB_NUM=$value['JOB_NUM'];
		       $undelivered->WH_ID=$value['WH_ID'];
		       $undelivered->DO_DATE=substr($value['DO_DATE'],0,10);
		       $undelivered->DO_NO=$value['DO_NO'];
		       $undelivered->LINE_NO=$value['LINE_NO'];
		       $undelivered->ITEM_ID=$value['ITEM_ID'];
		       $undelivered->ITEM_NAME=$value['ITEM_NAME'];
		       $undelivered->D_U_FACT=$value['D_U_FACT'];
		       $undelivered->UNIT=$value['UNIT'];
		       $undelivered->CUR=$value['CUR'];
		       $undelivered->RATE=$value['RATE'];
		       $undelivered->ORDER_QTY=$value['ORDER_QTY'];
		       $undelivered->UNDEL_QTY=$value['UNDEL_QTY'];
		       $undelivered->UNDEL_VAL=$value['UNDEL_VAL'];
		       $undelivered->COMPANY_ID=$value['COMPANY_ID'];
		       $undelivered->BUH_NAME=$value['BUH_NAME'];
		       $undelivered->ITEM_CLASS_ID=$value['ITEM_CLASS_ID'];
		       $undelivered->CAT_NAME=$value['CAT_NAME'];
		       $undelivered->date=date('Y-m-d h:i:s', time());
		       $undelivered->save();

        	}
          

        }


    }


    public function undeliveredMailSend(){


        if(date("D") == "Fri"){

          return "No Mail Sent on Friday";

        } 

        $data_source=public_path().'/'.'mail_data';
        $results=DB::select("select
				a.BUH_NAME BUH_NAME,
				round(SUM(a.CTN_QTY),0) as TOTAL_CTN_QTY,
				round(SUM(a.UNDEL_QTY),0) as TOTAL_UNDEL_QTY,
				round(SUM(a.UNDEL_VAL),0) as TOTAL_VALUE
			from undelivered_all as a
			group by  a.BUH_NAME
			order by a.BUH_NAME is null,a.BUH_NAME ASC");
        
        $excelData=\DB::select("select * from undelivered_all as UD
                   order BY UD.BUH_NAME,UD.AREA,UD.JOB_NUM,UD.ITEM_NAME");

        if (count($excelData) > 0) {

	        $array = array();

	        for ($i = 0, $c = count($excelData); $i < $c; ++$i) {

	            $array[$i] = (array) $excelData[$i];
	        }

	        // Excel::create('Order_Undelivered', function($excel) use ($array){
            
	        //     $excel->setTitle('Undelivered Report');
	        //     $excel->setCreator('Alok')->setCompany('PRAN');
	        //     $excel->setDescription('PRAN Export Undelivered Report');
	        //     $excel->sheet('Sheet 1', function ($sheet) use ($array) {
	        //         $sheet->setOrientation('landscape');
	        //         $sheet->setAutoFilter('A1:W1');
	        //         $sheet->fromArray($array);
	        //     });

	        // })->store('xlsx', $data_source);
            
		    $email_array=array('md@prangroup.com','pranexp@prangroup.com','PRANAllBUHead@prangroup.com','PRAN-All-FactoryGM@prangroup.com','PRANBUExportCoordinator@prangroup.com','CS-Exp-AllDeskOfficerRecipients@prangroup.com');
			//$email_array=array('mis94@mis.prangroup.com');
		    $data = array(
		         'receiver_email'=>$email_array,
		         'subject'=>'PRAN EXPORT-JOB Order Undelivered',
		         'results'=>$results
		         //'results2'=>$results2
		        ); 

		    // Mail::send('mail.undelivered_mail', $data, function($message) use ($data){

		    //   $message->from('reportbi@prangroup.com');
		    //   $message->to($data['receiver_email']);
			//   //$message->cc(['mis94@prangroup.com']);
		    //   $message->cc(['mis@prangroup.com','mis4@mis.prangroup.com','mis10@mis.prangroup.com','mis94@mis.prangroup.com','export166@prangroup.com']);
		    //   $message->subject($data['subject']);
		    //   $message->attach('/var/www/html/baset/8114/public/mail_data/Order_Undelivered.xlsx');

		    // }); 

        }
        else{


            // $data = array('subject'=>'Export Order Undelivered Notification'); 
		    // Mail::send('mail.fail_mail', $data, function($message) use ($data){

		    //   $message->from('reportbi@prangroup.com');
		    //   $message->to('mis94@mis.prangroup.com');
		    //   $message->subject($data['subject']);

		    // });	

        }
   
          
    }

}
