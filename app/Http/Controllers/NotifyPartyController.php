<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\NotifyParty;
use App\DateFormat;
use App\Depot;
use Excel;
use App\NotifyPartyUser;
use App\User;
use App\CiItem;
use App\Location;
use App\NotifyPartyItem;
use App\Area;
use App\CostingMaster;
use App\CostingDetails;
use App\UserArea;
class NotifyPartyController extends Controller{


    public function __construct(){

       $this->middleware('auth');
       
    }
    

    public function index(){
       
        $role_id=Auth::user()->role_id;
        if($role_id==1){
            $notify_parties=NotifyParty::orderBy('id','Desc')->get();
            return view("notify_party.notify_party_list",compact("notify_parties"));
        }else{
            $userAreas=UserArea::where('user_id',Auth::user()->id)->pluck('area_id');
            $notify_parties = NotifyParty::whereIn('area_id',$userAreas)->orderBy('id','Desc')->get();
            return view("notify_party.notify_party_list",compact("notify_parties"));
        }

    }


    public function create(){
        
        $dateFormates=DateFormat::all();
        $areas=Area::all();
        $users=User::all();
        return view("notify_party.notify_party_create")
               ->with('dateFormates', $dateFormates)
               ->with('users', $users)
               ->with('areas',$areas);
    }


    public function store(Request $request){
        
        for ($i=1; $i < sizeof($request->partyDetails); $i++) {
            
            $party_code=$request->partyDetails[$i++]['value'];
            $notify_party=NotifyParty::where('code',$party_code)->first();
            if(is_null($notify_party)){
              
                $notify_party = new NotifyParty();
                $notify_party->code=$party_code;
                $notify_party->name=$request->partyDetails[$i++]['value'];
                $notify_party->address=$request->partyDetails[$i++]['value'];
                $notify_party->shipping_mark=$request->partyDetails[$i++]['value'];
                $notify_party->country=$request->partyDetails[$i++]['value'];
                $notify_party->mfg_date=$request->partyDetails[$i++]['value'];
                $notify_party->exp_date=$request->partyDetails[$i++]['value'];
                $notify_party->ref_name=$request->partyDetails[$i++]['value'];
                $notify_party->region=$request->partyDetails[$i++]['value'];
                $notify_party->area_id=$request->partyDetails[$i++]['value'];
                $notify_party->area=$request->partyDetails[$i++]['value'];
                $notify_party->first_approval=$request->partyDetails[$i++]['value'];
                $notify_party->second_approval=$request->partyDetails[$i++]['value'];
                $notify_party->status=1;
                $notify_party ->save();
                return response()->json(['Status' => 'success']);

            }else{

                return response()->json(['Status' => 'exist']);

            }     
            
           
        }

        
    }



    public function edit($id){
        
        $notify_party = NotifyParty::find($id); 
        $dateFormates=DateFormat::all();
        $areas=Area::all();
        $users=User::where('active',1)->get();
        return view("notify_party.notify_party_edit",compact("notify_party"))
               ->with('dateFormates', $dateFormates)
               ->with('users', $users)
               ->with('areas',$areas);

        
    }

    public function update(Request $request, $id) {

        $notify_party = NotifyParty::find($id);
        $notify_party->code=$request->code;
        $notify_party->name=$request->name;
        $notify_party->address=$request->address;
        $notify_party->address_new=$request->address_new;
        $notify_party->shipping_mark=$request->shipping_mark;
        $notify_party->country=$request->country;
        $notify_party->mfg_date=$request->mfg_date;
        $notify_party->exp_date=$request->exp_date;
        $notify_party->ref_name=$request->ref_name;
        $notify_party->area_id=$request->area_id;
        $notify_party->area=$request->area;
        $notify_party->status=$request->status;
        $notify_party->first_approval=$request->first_approval;
        $notify_party->second_approval=$request->second_approval;
        $notify_party->save();
        return response()->json(['Status' => 'success']);

    }

    public function show($id){

        $notify_party = NotifyParty::find($id); 
        return view("notify_party.notify_party_show",compact("notify_party"));

    }

    public function destroy($id){

        $notify_party = NotifyParty::findOrFail($id);
        $notify_party ->delete();
        Session::flash("danger", "Deleted Succcessfully !");
        return redirect("/notify_party");
    }

    public function notifyPartyExcelUploadView(){

      return view('notify_party.notifyparty_upload_view');

    }

    public function uploadNotifyParty(Request $request){

        $formated_file = $request->file('formated_file');
        $this->validate($request, [
        
           "formated_file"=>"required",
        ]);   
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->save_excel($datas);
        Session::flash("success", "Upload Succcessfully !");
        return redirect("/notify_party_excel/upload_view");


    }

    public function save_excel($datas){

         
      $user_id=Auth::user()->id;  
      foreach ($datas as $key => $value){
        
        $notifyPartyId=NotifyParty::where('code',$value->party_code)->pluck('id'); 
        $userId=User::where('username', $value->staff_id)->pluck('id');
        $result=NotifyPartyUser::where('notify_party_id', $notifyPartyId['0'])->where('user_id', $userId['0'])->get();

        if(count($result)>0){


        }else{

            $notifyPartyUser=new NotifyPartyUser();
            $notifyPartyUser->notify_party_id=$notifyPartyId['0'];
            $notifyPartyUser->user_id=$userId['0'];
            $notifyPartyUser->save(); 

        }

      }

    }

    public function updatePartyPrice(){

       return view('notify_party.notify_party_price_update');

    }

    public function updatePartyItemRateExcel(Request $request){

      $formated_file = $request->file('file');  
      $path = $formated_file->getRealPath();
      $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
      $this->changePartyRate($datas);
      Session::flash("success", "Upload Succcessfully !");
      return redirect("/notify_party_excel/upload_view");      


    }

    private function changePartyRate($datas)
    {
        foreach ($datas as $key => $value) {

            // Skip if party_code or item_code is missing
            if (empty($value->party_code) || empty($value->item_code)) {
                continue;
            }

            // Find Notify Party ID safely
            $notifyParty = NotifyParty::where('code', $value->party_code)->first(['id']);
            if (!$notifyParty) {
                continue; // skip if not found
            }

            // Find Item ID safely
            $item = CiItem::where('ci_item_code', $value->item_code)->first(['id']);
            if (!$item) {
                continue; // skip if not found
            }

            // Check if record exists before updating
            $exists = NotifyPartyItem::where('notify_party_id', $notifyParty->id)
                ->where('ci_item_id', $item->id)
                ->exists();

            if($exists) {
                NotifyPartyItem::where('notify_party_id', $notifyParty->id)
                    ->where('ci_item_id', $item->id)
                    ->update([
                        'acc_rate'  => $value->acc_rate,
                        'acc_rate2' => $value->acc_rate,
                        'party_rate'=> $value->party_rate,
                    ]);
            }
        }
    }


    public function partyItemUpload(){

        return view('notify_party.notify_party_price_update');
 
    } 
    
    public function partyItemInclude(Request $request){

        $formated_file = $request->file('file');  
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->includeItems($datas);
        Session::flash("success", "Upload Succcessfully !");
        return redirect("/notify_party_excel/upload_view");      
  
  
    }
  
    private function includeItems($datas){
  
        foreach ($datas as $key => $value){
             
            if(!empty($value->party_code)){
  
                $notifyPartyId=NotifyParty::where('code',$value->party_code)->first(['id']);
                $itemId=CiItem::where('ci_item_code',$value->item_code)->first(['id']);
                if(NotifyPartyItem::where('notify_party_id',$notifyPartyId->id)->where('ci_item_id',$itemId->id)->exists()){
                     
                      NotifyPartyItem::where('notify_party_id',$notifyPartyId->id)->where('ci_item_id',$itemId->id)->update([
                          'acc_rate'=>$value->acc_rate,
                          'party_rate'=>$value->party_rate
                      ]);
  
                }
  
            } 
  
        }
       
    }

    public function jsonGetNotifyPartyDetails(Request $request,$party_code){
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://runner.prangroup.com:4005/api/expssapi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "actionName": "EXP_PARTY_INFO",
          "ComId": "PRAN",
          "Param1": "'.$party_code.'",
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
            'ss: Alok',
            'yy: HJDyh876Yhdsf543GDJksn'
          ),
        ));
        
        $partyDetils = curl_exec($curl);
        curl_close($curl);
        return response()->json(['partyDetils' => $partyDetils]);

    }

    public function jsonGetPartyDetailsLocal(Request $request,$party_code){
            
        $notifyParty=NotifyParty::where('code',$party_code)->first();
        $partyItems= NotifyParty::where('code', $party_code)
                ->join('notify_party_items', 'notify_parties.id', '=', 'notify_party_items.notify_party_id')
                ->join('ci_items', 'notify_party_items.ci_item_id', '=', 'ci_items.id')
                ->select('ci_items.ci_item_code as item_code', 'ci_items.ci_item_name as item_name')
                ->get();
                
        return response()->json([
            'party_name'=>$notifyParty->name,
            'country'=>$notifyParty->country,
            'region'=>$notifyParty->region,
            'zone'=>$notifyParty->zone,
            'partyItems'=>$partyItems
        ],200);

    }


    public function jsonGetNotifyPartyList(Request $request){
       
        $notifyParty=$notifyParty=NotifyParty::get();
        return response()->json([
            'results'=>$notifyParty
        ],200);


    }



}