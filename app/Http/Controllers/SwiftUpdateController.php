<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Excel;
use App\SaleContract;
use App\SwiftUpdate;
use Auth;
use Session;
use App\Company;
use App\SwiftHistory;
use Illuminate\Support\Facades\Input;
use DB;
class SwiftUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('swift_update.swift_excel_upload_home');
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
        $formated_file = $request->file('formated_file');
        $this->validate($request, [
        
           "formated_file"=>"required",
        ]);   
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->save_excel($datas);
        Session::flash("success", "Upload Succcessfully !");
        return redirect("/swift_update");
    }

    private function save_excel($datas){
         
          $user_id=Auth::user()->id;  
          foreach($datas as $key => $value){
            
            $sale_contact_id=SaleContract::where('invoice_no',$value->invoice_no)->pluck('id');
            if(isset($sale_contact_id['0'])){
                 
                $result=SwiftUpdate::where('sale_contract_id', $sale_contact_id)->get();
                if(count($result)>0){

                       
                }else{

                        $SwiftUpdate=new SwiftUpdate();
                        $SwiftUpdate->sale_contract_id=$sale_contact_id['0'];
                        $SwiftUpdate->invoice_no=$value->invoice_no;
                        $SwiftUpdate->bank_name=$value->bank_name;
                        $SwiftUpdate->company=$value->company;
                        $SwiftUpdate->remittance_amount=$value->remittance_amount;
                        $SwiftUpdate->realized_amount=$value->realized_amount;
                        $SwiftUpdate->remiter=$value->remiter;
                        $SwiftUpdate->arv=$value->arv;
                        $SwiftUpdate->realized_date=$value->realized_date;
                        $SwiftUpdate->status=$value->status;
                        $SwiftUpdate->save();

                              $swiftHistory=new SwiftHistory();
                              $swiftHistory->tt_number=$value->tt_number;
                              $swiftHistory->master_id=$SwiftUpdate->id;
                              $swiftHistory->breakup_value=$value->break_up;
                              $swiftHistory->value_date=$value->value_date;
                              $swiftHistory->creator_id=Auth::user()->id;
                              $swiftHistory->save();
                    }

            }
        
        }
        // }catch (Exception $e) {

        //    DB::rollback(); 
        //    echo 'Caught exception: ',  $e->getMessage(), "\n";

        // }

      Session::flash("success", "Upload Succcessfully !");
      return redirect('/swift_update');  


    }

    public function swiftExcelUpdate(Request $request){

            
        $this->validate($request, [
        
           "formated_file"=>"required",
        ]); 
        $formated_file = $request->file('formated_file');  
        $path = $formated_file->getRealPath();
        $datas = Excel::selectSheetsByIndex(0)->load($path, function ($reader) {})->get();
        $this->update_excel($datas);
        Session::flash("success", "Update Succcessfully !");
        return redirect("/swift_update");    
           

    }

    public function update_excel($datas){
       
        $user_id=Auth::user()->id;  
        foreach($datas as $key => $value){
            
            $swiftUpdateId=SwiftUpdate::where('invoice_no',$value->invoice_no)->pluck('id');
            if(isset($swiftUpdateId['0'])){
                $updateId=$swiftUpdateId['0'];  
                $SwiftUpdate=SwiftUpdate::findorfail($updateId);
                // $SwiftUpdate->sale_contract_id=$sale_contact_id['0'];
                // $SwiftUpdate->tt_number=$value->tt_number;
                // $SwiftUpdate->invoice_no=$value->invoice_no;
                // $SwiftUpdate->bank_name=$value->bank_name;
                // $SwiftUpdate->company=$value->company;
                // $SwiftUpdate->remittance_amount=$value->remittance_amount;
                // $SwiftUpdate->realized_amount=$value->realized_amount;
                // $SwiftUpdate->remiter=$value->remiter;
                // $SwiftUpdate->arv=$value->arv;
                // $SwiftUpdate->realized_date=$value->realized_date;
                $SwiftUpdate->status=$value->status;
                $SwiftUpdate->save();

                $swiftHistory=new SwiftHistory();
                $swiftHistory->master_id=$swiftUpdateId['0'];
                $swiftHistory->tt_number=$value->tt_number;
                $swiftHistory->breakup_value=$value->break_up;
                $swiftHistory->value_date=$value->value_date;
                $swiftHistory->creator_id=Auth::user()->id;
                $swiftHistory->save();
               
            }
        
        }


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

    public function swiftList(){

        $data=\DB::select("SELECT
            swift_updates.id,
            swift_updates.invoice_no,
            swift_updates.bank_name,
            swift_updates.company,
            swift_updates.remittance_amount,
            swift_updates.realized_amount,
            swift_updates.remiter,
            swift_updates.arv,
            swift_updates.realized_date,
            swift_updates.status,
            swift_histories.tt_number,
            swift_histories.breakup_value AS total,
            swift_histories.value_date,
            users.name,
            users.username
        FROM
            swift_updates
        JOIN swift_histories ON swift_histories.master_id=swift_updates.id
        JOIN users ON users.id=swift_histories.creator_id");
        $results=$this->generatePagination($data);
        return view('swift_update.swift_list')->with('results', $results);
                
    }

    private function generatePagination($data){

        $page = Input::get('page', 1);  
        $paginate = 10;    
        $offSet = ($page * $paginate) - $paginate;  
        $parameters = Input::getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
        $path = url('/') . '/swift_list?' . $parameters;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);  
        $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($data), $paginate, $page); 
        return $results = $results->withPath($path);
  

    }

    public function jsonGetSwiftList(Request $request){

        // return $results=\DB::select("SELECT tbl.*,swift_updates.realized_amount,swift_updates.realized_date,swift_updates.status,companies.name AS company_name,banks.name AS bank_name FROM (SELECT
        // swift_updates.id,
        // swift_updates.tt_number,
        // swift_updates.invoice_no
        // FROM
        // swift_updates
        // GROUP BY  swift_updates.tt_number,swift_updates.invoice_no) AS tbl
        // JOIN swift_updates ON swift_updates.id=tbl.id
        // JOIN sale_contracts ON sale_contracts.id= swift_updates.sale_contract_id
        // JOIN companies ON companies.id=sale_contracts.company_id
        // JOIN banks ON banks.id=sale_contracts.bank_id
        // WHERE swift_updates.tt_number LIKE '%$request->data%' OR swift_updates.invoice_no LIKE '%$request->data%' LIMIT 10");

        return $results=\DB::select("SELECT
                    swift_updates.id,
                    swift_updates.invoice_no,
                    swift_updates.bank_name,
                    swift_updates.company,
                    swift_updates.remittance_amount,
                    swift_updates.realized_amount,
                    swift_updates.remiter,
                    swift_updates.arv,
                    swift_updates.realized_date,
                    swift_updates.status,
                    swift_histories.tt_number,
                    swift_histories.breakup_value AS total,
                    swift_histories.value_date,
                    users.name,
                    users.username
                FROM
                    swift_updates
                JOIN swift_histories ON swift_histories.master_id=swift_updates.id
                JOIN users ON users.id=swift_histories.creator_id  WHERE swift_histories.tt_number LIKE '%$request->data%' OR swift_updates.invoice_no LIKE '%$request->data%' LIMIT 10");

    }

}
// 