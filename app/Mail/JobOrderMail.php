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
use App\JobOrderMaster;
class JobOrderMail extends Mailable
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
        
        $user_id=Auth::user()->id;
        $user_email=\DB::table('users')->where('id', $user_id)->pluck('email');
        $user_name=\DB::table('users')->where('id', $user_id)->pluck('name');
        $email=$user_email['0'];
        $name=$user_name['0'];
        $jobOrderNumber=JobOrderMaster::where('id', $request->id)->pluck('job_order_number');
        $production_floor_id=JobOrderMaster::where('id', $request->id)->pluck('p_floor_id');
        $production_floor_id=$production_floor_id['0'];
        $results=\DB::select("SELECT users.email
            FROM user_production_floor_setups
            JOIN users ON users.id = user_production_floor_setups.user_id
            WHERE user_production_floor_setups.production_floor_id='$production_floor_id'");
        if(count($results)>0){
             
            $email_array=array();
            foreach($results as $key => $value) {

                array_push($email_array, $value->email); 
               
            }
            return $this->view('job_order_mail',['job_order_number'=>$jobOrderNumber['0'],'name'=>$name,'email'=>$email])->to($email_array)->from($email)->subject("Job Order Mail");

        }else{
            
            return $this->view('job_order_mail_error')->to($email)->subject('Job Order Error Mail');

        }

        return $this->view('job_order_mail_error')->to('mis94@mis.prangroup.com')->subject('Job Order Error Mail');
       
    }
}
