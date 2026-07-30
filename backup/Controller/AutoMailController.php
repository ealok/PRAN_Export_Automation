<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use App\SaleContract;
use App\JobOrderMaster;
use App\POMaster;
use App\PODetails;
use Auth;
use App\TaskDefinition;
use App\TaskUpdatedHistory;
use App\User;
use App\NotifyParty;
use App\NotifyPartyUser;
use App\UserArea;
use App\seaPortdashboard;
use App\LandPortDashboard;
use App\DeskPermission;
use App\SpecialApprove;
use Carbon\Carbon;
use App\Company;
use App\Desk;
use App\TaskActionDetails;
use Illuminate\Support\Facades\Log;
use App\JOCopies;
class AutoMailController extends Controller
{
    public function sendPendingRcvJOMail(Request $request){
        
        DB::statement("SET SESSION group_concat_max_len = 1000000;");
        $results = DB::select("SELECT
                job_order_masters.job_order_number2 as job_order,
                users.name AS user,
                DATE_FORMAT(job_order_masters.created_at, '%d-%m-%Y') AS create_date,
                CASE WHEN DATEDIFF(NOW(), job_order_masters.created_at) = 0 THEN 'Today'
                ELSE CONCAT(DATEDIFF(NOW(), job_order_masters.created_at), ' days already gone')
                END AS days_passed,
                group_concat(distinct companies.factory_name) as company
            FROM job_order_masters
            JOIN job_order_details on job_order_details.master_id=job_order_masters.id
            JOIN ci_items on ci_items.id=job_order_details.item_id
            JOIN companies on companies.id=ci_items.bu_id
            JOIN users ON users.id = job_order_masters.user_id
            WHERE job_order_masters.created_at >= '2025-03-01'
                AND job_order_masters.prod_api_status IS NULL
                AND job_order_masters.job_order_number2 IS NOT NULL
                AND companies.factory_name = 'DPL'
            GROUP BY users.name,job_order_masters.created_at,job_order_masters.job_order_number2
            ORDER BY users.name ASC");

        if(count($results)>0){

            // return $to_email = DB::table('op_mail_setup')
            //         ->join('users', 'users.id', '=', 'op_mail_setup.user_id')
            //         ->where('op_mail_setup.op', 'DPL')
            //         ->where('op_mail_setup.status', 'N')
            //         ->pluck('email')
            //         ->toArray();
            $to_email = [
                "dpl.op63@rflgroupbd.com",
                "dpl.op37@rflgroupbd.com",
                "dpl.op100@rflgroupbd.com",
                "dpl.op27@rflgroupbd.com",
                "export89@rflgroupbd.com",
                "dpl.op15@rflgroupbd.com",
                "dpl.op16@rflgroupbd.com",
                "export105@rflgroupbd.com",
                "export106@rflgroupbd.com"
            ];
            $data = [
                'results' => $results,
                'subject' => "JO Receiving Notification",
                'to_email' => $to_email
            ];
            
            $from_mail = env('MAIL_FROM_ADDRESS');
            Mail::send('mail.pending_jo_mail_template', $data, function($message) use ($from_mail, $data) {
                $message->from($from_mail, 'JO-Receiving-Nofification@rflgroupbd.com');
                ///$message->to('mis94@mis.prangroup.com');
                $message->to($data['to_email']);
                $message->cc('mis94@mis.prangroup.com','coo.dpl2@rflgroupbd.com','rfl257@rflgroupbd.com');
                $message->subject($data['subject']);
            });

            Log::info("Mail sent successfully to: " . implode(", ", $data['to_email']));

        }else{

            Log::warning("No pending job orders found.");
        }

        return 'success';        

    }
}
