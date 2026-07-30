<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Qc;
use DB;
use DateTime;
use App\QcEntry;
use App\User;
use App\Line;
use App\Batch;
use App\Shift;
use Auth;
use App\EntryDetail;
use App\ProdEntry;
use App\OrderStyle;
use App\Unit;
use App\MonthlyTarget;
use App\Slider;
use App\LC;
use App\TopCOO;
use App\TopPM;
use App\TopTenIEIncharge;
use App\TopTenIE;
use App\TopTenLine;
use App\LowestTenLine;
class Dashboard1Controller extends Controller{
   
    public function __construct(){

//        $this->middleware('auth');
      
    }



    public function dashboard1(Request $request){
        
        set_time_limit(300);  
        $qc_entry_count = QcEntry::count();
        $shifts = Shift::all();
        $this_month_all_unit_production = $this->get_this_month_all_unit_production();
        $todays_production = $this->get_todays_total_target_and_prod_of_given_date();
        $sliders = Slider::OrderBy('sequence','Asc')->get();
        $monthly_final_target = MonthlyTarget::OrderBy('id','desc')->first()->target;
        $prod_entries = ProdEntry::select('units.id as unit_id','prod_entries.line_id','order_styles.buyer_id','buyers.name as b_name','order_styles.board_no','order_styles.target_qty','order_styles.man_pawer','order_styles.smv','order_styles.actual_man_pawer')
                        ->join('lines','lines.id','=','prod_entries.line_id')
                        ->join('units','units.id','=','lines.unit_id')
                        ->join('order_styles','order_styles.id','=','prod_entries.order_style_id')
                        ->join('buyers','buyers.id','=','order_styles.buyer_id')
                        ->groupBy('units.id','prod_entries.line_id','order_styles.buyer_id','buyers.name','order_styles.board_no','order_styles.target_qty','order_styles.man_pawer','order_styles.actual_man_pawer','order_styles.smv')
                        ->whereDate('prod_entries.created_at' ,'=',date('Y-m-d'))
                        ->get(); 


                    // dd($prod_entries);
        return view('dashboard1')->with('prod_entries',$prod_entries)  
                    ->with('obj',$this)
                    ->with('shifts',$shifts)
                    ->with('sliders',$sliders)
                    ->with('this_month_all_unit_production',$this_month_all_unit_production)
                    ->with('monthly_final_target',$monthly_final_target) 
                    ->with('todays_production',$todays_production);     
    }

    public function chorkaLeaderBoard(Request $request){
       
       // $topcoos=TopCOO::orderBy('id','desc')->get();
       // $topPms=TopPM::orderBy('Unit','ASC')->get(); 
       // $ieIncharges=TopTenIEIncharge::orderBy('Unit','ASC')->get();
      // $lowestTenLines=LowestTenLine::orderBy('Unit','ASC')->get();
       $topTenLines=TopTenLine::orderBy('Percent','DESC')->get();
       $superHeros1=DB::select("select a.* from (
          select unit1_super_hero.Unit,unit1_super_hero.Sup_name,unit1_super_hero.Sup_ID,unit1_super_hero.Line,unit1_super_hero.Percent
          from unit1_super_hero
          union all
          select unit2_super_hero.Unit,unit2_super_hero.Sup_name,unit2_super_hero.Sup_ID,unit2_super_hero.Line,unit2_super_hero.Percent
          from unit2_super_hero
          union all
          select unit3_super_hero.Unit,unit3_super_hero.Sup_name,unit3_super_hero.Sup_ID,unit3_super_hero.Line,unit3_super_hero.Percent
          from unit3_super_hero) a
          order by a.Unit,a.Percent desc");

          $superHeros2=DB::select("select distinct b.* from (
              select unit4_super_hero.Unit,unit4_super_hero.Sup_name,unit4_super_hero.Sup_ID,unit4_super_hero.Line,unit4_super_hero.Percent
              from unit4_super_hero
              union all
              select unit5_super_hero.Unit,unit5_super_hero.Sup_name,unit5_super_hero.Sup_ID,unit5_super_hero.Line,unit5_super_hero.Percent
              from unit5_super_hero
              union all
              select unit6_super_hero.Unit,unit6_super_hero.Sup_name,unit6_super_hero.Sup_ID,unit6_super_hero.Line,unit6_super_hero.Percent
              from unit6_super_hero) b
              order by b.Percent desc");

        $superManagers=DB::select("select * from super_hero_pm order By Percent DESC");
        $superIEs=DB::select("select * from super_hero_ie orderBy Percent DESC");


       
        return view('leader_board')
             // ->with('topcoos',$topcoos)
             // ->with('topPms',$topPms)
             // ->with('ieIncharges',$ieIncharges)
             // ->with('topTenIes',$topTenIes)
             // ->with('lowestTenLines',$lowestTenLines);
             ->with('topTenLines',$topTenLines)
             ->with('superHeros1',$superHeros1)
             ->with('superHeros2',$superHeros2)
             ->with('superManagers',$superManagers)
             ->with('superIEs',$superIEs);
             
 
    }

    public function dashboard_md(Request $request){
         

        
        set_time_limit(0); 
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');  
        $month_ini = new DateTime("first day of last month");
        $first_day_of_prvious_month=$month_ini->format('Y-m-d'); 
        $current_month_name = date("F", strtotime($first_day_this_month));
        $previous_month_name = date("F", strtotime($first_day_of_prvious_month));

        $shifts = Shift::all();
        $this_month_all_unit_production = $this->get_this_month_all_unit_production();
        $todays_production = $this->get_todays_total_target_and_prod_of_given_date();
        $sliders = Slider::OrderBy('sequence','Asc')->get();
        $monthly_final_target = MonthlyTarget::OrderBy('id','desc')->first()->target;

        $efficiencyDashboardDetails=$this->getEfficiencyAndProductionsDeatils();
        $rejection_reports=$this->rejectionSummaryDetails();
        $shipment_summary=$this->shipmentSummaryDetails();
        $mmr_summary=$this->mmrSummaryDetails();
        $cuttingSummary=$this->cuttingSummaryDetails();
        $printingSummary=$this->printingSummaryDetails();
        $finishing_summary=$this->finishingSummaryDetails();
        $prod_entries = ProdEntry::select('units.id as unit_id','prod_entries.line_id','order_styles.buyer_id','buyers.name as b_name','order_styles.board_no','order_styles.target_qty','order_styles.man_pawer','order_styles.actual_man_pawer')
                        ->join('lines','lines.id','=','prod_entries.line_id')
                        ->join('units','units.id','=','lines.unit_id')
                        ->join('order_styles','order_styles.id','=','prod_entries.order_style_id')
                        ->join('buyers','buyers.id','=','order_styles.buyer_id')
                        ->groupBy('units.id','prod_entries.line_id','order_styles.buyer_id','buyers.name','order_styles.board_no','order_styles.target_qty','order_styles.man_pawer','order_styles.actual_man_pawer')
                        ->whereDate('prod_entries.created_at' ,'=',date('Y-m-d'))
                        ->get(); 
        
        return view('dashboard_md')->with('prod_entries',$prod_entries)  
                    ->with('obj',$this)
                    ->with('shifts',$shifts)
                    ->with('sliders',$sliders)
                    ->with('this_month_all_unit_production',$this_month_all_unit_production)
                    ->with('monthly_final_target',$monthly_final_target) 
                    ->with('todays_production',$todays_production)
                    ->with('efficiencyDashboardDetails',$efficiencyDashboardDetails)
                    ->with('current_month_name',$current_month_name)
                    ->with('previous_month_name',$previous_month_name)
                    ->with('rejection_reports',$rejection_reports)
                    ->with('shipment_summary',$shipment_summary)
                    ->with('cuttingSummary',$cuttingSummary)
                    ->with('printingSummary',$printingSummary)
                    ->with('mmr_summary',$mmr_summary)
                    ->with('finishing_summary',$finishing_summary);

    }

    public function printingSummaryDetails(){

       return $results=\DB::select("select printing_summary.* from printing_summary,
                (SELECT _printing_summary.unit_name,
                 MAX(_printing_summary.id) AS last_id
                 FROM printing_summary AS _printing_summary
                 GROUP BY _printing_summary.unit_name) max_user
                where printing_summary.id=max_user.last_id");  

    }

    public function finishingSummaryDetails(){
            
       return $results=\DB::select("select finishing_prod_summary.* from finishing_prod_summary,
                (SELECT _finishing_prod_summary.unit_name,
                MAX(_finishing_prod_summary.id) AS last_id
                FROM finishing_prod_summary AS _finishing_prod_summary
                GROUP BY _finishing_prod_summary.unit_name) max_user
                where finishing_prod_summary.id=max_user.last_id");  

    }

    
    public function mmrSummaryDetails(){

       return $results=\DB::select("select mmr_summary.* from mmr_summary,
            (select _mmr_summary.unit_name,max(_mmr_summary.id) as last_id
             from mmr_summary as _mmr_summary
             group by _mmr_summary.unit_name) max_user
          where mmr_summary.id=max_user.last_id;");  

    }


    public function cuttingSummaryDetails(){

       return $results=\DB::select("select cutting_summary.* from cutting_summary,
          (select _cutting_summary.unit,max(_cutting_summary.id) as last_id
           from cutting_summary as _cutting_summary
           group by _cutting_summary.unit) max_user
        where cutting_summary.id=max_user.last_id");  

    }

    public function getEfficiencyAndProductionsDeatils(){

      return $results=\DB::select("select efficiency_dashboard_data.* from efficiency_dashboard_data,
            (select _efficiency_dashboard_data.unit_name,max(_efficiency_dashboard_data.id) as last_id
             from efficiency_dashboard_data as _efficiency_dashboard_data
             group by _efficiency_dashboard_data.unit_name) max_user
          where efficiency_dashboard_data.id=max_user.last_id");   


    }

    public function rejectionSummaryDetails(){

      return $results=\DB::select("select rejection_summary.* from rejection_summary,
            (select _rejection_summary.unit,max(_rejection_summary.id) as last_id
          from rejection_summary as _rejection_summary
          group by _rejection_summary.unit) max_user
          where rejection_summary.id=max_user.last_id;");


    }

    public function shipmentSummaryDetails(){

      return $results=\DB::select("select team_wise_shipment.* from team_wise_shipment,
            (select _team_wise_shipment.team_name,max(_team_wise_shipment.id) as last_id
             from team_wise_shipment as _team_wise_shipment
             group by _team_wise_shipment.team_name) max_user
          where team_wise_shipment.id=max_user.last_id;");

    }

    public function lc_dashboard(Request $request){
         
        if($request->ouId=="All" || $request->ouId==""){
             
            $list_of_lc=\DB::select("SELECT * FROM `l_c_s_3` ORDER BY `R_NUM` DESC");
            $items=DB::select("SELECT DISTINCT `ITEM` FROM l_c_s_3 Order By ITEM ASC");
            $ous=DB::select("SELECT DISTINCT `U_OU` FROM l_c_s_3 Order By U_OU ASC");
            return view('dashboard_lc')
                   ->with('list_of_lc',$list_of_lc)
                   ->with('items',$items)
                   ->with('ous',$ous)
                   ->with('ouId',''); 

        }else if($request->ouId && $request->item_id){
             
            $list_of_lc=\DB::select("SELECT * FROM `l_c_s_3` where U_OU='$request->ouId' AND ITEM like '%$request->item_id%' ORDER BY `R_NUM` DESC");
            $items=DB::select("SELECT DISTINCT `ITEM` FROM l_c_s_3 where U_OU='$request->ouId' Order By ITEM DESC");
            $ous=DB::select("SELECT DISTINCT `U_OU` FROM l_c_s_3 Order By U_OU ASC");
            return view('dashboard_lc')
                   ->with('list_of_lc',$list_of_lc)
                   ->with('items',$items)
                   ->with('ous',$ous)
                   ->with('ouId',$request->ouId);

        }else if($request->ouId){

            $list_of_lc=\DB::select("SELECT * FROM `l_c_s_3` where U_OU='$request->ouId'ORDER BY `R_NUM` DESC");
            $items=DB::select("SELECT DISTINCT `ITEM` FROM l_c_s_3 where U_OU='$request->ouId' Order By ITEM DESC");
            $ous=DB::select("SELECT DISTINCT `U_OU` FROM l_c_s_3 Order By U_OU ASC");
            return view('dashboard_lc')
                   ->with('list_of_lc',$list_of_lc)
                   ->with('items',$items)
                   ->with('ous',$ous)
                   ->with('ouId',$request->ouId);  


        }else if($request->ouId=="" && !empty($request->item_id)){

                
             return 100;   


        } 

        

    }

    public function lineWiseDashboard(Request $request){
        
        try {

              $date=$date=date('Y-m-d');
              $plan_target=OrderStyle::whereDate('created_at','=',$date)->sum('target_qty');
              $last_day=date('Y-m-d', strtotime(' -1 day'));
              $last_day_total_target=OrderStyle::whereDate('created_at', '=', $last_day)->sum('target_qty');
              $last_day_total_prod=ProdEntry::whereDate('created_at', '=', $last_day)->sum('production_qty');
              $altered_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$request->line_id)->sum('altered_qty');
              if($last_day_total_target==0){
                
                $last_day_total_target=1;

              }
              $last_day_eff=($last_day_total_prod/$last_day_total_target)*100;
              $last_day_eff=number_format($last_day_eff,3);
              $buyers=OrderStyle::select('buyers.name')
                                  ->whereDate('order_styles.created_at','=',$date)
                                  ->where('order_styles.line_id', $request->line_id)
                                  ->join('buyers','buyers.id','order_styles.buyer_id')
                                  ->get();
              $buyer_name="";
              foreach($buyers as $key => $value) {
                
                $buyer_name=$buyer_name.$value->name.',';

                                     
              }

              $buyer_name=mb_substr($buyer_name, 0, -1);
              $styles=OrderStyle::select('styles.name')
                          ->whereDate('order_styles.created_at','=',$date)
                          ->where('order_styles.line_id', $request->line_id)
                          ->join('styles','styles.id','order_styles.style_id')
                          ->get();

              $style_name="";
              foreach($styles as $key => $value) {
              
                  $style_name=$style_name.$value->name.',';
                                     
              }
              $style_name=mb_substr($style_name, 0, -1);
              $categoryies=OrderStyle::select('categories.name')
                          ->whereDate('order_styles.created_at','=',$date)
                          ->where('order_styles.line_id', $request->line_id)
                          ->join('categories','categories.id','order_styles.category_id')
                          ->get();

              $category_name="";
              foreach($categoryies as $key => $value) {
              
                  $category_name=$category_name.$value->name.',';
                                     
              }
              $category_name=mb_substr($category_name, 0, -1);
              $line_name=Line::where('id', $request->line_id)->pluck('name')->first();
              $loop_lenght=Line::where('id', $request->line_id)->get();
              $list_of_lc=\DB::select("SELECT * FROM `l_c_s` LIMIT 1");
              $lines=Line::all(); 

        } catch (Exception $e) {
          


          
        }
         
        return view('line_wise_dashboard')
               ->with('list_of_lc', $list_of_lc)
               ->with('lines', $lines)
               ->with('plan_target', $plan_target)
               ->with('last_day_total_target', $last_day_total_target)
               ->with('buyer_name',$buyer_name)
               ->with('style_name',$style_name)
               ->with('category_name',$category_name)
               ->with('line_name', $line_name)
               ->with('last_day_total_prod',$last_day_total_prod)
               ->with('last_day_eff',$last_day_eff)
               ->with('loop_lenght',$loop_lenght)
               ->with('altered_qty',$altered_qty)
               ->with("obj" ,$this);
    }

    public function getTarget($line_id,$shift_number){

          
          switch ($shift_number) {

            case 1:
              return $this->getShiftTargetForEight($line_id,$shift_number);
              break;
            case 2:
              return $this->getShiftTargetForNine($line_id,$shift_number);
              break;
            case 3:
              return $this->getShiftTargetForTen($line_id,$shift_number);
              break; 
            case 4:
              return $this->getShiftTargetForEliven($line_id,$shift_number);
              break; 
            case 5:
              return $this->getShiftTargetForTwelve($line_id,$shift_number);
              break;
            case 6:
              return $this->getShiftTargetForTwo($line_id,$shift_number);
              break;
            case 7:
              return $this->getShiftTargetForThree($line_id,$shift_number);
              break;
            case 8:
              return $this->getShiftTargetForFour($line_id,$shift_number);
              break;
            case 9:
              return $this->getShiftTargetForFive($line_id,$shift_number);
              break;
            case 10:
              return $this->getShiftTargetForSix($line_id,$shift_number);
              break;
          }


    }

    public function getShiftProduction($line_id,$shift_number){

          switch ($shift_number) {

            case 1:
              return $this->getShiftProductionForEight($line_id,$shift_number);
              break;
            case 2:
              return $this->getShiftProductionForNine($line_id,$shift_number);
              break;
            case 3:
              return $this->getShiftProductionForTen($line_id,$shift_number);
              break; 
            case 4:
              return $this->getShiftProductionForEliven($line_id,$shift_number);
              break; 
            case 5:
              return $this->getShiftProductionForTwelve($line_id,$shift_number);
              break;
            case 6:
              return $this->getShiftProductionForTwo($line_id,$shift_number);
              break;
            case 7:
              return $this->getShiftProductionForThree($line_id,$shift_number);
              break;
            case 8:
              return $this->getShiftProductionForFour($line_id,$shift_number);
              break;
            case 9:
              return $this->getShiftProductionForFive($line_id,$shift_number);
              break;
            case 10:
              return $this->getShiftProductionForSix($line_id,$shift_number);
              break;
          }
 

    }

    private function getShiftTargetForEight($line_id,$shift_number){
 
       $date=$date=date('Y-m-d');
       return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');

    } 

    private function getShiftTargetForNine($line_id,$shift_number){

       $date=$date=date('Y-m-d');
       return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }

    private function getShiftTargetForTen($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');

    }

    private function getShiftTargetForEliven($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }

    private function getShiftTargetForTwelve($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target'); 

    }

    private function getShiftTargetForTwo($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }

    private function getShiftTargetForThree($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }

    private function getShiftTargetForFour($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }

    private function getShiftTargetForFive($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }

    private function getShiftTargetForSix($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('hourly_target');
      
    }


    /////----------------Get Production--------------

    public function getShiftProductionForEight($line_id,$shift_number){

      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');          

    } 

    public function getShiftProductionForNine($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    } 

    public function getShiftProductionForTen($line_id,$shift_number){
    
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }

    public function getShiftProductionForEliven($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }

    public function getShiftProductionForTwelve($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }

    public function getShiftProductionForTwo($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }

    public function getShiftProductionForThree($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }

    public function getShiftProductionForFour($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }
    public function getShiftProductionForFive($line_id,$shift_number){

          
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  


    }

    public function getShiftProductionForSix($line_id,$shift_number){
      
      $date=$date=date('Y-m-d');
      return $target_qty=ProdEntry::whereDate('created_at', '=', $date)->where('line_id',$line_id)->where('shift_id',$shift_number)->sum('production_qty');  

    }

    public function dashboard2(Request $request){

       // $qc_entry_count = QcEntry::count();
        $shifts = Shift::all();
        $this_month_all_unit_production = $this->get_this_month_all_unit_production();
        $todays_production = $this->get_todays_total_target_and_prod_of_given_date();
        $sliders = Slider::OrderBy('sequence','Asc')->get();
        $monthly_final_target = MonthlyTarget::OrderBy('id','desc')->first()->target;

        $prod_entries = ProdEntry::select('units.id as unit_id','prod_entries.line_id','order_styles.buyer_id','buyers.name as b_name','order_styles.board_no','order_styles.target_qty','order_styles.man_pawer','order_styles.actual_man_pawer')
                        ->join('lines','lines.id','=','prod_entries.line_id')
                        ->join('units','units.id','=','lines.unit_id')
                        ->join('order_styles','order_styles.id','=','prod_entries.order_style_id')
                        ->join('buyers','buyers.id','=','order_styles.buyer_id')
                        ->groupBy('units.id','prod_entries.line_id','order_styles.buyer_id','buyers.name','order_styles.board_no','order_styles.target_qty','order_styles.man_pawer','order_styles.actual_man_pawer')
                        ->whereDate('prod_entries.created_at' ,'=',date('Y-m-d'))
                        ->get(); 


        return view('dashboard2')->with('prod_entries',$prod_entries)  
                    ->with('obj',$this)
                    ->with('shifts',$shifts)
                    ->with('sliders',$sliders)
                    ->with('this_month_all_unit_production',$this_month_all_unit_production)
                    ->with('monthly_final_target',$monthly_final_target) 
                    ->with('todays_production',$todays_production);     
    }

    public function board(Request $request){

        $shifts             = Shift::all();  
        $lines              = Line::all();
        $order_styles       = OrderStyle::where('line_id',$request->line_id)->whereDate('created_at',date('Y-m-d'))->get();
    
        $prod_entries  = ProdEntry::whereDate('created_at',date('Y-m-d'))
                       ->where('line_id',$request->line_id)
                       ->where('order_style_id',$request->order_style_id)
                       ->get(); 

        return view('board')->with('shifts',$shifts)
                          ->with('lines',$lines)
                          ->with('order_styles',$order_styles)
                          ->with('prod_entries',$prod_entries)
                          ->with('obj',$this);     
   }


 


   public function getProductionQtyOfShiftAndLine($line_id,$order_style_id,$shift_id){
        return ProdEntry::select('production_qty')
                         ->where('shift_id',$shift_id)
                         ->where('line_id',$line_id)
                         ->where('order_style_id',$order_style_id)
                         ->whereDate('created_at',date('Y-m-d'))
                         ->get();

    }

    public function getAlteredQtyOfShiftAndLine($line_id,$order_style_id,$shift_id){
        return ProdEntry::select('altered_qty')
                         ->where('shift_id',$shift_id)
                         ->where('line_id',$line_id)
                         ->where('order_style_id',$order_style_id)
                         ->whereDate('created_at',date('Y-m-d'))
                         ->get();

    }

    public function getRepairedQtyOfShiftAndLine($line_id,$order_style_id,$shift_id){
        return ProdEntry::select('repaired_qty')
                ->where('shift_id',$shift_id)
                ->where('line_id',$line_id)
                ->where('order_style_id',$order_style_id)
                ->whereDate('created_at',date('Y-m-d'))
                ->get();
    
    }

    public function  input_value_of_param_and_Entry_id($qc_entry_id,$param_id){
        $entry_detail = EntryDetail::where('param_id',$param_id)
                            ->where('qc_entry_id',$qc_entry_id)->get();
                        
        if($entry_detail->first()){
            return $entry_detail->first()->input_value;
        }else{
            return 0;
        }

                            
    }




  


    public function getProduction($line_id,$shift_id){

        $prod_entries = ProdEntry::where('prod_entries.line_id',$line_id)
                        ->where('prod_entries.shift_id',$shift_id)
                        ->whereDate('prod_entries.created_at' ,'=',date('Y-m-d'))
                        ->with('order_style')
                        ->get(); 
                        
        return $prod_entries;

        // hr -- pd 
        // 1   (pd/hr) 
        // 100  (pd/hr)* 100

    }


    public function getActualProductionOfThisLineToday($line_id,$shift_id,$item_id){

        $qc_entries = QcEntry::select('entry_details.input_value as total',DB::Raw('(entry_details.input_value / (batches.batch_qty/10)) * 100 as perc'))
                    ->join('lines','lines.id','=','qc_entries.line_id')
                    ->join('batches','batches.id','=','qc_entries.batch_id')
                    ->join('shifts','shifts.id','=','qc_entries.shift_id')
                    ->join('items','items.id','=','batches.item_id')
                    ->join('entry_details','entry_details.qc_entry_id','=','qc_entries.id')
                    ->join('params','params.id','entry_details.param_id')
                    ->whereDate('qc_entries.created_at' ,'=',date('Y-m-d'))
                    ->where('items.id',$item_id)
                    ->where('qc_entries.line_id',$line_id)
                    ->where('qc_entries.shift_id',$shift_id)
                    ->where('params.pmaster_id',1)
                    ->get(); 

            if($qc_entry = $qc_entries->first()){
               return $qc_entry;     
            }else{
                return 0;
            }

    }

    public function getCount($fg_id){
        $packages = DB::table('packages')
            ->whereDate('packages.date',date('Y-m-d')) 
            ->where('packages.fg_id',$fg_id) 
            ->get()->count();
        return $packages;    
    }

    public function getFgName($fg_id){
        $fg = Fg::find($fg_id);
        return $fg->fg_name;
    }




   public function getDate($time){
        $start = date('H:i:s',strtotime("01:00:00"));
        $end   = date('H:i:s',strtotime("08:00:00"));

        if($start <=  $time  && $time <= $end){
           $date = new DateTime();
           return $date->modify('-1 day')->format("Y-m-d");  

        }else{

           return date('Y-m-d');
        }
    }


    private function get_this_month_all_unit_production(){
         
           $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
           $last_day_this_month  = date('Y-m-t'); 
           $prod_entries=ProdEntry::select(DB::raw('SUM(prod_entries.production_qty) as production_qty'),DB::raw('SUM(prod_entries.hourly_target) as target_qty') )
                   ->join('order_styles','order_styles.id','prod_entries.order_style_id')
                   ->join('lines','lines.id','prod_entries.line_id')
                   ->join('units','units.id','lines.unit_id')
                   ->where('prod_entries.created_at', '>=',$first_day_this_month)
                   ->where('prod_entries.created_at', '<=',$last_day_this_month)
                   ->get();
          return $prod_entries;      

    }


      private function get_todays_total_target_and_prod_of_given_date(){
        $prod_entries=ProdEntry::select(DB::raw('SUM(prod_entries.production_qty) as production_qty'),
                                        DB::raw('SUM(prod_entries.hourly_target) as target_qty'),
                                        DB::raw(' (SUM(prod_entries.production_qty)  * 100 ) / SUM(prod_entries.hourly_target)  as percent')
                                         )
                   ->whereDate('prod_entries.created_at',date("Y-m-d"))
                   ->get();
        return $prod_entries;          
      }


      public function unitwise_shift_wise_sum($shift_id,$unit_id){
        $prod_entries=ProdEntry::select(DB::raw('SUM(prod_entries.production_qty) as production_qty'),DB::raw('SUM(prod_entries.hourly_target) as target_qty') )
                   ->join('order_styles','order_styles.id','prod_entries.order_style_id')
                   ->join('lines','lines.id','prod_entries.line_id')
                   ->join('units','units.id','lines.unit_id')
                   ->where('prod_entries.shift_id',$shift_id)
                   ->where('units.id',$unit_id)
                   ->where('prod_entries.created_at',date("Y-m-d"))
                   ->get();
        return $prod_entries;          
      }

      public function commonDashboard(Request $request){

        //return $request->all();

        $qc_entry_count = QcEntry::count();
        $shifts = Shift::all();
        $units = Unit::all();


        if($request->unit_id != ''){

           $unit_ids[] = $request->unit_id; 

        }else{
          
            $unit_ids = Unit::pluck('id'); 
        }


        $prod_entries = ProdEntry::select('prod_entries.line_id','order_styles.buyer_id','buyers.name as b_name','order_styles.board_no','order_styles.target_qty')
                        ->join('lines','lines.id','=','prod_entries.line_id')
                        ->join('order_styles','order_styles.id','=','prod_entries.order_style_id')
                        ->join('buyers','buyers.id','=','order_styles.buyer_id')
                        ->groupBy('prod_entries.line_id','order_styles.buyer_id','buyers.name','order_styles.board_no','order_styles.target_qty')
                        ->where('order_styles.is_end',0)
                        ->whereDate('prod_entries.created_at' ,'=',date('Y-m-d'))
                        ->whereIn('lines.unit_id',$unit_ids)
                        ->get();

        return view('common_dashboard')->with('prod_entries',$prod_entries)  
                    ->with('obj',$this)
                    ->with('shifts',$shifts)
                    ->with('units',$units)
                    ->with('qc_entry_count',$qc_entry_count); 

      }


}
