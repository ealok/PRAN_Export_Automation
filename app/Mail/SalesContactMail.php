<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use Mail;
use Carbon\Carbon;
class SalesContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        
        $sales_contract_id=$request->sale_contract_no;
        $sales_contract_details=\DB::table('sale_contracts')->where('id', $sales_contract_id)->pluck('sales_contract_no');
        $user_id=Auth::user()->id;
        $user_email=\DB::table('users')->where('id', $user_id)->pluck('email');
        $user_name=\DB::table('users')->where('id', $user_id)->pluck('name');
        $email=$user_email['0'];
        $name=$user_name['0'];
        $sale_contract_name=$sales_contract_details['0'];
        $results=\DB::select("SELECT users.email
            FROM notify_party_users
              JOIN users ON notify_party_users.user_id=users.id
            WHERE notify_party_users.notify_party_id='$request->party_id' and users.active='1'");        

        $email_array=array();
        $a="export@prangroup.com";
        $b="sa.oman@prgoman.com";
        $c="mis94@mis.prangroup.com";
        $d="export282@prangroup.com";
        $e="export98@prangroup.com";
        $f="export124@prangroup.com";
        $g="export118@prangroup.com";
        $h="export157@prangroup.com";
        $i="export206@prangroup.com";
        $j="export166@prgoman.com";
        $k="export464@prangroup.com";
		$l="mis4@prangroup.com";
        foreach ($results as $key => $value) {

            if($value->email==$a || $value->email==$b || $value->email==$c || $value->email==$d || $value->email==$e || $value->email==$f || $value->email==$g || $value->email==$h || $value->email==$i || $value->email==$j || $value->email==$k || $value->email==$l){
             
            }else{
 
              array_push($email_array, $value->email);
              
            }    
           
        }

        foreach ($results as $value) {
            if (!in_array($value->email, $exclude_emails)) {
                $email_array[] = $value->email;  // shortcut for array_push
            }
        }

        $t = Carbon::now();   
        $day = $t->day;
        $month = $t->month;
        $year = $t->year;
        if($day<10){

            $day='0'.$day;

        }

        if($month<10){

            $month='0'.$month;
        }
        $date=$year.'-'.$month.'-'.$day;
        $this->markdown('email')
              ->with(['email' => $email, 'name' => $name,'sales_contract_no' => $sale_contract_name])->to($email_array)->from($email)->subject('Sales Contact No-'.$sale_contract_name.' '.'Mail Date: '.$date); 

        // $this->markdown('email')
        //       ->with(['email' => $email, 'name' => $name,'sales_contract_no' => $sale_contract_name])->to('mis94@mis.prangroup.com')->from('mis94@mis.prangroup.com')->subject('Sales Contact No-'.$sale_contract_name.' '.'Mail Date: '.$date);            

    }
}
