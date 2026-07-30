<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ExclusiveDistributorOpen;
use App\showroomSelectionMaster;
use App\showroomSelectionDetails;
use App\ShowroomImage;
use Carbon\Carbon;
use Auth;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Company;
use App\Region;
use App\Base;
use App\Zone;
class ShowroomAuditController extends Controller
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
        $user_id=Auth::user()->id;
        $groups=DB::select("SELECT user_group_permissions.group_id
                  FROM user_group_permissions
                  WHERE user_id='$user_id'");
        $group_ids=array();
        foreach ($groups as $key => $value) {
          
            array_push($group_ids, $value->group_id);
        }
        $group_id = join("', '", $group_ids);
        $current_date=date('Y-m-d');
         
        $form_date=date('Y-m-01', strtotime($current_date));
        $to_date=date('Y-m-t', strtotime($current_date)); 

        $results=DB::select("SELECT
                showroom_selection_details.id,
                showroom_selection_masters.create_date,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name,
                showroom_selection_masters.created_at,
                SUM(
                    COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
                ) AS total
            FROM
                showroom_selection_masters
            JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = showroom_selection_masters.dist_id
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON regions.id = zones.region_id
            JOIN showroom_selection_details ON showroom_selection_masters.id = showroom_selection_details.ms_id
            JOIN users ON showroom_selection_masters.user_id = users.id
            WHERE showroom_selection_masters.user_id='$user_id' AND date(showroom_selection_masters.create_date)>='$form_date' AND date(showroom_selection_masters.create_date)<='$to_date'
            GROUP BY
                showroom_selection_details.id,
                showroom_selection_masters.create_date,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name
            ORDER BY
                    showroom_selection_details.business_plance_in_showroom + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom DESC");
          $distributors=\DB::select("SELECT
                  exclusive_distributor_opens.id,
                  exclusive_distributor_opens.distribution_code,
                  exclusive_distributor_opens.distribution_name
              FROM
                  exclusive_distributor_opens
              JOIN bases ON exclusive_distributor_opens.base_id = bases.id
              JOIN zones ON zones.id = bases.zone_id
              JOIN regions ON zones.region_id = regions.id
              JOIN user_tag_infos ON user_tag_infos.zone_id = zones.id AND user_tag_infos.region_id = regions.id
              WHERE
                  exclusive_distributor_opens.dealer_active_status = '1' 
                  AND user_tag_infos.user_id = '$user_id'
                  AND exclusive_distributor_opens.company IN ('$group_id')");  
        return view('pages.showroom_selection.showroom_selection_create')
                             ->with('distributors', $distributors)
                             ->with('results', $results);
                             
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       



            $result=(object)$request->all();
            $user_id=Auth::user()->id;  
            date_default_timezone_set("Asia/Dhaka");
            $date=date("Y-m-d h:i:sa");
            $distributor_code=$request->distributor_id;
            $distributor_codes=DB::table('exclusive_distributor_opens')
                    ->where('distribution_code', $distributor_code)
                    ->get(); 

            foreach ($distributor_codes as $key => $value) {
            
              $distributor_id=$value->id;

            }

            $show_selection_master=new showroomSelectionMaster();
            $showroomSelectionDetails=new showroomSelectionDetails(); 
            $show_selection_master->dist_id=$distributor_id;
            $show_selection_master->create_date=$date;
            $show_selection_master->user_id=$user_id;
            $show_selection_master->save();
            $ms_id=$show_selection_master->id;

            
            $showroomSelectionDetails->ms_id=$ms_id; 
            $showroomSelectionDetails->business_plance_in_showroom=isset($result->business_plance_in_showroom) ? $request->business_plance_in_showroom : 0;
            $showroomSelectionDetails->rfl_product_available_in_showroom=isset($result->rfl_product_available_in_showroom) ? $result->rfl_product_available_in_showroom : 0;
            $showroomSelectionDetails->product_display_condition=isset($result->product_display_condition) ? $result->product_display_condition : 0;
            $showroomSelectionDetails->Housekeeping_condition=isset($result->Housekeeping_condition) ? $result->Housekeeping_condition : 0;
            $showroomSelectionDetails->branding_and_signboard_condition=isset($result->branding_and_signboard_condition) ? $result->branding_and_signboard_condition : 0;
            $showroomSelectionDetails->sales_performance_of_showroom=isset($result->sales_performance_of_showroom) ? $result->sales_performance_of_showroom : 0;
            $showroomSelectionDetails->master_products_availability=isset($result->master_products_availability) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->stock_room_condition=isset($result->stock_room_condition) ? $result->stock_room_condition : 0;
            $showroomSelectionDetails->discount_cornner_in_showroom=isset($result->discount_cornner_in_showroom) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->new_arrival_cornner_in_showroom=isset($result->new_arrival_cornner_in_showroom) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->pos_system_sales=isset($result->pos_system_sales) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->china_rack_in_showroom=isset($result->china_rack_in_showroom) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->shopping_bag_and_shirt=isset($result->shopping_bag_and_shirt) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->sales_man_in_showroom=isset($result->sales_man_in_showroom) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->other_brand_in_showroom=isset($result->other_brand_in_showroom) ? $result->master_products_availability : 0;
            $showroomSelectionDetails->save();
            Toastr::success('Information Save Successfully :)', 'Successfull');
            return redirect('/audit/create');
     
//        }
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    

         //$details=showroomSelectionDetails::findorfail($id);
         //return view('pages.showroom_selection.showroom_selection_details')->with('details', $details);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $current_date=date('Y-m-d');
        $form_date=date('Y-m-01', strtotime($current_date));
        $to_date=date('Y-m-t', strtotime($current_date));

        $selection_details=showroomSelectionDetails::findorfail($id);
        $auditMaster=showroomSelectionMaster::findorfail($selection_details->ms_id);
        $showroom_id=$auditMaster->dist_id;
        $showroomDetails=ExclusiveDistributorOpen::findorfail($showroom_id);
        $base=Base::findorfail($showroomDetails->base_id);
        $baseName=$base->base_name;  
        $zone=Zone::findorfail($base->zone_id);
        $zoneName=$zone->zone_name;
        $region=Region::findorfail($zone->region_id);
        $regionName=$region->region_name;
        $showroomName=$showroomDetails->showroom_name;
        $form_date=date('Y-m-d');
        $to_date=date('Y-m-d', strtotime($form_date.' + 1 days'));
        $total_amount=0;
        $results=DB::select("SELECT
                showroom_selection_details.id,
                showroom_selection_masters.create_date,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name,
                showroom_selection_masters.created_at,
                SUM(
                    COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
                ) AS total
            FROM
                showroom_selection_masters
            JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = showroom_selection_masters.dist_id
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON regions.id = zones.region_id
            JOIN showroom_selection_details ON showroom_selection_masters.id = showroom_selection_details.ms_id
            JOIN users ON showroom_selection_masters.user_id = users.id
            WHERE showroom_selection_masters.id='$id' AND date(showroom_selection_masters.create_date)>='$form_date' AND date(showroom_selection_masters.create_date)<='$to_date'
            GROUP BY showroom_selection_details.created_at
            ORDER BY
                    showroom_selection_details.business_plance_in_showroom + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom DESC LIMIT 1");

        foreach ($results as $key => $value){


           $total_amount=$value->total;

        }

        return view('pages.showroom_selection.showroom_selection_edit')
               ->with('selection_details', $selection_details)
               ->with('baseName',$baseName)
               ->with('zoneName',$zoneName)
               ->with('regionName',$regionName)
               ->with('showroomName',$showroomName)
               ->with('total_amount',$total_amount);
                

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
            
            return $request->all();
            $showroomSelectionDetails=showroomSelectionDetails::findorfail($id);
            $showroomSelectionDetails->business_plance_in_showroom=$request->business_plance_in_showroom!="" ? $request->business_plance_in_showroom : 0;
            $showroomSelectionDetails->rfl_product_available_in_showroom=$request->rfl_product_available_in_showroom;
            $showroomSelectionDetails->product_display_condition=$request->product_display_condition;
            $showroomSelectionDetails->Housekeeping_condition=$request->Housekeeping_condition;
            $showroomSelectionDetails->branding_and_signboard_condition=$request->branding_and_signboard_condition;
            $showroomSelectionDetails->sales_performance_of_showroom=$request->sales_performance_of_showroom;
            $showroomSelectionDetails->master_products_availability=$request->master_products_availability;
            $showroomSelectionDetails->stock_room_condition=$request->stock_room_condition;
            $showroomSelectionDetails->discount_cornner_in_showroom=$request->discount_cornner_in_showroom;
            $showroomSelectionDetails->new_arrival_cornner_in_showroom=$request->new_arrival_cornner_in_showroom;
            $showroomSelectionDetails->pos_system_sales=$request->pos_system_sales;
            $showroomSelectionDetails->china_rack_in_showroom=$request->china_rack_in_showroom;
            $showroomSelectionDetails->shopping_bag_and_shirt=$request->shopping_bag_and_shirt;
            $showroomSelectionDetails->sales_man_in_showroom=$request->sales_man_in_showroom;
            $showroomSelectionDetails->other_brand_in_showroom=$other_brand_in_showroom;
            $showroomSelectionDetails->save();
            Toastr::success('Information Edit Successfully :)', 'Successfull');
            return redirect('/audit/create');

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


    public function getAuditReportHome(Request $request){

      $user_id=Auth::user()->id;
      $regions=Region::all();
      $results=\DB::select("SELECT companies.id,companies.company_name
              FROM user_group_permissions
              JOIN companies ON user_group_permissions.group_id=companies.id
              WHERE user_group_permissions.user_id='$user_id'");


      if(count($results)>0){

         
         return view('pages.showroom_selection.showroom_selection_report_home')
               ->with('results', $results)
               ->with('regions', $regions);

      }else{
          $results="";
          return view('pages.showroom_selection.showroom_selection_report_home')
                 ->with('results', $results)
                 ->with('regions', $regions);

      }
      

    }

    public function getAuditReport(Request $request){


      if((!empty($request->from_date)) && (!empty($request->to_date))){

        $form_date=$request->from_date;
        $toDate = $request->to_date; 
        $to_date=date('Y-m-d', strtotime($toDate. ' + 1 days'));
        $results=DB::select("SELECT
            showroom_selection_details.id,
            showroom_selection_masters.create_date,
            exclusive_distributor_opens.distribution_code,
            exclusive_distributor_opens.showroom_name,
            exclusive_distributor_opens.address,
            zones.zone_name,
            bases.base_name,
            regions.region_name,
            showroom_selection_masters.create_date,
            users.name,
            users.email,
            showroom_selection_masters.created_at,
            SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            ) AS total,
            CASE WHEN SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            ) >= 80 THEN 'A' WHEN SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            )  >= 65 THEN 'B'  WHEN SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            )  >= 50 THEN 'C' ELSE 'F' 
        END AS grade 
        FROM
            showroom_selection_masters
        JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = showroom_selection_masters.dist_id
        JOIN bases ON exclusive_distributor_opens.base_id = bases.id
        JOIN zones ON zones.id = bases.zone_id
        JOIN regions ON regions.id = zones.region_id
        JOIN showroom_selection_details ON showroom_selection_masters.id = showroom_selection_details.ms_id
        JOIN users ON showroom_selection_masters.user_id = users.id
        WHERE showroom_selection_masters.create_date>='$form_date' AND showroom_selection_masters.create_date<='$to_date' AND exclusive_distributor_opens.company='$request->company_id' AND exclusive_distributor_opens.id>='$request->from_party_code_id' AND exclusive_distributor_opens.id<='$request->to_party_code_id' AND regions.id>='$request->from_region' and regions.id<='$request->to_region'
        GROUP BY
            showroom_selection_details.id,
            showroom_selection_masters.create_date,
            exclusive_distributor_opens.distribution_code,
            exclusive_distributor_opens.showroom_name,
            exclusive_distributor_opens.address,
            zones.zone_name,
            bases.base_name,
            regions.region_name,
            users.name
        ORDER BY
            total
        DESC");
        return view('pages.showroom_selection.showroom_selection_report')
             ->with('results', $results);
      }else{

          $results=DB::select("SELECT
              showroom_selection_details.id,
              showroom_selection_masters.create_date,
              exclusive_distributor_opens.distribution_code,
              exclusive_distributor_opens.showroom_name,
              exclusive_distributor_opens.address,
              zones.zone_name,
              bases.base_name,
              regions.region_name,
              showroom_selection_masters.create_date,
              users.name,
              users.email,
              SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            ) AS total,
            CASE WHEN SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            ) >= 80 THEN 'A' WHEN SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            )  >= 65 THEN 'B'  WHEN SUM(
                COALESCE(showroom_selection_details.business_plance_in_showroom,0) + showroom_selection_details.rfl_product_available_in_showroom + showroom_selection_details.product_display_condition + showroom_selection_details.Housekeeping_condition + showroom_selection_details.branding_and_signboard_condition + showroom_selection_details.sales_performance_of_showroom + showroom_selection_details.master_products_availability + showroom_selection_details.stock_room_condition + showroom_selection_details.discount_cornner_in_showroom + showroom_selection_details.new_arrival_cornner_in_showroom + showroom_selection_details.pos_system_sales + showroom_selection_details.china_rack_in_showroom + showroom_selection_details.shopping_bag_and_shirt + showroom_selection_details.sales_man_in_showroom + showroom_selection_details.other_brand_in_showroom
            )  >= 50 THEN 'C' ELSE 'F'
          END AS grade 
          FROM
              showroom_selection_masters
          JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = showroom_selection_masters.dist_id
          JOIN bases ON exclusive_distributor_opens.base_id = bases.id
          JOIN zones ON zones.id = bases.zone_id
          JOIN regions ON regions.id = zones.region_id
          JOIN showroom_selection_details ON showroom_selection_masters.id = showroom_selection_details.ms_id
          JOIN users ON showroom_selection_masters.user_id = users.id
              WHERE exclusive_distributor_opens.company='$request->company_id' 
              AND exclusive_distributor_opens.id>='$request->from_party_code_id' 
              AND exclusive_distributor_opens.id<='$request->to_party_code_id' 
              AND regions.id>='$request->from_region' 
              AND regions.id<='$request->to_region'
          GROUP BY
              showroom_selection_details.id,
              showroom_selection_masters.create_date,
              exclusive_distributor_opens.distribution_code,
              exclusive_distributor_opens.showroom_name,
              exclusive_distributor_opens.address,
              zones.zone_name,
              bases.base_name,
              regions.region_name,
              users.name
          ORDER BY
              total
          DESC");
          return view('pages.showroom_selection.showroom_selection_report')
               ->with('results', $results); 


      }
      

    }

    public function loadPartyCodeBelogToCompany(Request $request){

       if($request->company_id=='all'){
        
            return $results=DB::select("SELECT
                exclusive_distributor_opens.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.distribution_name,
                exclusive_distributor_opens.showroom_name
            FROM
                exclusive_distributor_opens
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON zones.region_id = regions.id
            WHERE
                exclusive_distributor_opens.dealer_active_status = '1'");

       }else{
           
          return $results=DB::select("SELECT
                exclusive_distributor_opens.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.distribution_name,
                exclusive_distributor_opens.showroom_name
            FROM
                exclusive_distributor_opens
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON zones.region_id = regions.id
            WHERE
                exclusive_distributor_opens.dealer_active_status = '1' 
                AND exclusive_distributor_opens.company='$request->company_id'"); 


       }
        
            
    }

    function loadPartyCodeBelogToCompany2(Request $request){

       if($request->company_id=='all'){
        
            return $results=DB::select("SELECT
                exclusive_distributor_opens.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.distribution_name,
                exclusive_distributor_opens.showroom_name
            FROM
                exclusive_distributor_opens
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON zones.region_id = regions.id
            WHERE
                exclusive_distributor_opens.dealer_active_status = '1'");

       }else{
           
          return $results=DB::select("SELECT
                exclusive_distributor_opens.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.distribution_name,
                exclusive_distributor_opens.showroom_name
            FROM
                exclusive_distributor_opens
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON zones.region_id = regions.id
            WHERE
                exclusive_distributor_opens.dealer_active_status = '1' 
                AND exclusive_distributor_opens.company='$request->company_id'"); 


       }


    }

    public function getSalesEntry(){

       $user_id=Auth::user()->id;
       $groups=DB::select("SELECT user_group_permissions.group_id
                  FROM user_group_permissions
                  WHERE user_id='$user_id'");
        $group_ids=array();
        foreach ($groups as $key => $value) {
          
            array_push($group_ids, $value->group_id);
        }
       $group_id = join("', '", $group_ids);
       $distributors=\DB::select("SELECT
                  exclusive_distributor_opens.id,
                  exclusive_distributor_opens.distribution_code,
                  exclusive_distributor_opens.distribution_name
                  FROM
                      exclusive_distributor_opens
                  JOIN bases ON exclusive_distributor_opens.base_id = bases.id
                  JOIN zones ON zones.id = bases.zone_id
                  JOIN regions ON zones.region_id = regions.id
                  JOIN user_tag_infos ON user_tag_infos.zone_id = zones.id AND user_tag_infos.region_id = regions.id
                  WHERE
                      exclusive_distributor_opens.dealer_active_status = '1' 
                      AND user_tag_infos.user_id = '$user_id'
                      AND exclusive_distributor_opens.company IN ('$group_id')");
       $results=DB::select("SELECT
                sales_entrie.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name,
                sales_entrie.retail_sale,
                sales_entrie.own_sale,
                sales_entrie.remarks,
                users.name,
                users.email,
                SUM(
                    sales_entrie.retail_sale + sales_entrie.own_sale
                ) AS total,
                sales_entrie.date
            FROM
                sales_entrie
            JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = sales_entrie.showroom_id
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON regions.id = zones.region_id
            JOIN users ON sales_entrie.user_id = users.id
            WHERE sales_entrie.user_id='$user_id'
            GROUP BY sales_entrie.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name,
                sales_entrie.retail_sale,
                sales_entrie.own_sale,
                sales_entrie.remarks,
                sales_entrie.date");
       return view('pages.showroom_selection.sales_entry')
              ->with('distributors', $distributors)
              ->with('results', $results);

    }
    public function entrySales(Request $request){
      
        // $t = Carbon::now();   
        // $day = $t->day;
        // $month = $t->month;
        // $year = $t->year;
        // if($day<10){

        //     $day='0'.$day;

        // }

        // if($month<10){

        //     $month='0'.$month;
        // }
        // $date=$year.'-'.$month.'-'.$day;
        $results=DB::table('exclusive_distributor_opens')->where('distribution_code', $request->distributor_id)->pluck('id');
        $data[] = [

          'showroom_id' => $results['0'],
          'retail_sale' => $request->retail_sale,
          'own_sale' => $request->own_sale,
          'remarks' => $request->remarks,
          'date' => $request->date,
          'user_id' => Auth::user()->id,
      ];
      DB::table('sales_entrie')->insert($data); 
      Toastr::success('Save Successfull......!!:)', 'Successfull');
      return redirect('get/sales/entry');
      
    }

    public function editSalesEntry($id){
       
       $results=DB::select("SELECT
            sales_entrie.id,
            exclusive_distributor_opens.distribution_code,
            exclusive_distributor_opens.showroom_name,
            exclusive_distributor_opens.address,
            zones.zone_name,
            bases.base_name,
            regions.region_name,
            users.name,
            sales_entrie.retail_sale,
            sales_entrie.own_sale,
            sales_entrie.remarks,
            SUM(
                sales_entrie.retail_sale + sales_entrie.own_sale
            ) AS total,
            sales_entrie.date
        FROM
            sales_entrie
        JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = sales_entrie.id
        JOIN bases ON exclusive_distributor_opens.base_id = bases.id
        JOIN zones ON zones.id = bases.zone_id
        JOIN regions ON regions.id = zones.region_id
        JOIN users ON sales_entrie.user_id = users.id
        WHERE sales_entrie.id='$id'"); 
        return view('pages.showroom_selection.sales_entry_edit')
              ->with('results',$results)
              ->with('id', $id);
    }

    public function editEntry(Request $request){

       DB::table('sales_entrie')
                ->where('id', $request->id)
                ->update([

            'retail_sale' => $request->retail_sale,
            'own_sale' => $request->own_sale,
            'remarks' => $request->remarks,
            'date' => $request->date   
        ]);

      Toastr::success('Edit Successfull......!!:)', 'Success');
      return redirect('get/sales/entry'); 

    }

    public function salesEntryReportHome(){

      $user_id=Auth::user()->id;
      $regions=Region::all();
      $results=\DB::select("SELECT companies.id,companies.company_name
              FROM user_group_permissions
              JOIN companies ON user_group_permissions.group_id=companies.id
              WHERE user_group_permissions.user_id='$user_id'");


      if(count($results)>0){

         
         return view('pages.showroom_selection.sales_report_home')
               ->with('results', $results)
               ->with('regions', $regions);

      }else{
          $results="";
          return view('pages.showroom_selection.sales_report_home')
                 ->with('results', $results)
                 ->with('regions', $regions);

      }

    }

    public function salesEntryReport(Request $request){


           if((!empty($request->from_date)) && (!empty($request->to_date))){

                $form_date=$request->from_date;
                $toDate = $request->to_date; 
                $to_date=date('Y-m-d', strtotime($toDate. ' + 1 days'));
                $results=DB::select("SELECT
                exclusive_distributor_opens.distributor_number,  
                sales_entrie.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name,
                users.email,
                sales_entrie.retail_sale,
                sales_entrie.own_sale,
                sales_entrie.remarks,
                SUM(
                    sales_entrie.retail_sale + sales_entrie.own_sale
                ) AS total,
                sales_entrie.date
            FROM
                sales_entrie
            JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = sales_entrie.showroom_id
            JOIN bases ON exclusive_distributor_opens.base_id = bases.id
            JOIN zones ON zones.id = bases.zone_id
            JOIN regions ON regions.id = zones.region_id
            JOIN users ON sales_entrie.user_id = users.id
            WHERE sales_entrie.date>='$form_date' AND sales_entrie.date<='$to_date' AND exclusive_distributor_opens.company='$request->company_id' AND exclusive_distributor_opens.id>='$request->from_party_code_id' AND exclusive_distributor_opens.id<='$request->to_party_code_id' AND regions.id>='$request->from_region' and regions.id<='$request->to_region'
            GROUP BY sales_entrie.id,
                exclusive_distributor_opens.distribution_code,
                exclusive_distributor_opens.showroom_name,
                exclusive_distributor_opens.address,
                zones.zone_name,
                bases.base_name,
                regions.region_name,
                users.name,
                users.email,
                sales_entrie.retail_sale,
                sales_entrie.own_sale,
                sales_entrie.remarks,
                sales_entrie.date
            ORDER BY total DESC");
                return view('pages.showroom_selection.sales_report')
                     ->with('results', $results);
              }else{

                 $results=DB::select("SELECT
                      exclusive_distributor_opens.distributor_number,
                      sales_entrie.id,
                      exclusive_distributor_opens.distribution_code,
                      exclusive_distributor_opens.showroom_name,
                      exclusive_distributor_opens.address,
                      zones.zone_name,
                      bases.base_name,
                      regions.region_name,
                      users.name,
                      users.email,
                      sales_entrie.retail_sale,
                      sales_entrie.own_sale,
                      sales_entrie.remarks,
                      SUM(
                          sales_entrie.retail_sale + sales_entrie.own_sale
                      ) AS total,
                      sales_entrie.date
                  FROM
                      sales_entrie
                  JOIN exclusive_distributor_opens ON exclusive_distributor_opens.id = sales_entrie.showroom_id
                  JOIN bases ON exclusive_distributor_opens.base_id = bases.id
                  JOIN zones ON zones.id = bases.zone_id
                  JOIN regions ON regions.id = zones.region_id
                  JOIN users ON sales_entrie.user_id = users.id
                  WHERE exclusive_distributor_opens.company='$request->company_id' 
                  AND exclusive_distributor_opens.id>='$request->from_party_code_id' 
                  AND exclusive_distributor_opens.id<='$request->to_party_code_id' 
                  AND regions.id>='$request->from_region' 
                  AND regions.id<='$request->to_region'
                  GROUP BY sales_entrie.id,
                  exclusive_distributor_opens.distribution_code,
                  exclusive_distributor_opens.showroom_name,
                  exclusive_distributor_opens.address,
                  zones.zone_name,
                  bases.base_name,
                  regions.region_name,
                  users.name,
                  sales_entrie.retail_sale,
                  sales_entrie.own_sale,
                  sales_entrie.remarks,
                  sales_entrie.date
                  ORDER BY total DESC");
                  return view('pages.showroom_selection.sales_report')
                       ->with('results', $results); 



     }

}

}
