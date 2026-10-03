<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\CiItem;
use App\Bu;
use Excel;
use App\Category;
use App\SubCategory;
use App\Itemtype;
use App\PrimeCost;
use App\NotifyPartyItem;
use App\NotifyParty;
use App\Dunit;
use App\Runit;
use DB;
class CiItemController extends Controller{


    public function __construct(){

       parent::__construct();
       $this->middleware('auth');

    }

    public function autocomplete(Request $request)
    {
        $search = $request->q;
        return DB::table('ci_items')
            ->where('ci_item_code', 'like', "%{$search}%")
            ->orWhere('ci_item_name', 'like', "%{$search}%")
            ->limit(20)
            ->get([
                'id',
                'ci_item_code',
                'ci_item_name'
            ]);
    }
    
    public function index(){
        
        $ci_items = CiItem::All();
        $itemTypes=Itemtype::all();
        $bus=Bu::all();
        return view("ci_item.ci_item_list",compact("ci_items"))
              ->with('itemTypes',$itemTypes)
              ->with('bus', $bus);

    }


    public function create(){
        
        $bus=Bu::all();
        $categories=Category::all();
        return view("ci_item.ci_item_create")
             ->with("bus" ,$bus)
             ->with('categories',$categories);
    }

    public function getCiItemList(Request $request){
         
      $results=\DB::select("select
                    ci_items.id,
                    ci_items.ci_item_name,
                    ci_items.ci_item_code,
                    ci_items.duplicate_name,
                    ci_items.p_net_weight,
                    ci_items.factor,
                    ci_items.ci_factor,
                    ci_items.d_net_weight,
                    ci_items.d_gross_weight,
                    ci_items.ci_item_rate,
                    ci_items.hs_code,
                    bus.name as bu,
                    case when item_type_id=1 then 'Local'
                        when item_type_id=2 then 'Export'
                        when item_type_id=3 then 'Global Trading' end as category,
                    case when status=1 then 'Y' else 'N' end as status,
                    case when ci_items.is_api=1 then 'Y' else 'N' end as is_api
                from ci_items
                left join bus on bus.id=ci_items.bu_id
                order by ci_items.id desc");   
      
      if($results){
          
          return response()->json([
              'message' => "Data Found",
              "code"    => 200,
              "data"  => $results
          ]);
      
      }else{
      
          return response()->json([
              'message' => "Internal Server Error",
              "code"    => 500,
              "data"    =>[]
          ]);
      
      }
        

    }

    public function store(Request $request){
        
        $ciItem=CiItem::where('ci_item_code',$request->ci_item_code)->first();
        if(CiItem::where('ci_item_code',$request->ci_item_code)->count()==0){
            
            $ci_item = new CiItem();
            $ci_item->ci_item_code=preg_replace('/\s+/', '', $request->ci_item_code);
            $ci_item->ci_item_name= $request->ci_item_name;
            $ci_item->duplicate_name= $request->duplicate_name;
            $ci_item->p_net_weight= $request->p_net_weight;
            $ci_item->factor= $request->factor;
            $ci_item->ci_factor=  $request->ci_factor;
            $ci_item->d_net_weight= $request->d_net_weight;
            $ci_item->d_gross_weight= $request->d_gross_weight;
            $ci_item->ci_item_rate= $request->ci_item_rate;
            $ci_item->hs_code= $request->hs_code;
            $ci_item->class_name= $request->class_name;
            $bu=Bu::where('id',$request->bu_id)->first(['id','name','code']);
            $ci_item->bu_id = $bu->id;
            $ci_item->company_id  = $bu->code;
            $ci_item->item_type_id = $request->item_type_id;
            $ci_item->bu=$bu->name;
            $ci_item->save();
            $this->pushToCRM(preg_replace('/\s+/', '', $request->ci_item_code), $request->hs_code, $request->ci_item_name, $request->d_net_weight, $request->p_net_weight, $request->factor, $bu->name, $bu->code, $ci_item->id, 'Y');
            return response()->json([
              'message' => "Item Create Successfully Done!",
              "code"    => 200,
            ]);

        }else{

            return response()->json([
              'message' => "Item Already Exist!",
              "code"    => 400,
            ]);

        }    

    }

    public function edit($id){
        
        $bus=Bu::all();
        $ci_item = CiItem::find($id); 
        return view("ci_item.ci_item_edit",compact("ci_item"))
             ->with("bus" ,$bus);;
        
    }

    public function updateCiItem(Request $request){
            
        $bu=Bu::where('id',$request->bu_id)->first(['name','code']);
        $ci_item = CiItem::find($request->edit_id);
        $ci_item->ci_item_code=preg_replace('/\s+/', '', $request->ci_item_code);
        $ci_item->ci_item_name=$request->ci_item_name;
        $ci_item->duplicate_name=$request->duplicate_name;
        $ci_item->p_net_weight=$request->p_net_weight;
        $ci_item->factor=$request->factor;
        $ci_item->ci_factor=$request->ci_factor;
        $ci_item->d_net_weight=$request->d_net_weight;
        $ci_item->d_gross_weight=$request->d_gross_weight;
        $ci_item->ci_item_rate=$request->ci_item_rate;
        $ci_item->hs_code=$request->hs_code;
        $ci_item->company_id=$bu->code;
        $ci_item->class_name=$request->class_name;
        $ci_item->bu=$request->bu_id;
        $ci_item->eid=Auth::user()->id;
        $ci_item->save();
        $this->pushToCRM(preg_replace('/\s+/', '', $request->ci_item_code), $request->hs_code, $request->ci_item_name, $request->d_net_weight, $request->p_net_weight, $request->factor, $bu->name, $bu->code, $ci_item->id, 'Y');
        if($ci_item->id) {

          return response()->json([
              'message' => "Data Updated Successfully!",
              "code"    => 200,
          ]);

        } else {

          return response()->json([

              'message' => "Internal Server Error",
              "code"    => 500

          ]);

        }

    }

    private function pushToCRM($item_code, $hs_code, $itemName, $ctn_net_weight, $pcs_net_weight, $dUFact, $bu_name, $bu_code, $item_id, $status)
    {
        $curl = curl_init();
        $postData = json_encode([
            "Item_Code" => $item_code,
            "Item_Name" => strtoupper($itemName),
            "Pcs_Net_Weight" => $pcs_net_weight,
            "Ctn_Net_Weight" => $ctn_net_weight,
            "Unit_Per_Ctn" => $dUFact,
            "Ctn_Gross_Weight" => 0,
            "Hs_Code" => $hs_code,
            "BU_Code" => $bu_code,
            "BU_Name" => $bu_name,
            "category" => 'Export',
            "status" => $status
        ]);

        // @@ Basic Auth credentials
        $username = "auth";
        $password = "12Pran@123456$";
        
        // @@ Generate Basic Auth token
        $basicAuth = base64_encode($username . ':' . $password);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.2.162/api/eas/master-products/upsert',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'ss: master_products',
                'yy: HJDyh876Yhdsf543GFOYSAL',
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . $basicAuth,
                'Cookie: XSRF-TOKEN=eyJpdiI6InRLQ0RGNGFRRkZ5S1pxRHdyc2dBNUE9PSIsInZhbHVlIjoiT0txcHdxNWpYbWFRa1NFY0tZSUV5WUxIazc2eGtqcWp6dkthZ1pDNnN1VWxjS3RRR1dFdW5QVXlabVZmczZSSUZaajY2aVJ1YllnRitiMFpHZmwxR3VkVmUrdkkrT2pQOHNpVUVzSzcxTnJwRkw1N1NkNGVZVStwU3J4VWE3UEYiLCJtYWMiOiJhMWExZjMxYjQ4OTAzNzE4NDljODhlNDA4MTA1NDc5YTFhYWQ0MTI5MmVmZGZmMGUzNzdjODE1NzM1MDBiOGY5IiwidGFnIjoiIn0%3D; crm_session=eyJpdiI6IjBHa21zZllsRkxqMjR1YlUraExlcnc9PSIsInZhbHVlIjoieE9Ya0luN0JaV01LV3ZyQ01weEpxb2lvYWtIUzhiMmJRcEJ0THJGZ2k0b2NGS1U3QU9qN1kwZ0hScTU5LytJSmVFWC9IT05pV1hXb2h5bERvZDNxMTR4UTVuZkhKdFBBM1cybVRmaXhVTmZSQVBqTllSOFBhSmhLaStJbXkzdGoiLCJtYWMiOiIyZmFjMGNjZWI3MmZmYmQyZjc0NGFlZGJiODBhNWZjMjYxOTk4OTRmM2QzNWVkZDYwZjI4NDJlMDA4YmQ4NzVjIiwidGFnIjoiIn0%3D'
            ),
        ));

        $response = curl_exec($curl);
        $apiResponse = json_decode($response, true);
        $success = (isset($apiResponse['status']) && $apiResponse['status'] === 'success') ? true : false;
        $message = $success 
            ? (isset($apiResponse['message']) ? $apiResponse['message'] : 'Successfully inserted/updated EAS Master Product(s)')
            : (isset($apiResponse['message']) ? $apiResponse['message'] : 'Failed to push to CRM');
        
        // @@ Update database
        DB::table('ci_items')
            ->where('id', $item_id)
            ->update([
                'crm_status' => $success ? 'Success' : 'Failed',
                'crm_message' => $message,
                'crm_pushed_at' => $success ? date('Y-m-d H:i:s') : null
            ]);
        
        // @@ Return boolean
        return [
            'success' => $success,
            'message' => $message
        ];

    }

    public function update(Request $request, $id) {}

    public function show($id){

        $result = CiItem::find($id); 
        $bus=Bu::all();
        $item_types=Itemtype::all();
        if($result) {

            return response()->json([

              'message' =>  "Data Found",
              "code"        => 200,
              "bus"         => $bus,
              "data"        => $result,
              "categories"  => $item_types

            ]);

        }else {

            return response()->json([

                'message'     => "Internal Server Error",
                "code"        => 500,
                "bus"         => [],
                "data"        => [],
                "categories"  => []

            ]);

        } 
    }

    public function itemInactive($id){
           
        $result=CiItem::where('id',$id)->update([
          'status'=>0
        ]);
        $item=CiItem::where('id',$id)->first();
        $bu=Bu::where('id',$item->bu_id)->first(['name','code']);
        $this->pushToCRM($item->ci_item_code, $item->hs_code, $item->ci_item_name, $item->d_net_weight, $item->p_net_weight, $item->ci_factor, $bu->name, $bu->code, $item->id, 'N');
        if($result) {

          return response()->json([
            'message' => "Data Deleted Successfully!",
            "code"    => 200,
          ]);

        }else{

          return response()->json([
              'message' => "Internal Server Error",
              "code"    => 500
          ]);

        }
 
    }

    public function itemActive($id){

        $result=CiItem::where('id',$id)->update([
          'status'=>1
        ]);
      
        $item=CiItem::where('id',$id)->first();
        $bu=Bu::where('id',$item->bu_id)->first(['name','code']);
        $this->pushToCRM($item->ci_item_code, $item->hs_code, $item->ci_item_name, $item->d_net_weight, $item->p_net_weight, $item->ci_factor, $bu->name, $bu->code, $item->id, 'Y');
        if($result) {

          return response()->json([
            'message' => "Data Deleted Successfully!",
            "code"    => 200,
          ]);

        }else{

          return response()->json([
              'message' => "Internal Server Error",
              "code"    => 500
          ]);

        }


    }


    public function destroy($id){
            
    }

    public function ciItemView(Request $request){

       return view('ci_item.ci_excel_upload');

    }

    public function ciItemUpload(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $path = $request->file('file')->getRealPath();
                $datas = \Excel::load($path, function ($reader) {
                })->get();

                $this->saveItemDetails($datas);
                Session::flash("success", "Unload Successfully Done..!!");
                return redirect('/ci_item/excel/upload');
            }
        } catch (\Exception $e) {
            Session::flash("error", "An error occurred: " . $e->getMessage());
            return redirect('/ci_item/excel/upload');
        }
    }

    private function saveItemDetails($datas)
    {
        try {
            foreach ($datas as $key => $value) {
                $bu_id = '';
                try {
                    if (CiItem::where('ci_item_code', $value->code)->count() == 0) {
                        try {
                            if (Bu::where('code', $value->bu_code)->count() == 0) {
                                $bu = new Bu();
                                $bu->code = $value->bu_code;
                                $bu->name = $value->bu_name;
                                $bu->save();
                                $bu_id = $bu->id;
                            } else {
                                $bu_id = Bu::where('code', $value->bu_code)->value('id');
                            }
                        } catch (\Exception $e) {
                            throw new \Exception("Error processing BU: " . $e->getMessage());
                        }

                        $ci_item = new CiItem();
                        $ci_item->ci_item_code = $value->code;
                        $ci_item->ci_item_name = $value->name;
                        $ci_item->duplicate_name = $value->name;
                        $ci_item->p_net_weight = $value->net_weight;
                        $ci_item->factor = $value->factor;
                        $ci_item->ci_factor = $value->factor;
                        $ci_item->d_net_weight = $value->d_net_wt ? $value->d_net_wt : $value->net_weight;
                        $ci_item->d_gross_weight = $value->gross_weight;
                        $ci_item->ci_item_rate = 0;
                        $ci_item->hs_code = $value->hs_code ? $value->hs_code : '-';
                        $ci_item->bu_id = $bu_id;
                        $ci_item->bapa_percent = 0;
                        $ci_item->is_ci_eligible = 0;
                        $ci_item->class_name = $value->category;
                        $ci_item->subclass_name = $value->subcategroy;
                        $ci_item->is_ci_eligible = 0;

                        try {
                            $category_id = '';
                            if (Category::where("name", $value->category)->count() > 0) {
                                $category = Category::where("name", $value->category)->first(['id']);
                                $category_id = $category->id;
                            } else {
                                $category = new Category();
                                $category->name = $value->category;
                                $category->save();
                                $category_id = $category->id;
                            }

                            $subCategory_id = '';
                            if (SubCategory::where('name', $value->subcategroy)->count() > 0) {
                                $subCategory = SubCategory::where('name', $value->subcategroy)->first(['id']);
                                $subCategory_id = $subCategory->id;
                            } else {
                                $subCategory = new SubCategory();
                                $subCategory->category_id = $category_id;
                                $subCategory->name = $value->subcategroy;
                                $subCategory->save();
                                $subCategory_id = $subCategory->id;
                            }
                            $ci_item->sub_category_id = $subCategory_id;
                            $ci_item->save();
                            $item_id = $ci_item->id;
                        } catch (\Exception $e) {
                            throw new \Exception("Error processing category/subcategory: " . $e->getMessage());
                        }
                    } else {
                        $item_id = CiItem::where('ci_item_code', $value->code)->value('id');
                    }
                } catch (\Exception $e) {
                    throw new \Exception("Error processing CI Item: " . $e->getMessage());
                }

                try {
                    $dunit_id = '';
                    if (Dunit::where('dunit_code', $value->dunit_code)->count() > 0) {
                        $dunit = Dunit::where('dunit_code', $value->dunit_code)->first(['id']);
                        $dunit_id = $dunit->id;
                    } else {
                        $dunit = new Dunit();
                        $dunit->dunit_code = $value->dunit_code;
                        $dunit->dunit_name = $value->dunit_name ? $value->dunit_name : $value->dunit_code;
                        $dunit->save();
                        $dunit_id = $dunit->id;
                    }

                    $runit_id = '';
                    if (Runit::where('runit_code', $value->runit_code)->count() > 0) {
                        $runit = Runit::where('runit_code', $value->runit_code)->first(['id']);
                        $runit_id = $runit->id;
                    } else {
                        $runit = new Runit();
                        $runit->runit_code = $value->runit_code;
                        $runit->runit_name = $value->runit_name ? $value->runit_name : $value->runit_code;
                        $runit->save();
                        $runit_id = $runit->id;
                    }

                    $notify_party_id = NotifyParty::where('code', $value->party_code)->value('id');
                    if (NotifyPartyItem::where('notify_party_id', $notify_party_id)->where('ci_item_id', $item_id)->count() == 0) {
                        $notifyPartyItems = new NotifyPartyItem();
                        $notifyPartyItems->notify_party_id = $notify_party_id;
                        $notifyPartyItems->ci_item_id = $item_id;
                        $notifyPartyItems->desk_item_name = $value->name;
                        $notifyPartyItems->acc_rate = $value->acc_rate ? $value->acc_rate : 0;
                        $notifyPartyItems->acc_rate2 = $value->acc_rate ? $value->acc_rate : 0;
                        $notifyPartyItems->party_rate = $value->party_rate ? $value->party_rate : 0;
                        $notifyPartyItems->cbm_per_ctn = $value->cbm_per_ctn ? $value->cbm_per_ctn : 0;
                        $notifyPartyItems->gross_weight = $value->gross_weight ? $value->gross_weight : 0;
                        $notifyPartyItems->coding_matter = $value->coding_matter;
                        $notifyPartyItems->special_requirement = $value->special_req;
                        $notifyPartyItems->ingredient = $value->ingredient;
                        $notifyPartyItems->shelf_life = 12;
                        $notifyPartyItems->dunit = $dunit_id;
                        $notifyPartyItems->runit = $runit_id;
                        $notifyPartyItems->save();
                    }
                } catch (\Exception $e) {
                    throw new \Exception("Error processing Notify Party Item: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Error processing item details: " . $e->getMessage());
        }
    }


    public function ciItemInactiveExcelView(){

       return view('ci_item.ci_item_inactive');

    }

    public function ciItemInactiveExcel(Request $request){
       

        $formated_file = $request->file('formated_file');
        $this->validate($request, [
        
           "formated_file"=>"required",
        ]);   
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->save_excel($datas);
        Session::flash("success", "Upload Succcessfully..!");
        return redirect("/ci_item_inactive/excel/upload/view");

    }

    private function save_excel($datas){
      
          $user_id=Auth::user()->id;  
          foreach($datas as $key => $value){
            
            $ci_item_id=CiItem::where('ci_item_code',$value->ci_item_code)->pluck('id');
            if(isset($ci_item_id['0'])){

                $ci_item_id=$ci_item_id['0'];
                $ci_item=CiItem::findOrFail($ci_item_id);
                $ci_item->status=$value->status;
                $ci_item->save();
                
            }
       
        
        }


    }

    public function getBapaRateUpdate(Request $request){

         
         return view('ci.bapa_rate_update_view');

    }

    public function bapaRateUpdate(Request $request){

        $formated_file = $request->file('file');
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->updateBapa($datas);
        Session::flash("success", "Upload Succcessfully..!");
        return redirect("/bapa_rate_update/get_view");
        

    }

    public function updateBapa($datas){
          

      foreach($datas as $key => $value){

            $item_id=CiItem::where('ci_item_code',$value->item_code)->pluck('id');
            if(isset($item_id['0'])){

              $ci_item= CiItem::findOrFail($item_id['0']);
              $ci_item->bapa_rate=$value->old_rate;
              $ci_item->bapa_old_date=date("Y-m-d", strtotime($value->old_rate_date));
              $ci_item->bapa_new_rate=$value->new_rate;
              $ci_item->bapa_new_date=date("Y-m-d", strtotime($value->new_rate_date));
              $ci_item->save();
                
            }
        
        } 

    }

    public function getCiItemDetils(Request $request,$ci_item_code){

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
          "actionName": "EXP_ITEM_MASTER",
          "ComId": "PRAN",
          "Param1": "'.$ci_item_code.'",
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
        
        $itemDetils = curl_exec($curl);
        $bus=BU::all();
        $ci_item_rate=0;
        $hs_code='';
        if(CiItem::where('ci_item_code',$ci_item_code)->count()>0){

          $ciItem=CiItem::where('ci_item_code',$ci_item_code)->first(['ci_item_rate','hs_code']);
          $ci_item_rate=$ciItem->ci_item_rate;
          $hs_code=$ciItem->hs_code;

        }
        

        return response()->json(['itemDetails' => $itemDetils, 'bus' => $bus, 'ci_item_rate'=>$ci_item_rate, 'hs_code'=> $hs_code]);
        curl_close($curl);


    }

    public function getCiItemDetailsLocal(Request $request,$item_code){

      $ci_item=CiItem::where('ci_item_code',$item_code)->first();
      $bu=BU::where('id',$ci_item->bu_id)->first();
      $result = DB::table(DB::raw('(SELECT start_date, end_date, cost AS prime_cost FROM prime_cost WHERE code='.$item_code .' ORDER BY id DESC LIMIT 1) AS t1'))
      ->select([
          DB::raw('IF(CURDATE() BETWEEN t1.start_date AND t1.end_date, t1.prime_cost, 0) AS prime_cost'),
          't1.start_date as updated_date'
      ])
      ->first();
       
      $prime_cost=0;
      $updated_date='';
      if($result){
         
        $prime_cost=$result->prime_cost;
        $updated_date=$result->updated_date;

      }

      return response()->json([
        'item_name'=>$ci_item->ci_item_name,
        'bu'=>$bu->code,
        'factor'=>$ci_item->factor,
        'prime_cost'=>$prime_cost,
        'updated_at'=>$updated_date
      ],200);
      
   

    }

    public function updateNotifyPartyItem(Request $request){
           
      
      $results=DB::select("SELECT * FROM `ci_items` WHERE `bu_id`=31");
      foreach($results as $key => $value) {

        if(NotifyPartyItem::where('notify_party_id',798)->where('ci_item_id',$value->id)->count()==0){
          
            $notifyPartyItems=new NotifyPartyItem();
            $notifyPartyItems->notify_party_id=798;
            $notifyPartyItems->ci_item_id=$value->id;
            $notifyPartyItems->desk_item_name=$value->ci_item_name;
            $notifyPartyItems->acc_rate=0;
            $notifyPartyItems->party_rate=0;
            $notifyPartyItems->cbm_per_ctn=0;
            $notifyPartyItems->gross_weight=0;
            $notifyPartyItems->shelf_life=0;
            $notifyPartyItems->dunit=0;
            $notifyPartyItems->runit=0;
            $notifyPartyItems->factory_id=0;
            $notifyPartyItems->percentage=0;
            $notifyPartyItems->save();
          
        }

      }
      
    }

    public function checkUniqueItem(Request $request)
    {
        try {

            $fullItemName = $request->full_item_name;
            $existsInCiItems = DB::table('ci_items')->where('ci_item_name', $fullItemName)->exists();
            $existsInRequisitionItems = DB::table('requisition_items')->where('item_name', $fullItemName)->exists();
            $exists = $existsInCiItems ? true : ($existsInRequisitionItems ? true : false);
            return response()->json([
                'success' => true,
                'unique' => !$exists,
                'message' => $exists ? 'Item already exists' : 'Item is available'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'unique' => false,
                'message' => 'Error checking uniqueness'
            ], 500);
        }
    }

}