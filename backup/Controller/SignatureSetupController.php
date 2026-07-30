<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\UserSignature;
use App\Company;
use Auth;
use DB;
use App\User;
use Session;
class SignatureSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $companies=Company::all();
        return view('signature.index')
               ->with('users',$users)
               ->with('companies',$companies);
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

        $image=$request->file('signature');
        $name= substr(md5(str_random(10)), 0, 8);
        $imageName = $name.'.'.$image->getClientOriginalExtension();
        $upload_path = 'signatures/';
        $image_url = $upload_path . $imageName;
        $success = $image->move($upload_path, $image_url);
        if(UserSignature::where('user_id',$request->user_id)->where('company_id',$request->company_id)->exists()){
            
            return response()->json([

                'message' => "Already exists!",
                "code"    => 404,
                
            ]);


        }else{
           
            $userSignature=new UserSignature();
            $userSignature->user_id=$request->user_id;
            $userSignature->company_id=$request->company_id;
            $userSignature->image_url=$image_url;
            $userSignature->save();
            if($userSignature->id){

                return response()->json([

                    'message' => "Data Updated Successfully!",
                    "code"    => 200,
                    
                ]);

            }else{

                return response()->json([

                    'message' => "Internal Server Error",
                    "code"    => 500

                ]);

            }            

        }
        

    }

    public function getUserSignature(Request $request){

        $results=DB::select("select
                user_signatures.id,
                CONCAT(users.username, '-', users.name) as user,
                companies.code                          as company,
                user_signatures.image_url               as image
            from user_signatures
            join users on users.id = user_signatures.user_id
            join companies on companies.id = user_signatures.company_id");

        if($results) {

            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $results
            ]);

        } else  {

            return response()->json([

                'message' => "Internal Server Error",
                "code"    => 500,
                "data"  => []
            ]);

        }

    }

    public function signatureEditData(Request $request){

        $users=User::all();
        $companies=Company::all(); 
        $userSignature=UserSignature::findorfail($request->edit_id);
        return response()->json([
            'users'=>$users,
            'companies'=>$companies,
            'updatedUserId'=>$userSignature->user_id,
            'updatedCompanyId'=>$userSignature->company_id
        ]);

    }

    public function updateSignature(Request $request){
        
        $previousImagePath="";
        $new_image_url="";
        if($request->file('esignature')){
          
            $image=$request->file('esignature');
            $name= substr(md5(str_random(10)), 0, 8);
            $imageName = $name.'.'.$image->getClientOriginalExtension();
            $upload_path = 'signatures/';
            $new_image_url = $upload_path . $imageName;
            $previousImageUrl=UserSignature::where('user_id',$request->euser_id)
                        ->where('company_id',$request->ecompany_id)
                        ->first(['image_url']);
            $previousImagePath=$previousImageUrl->image_url;
            $publicImagePath = public_path($previousImagePath);
            if(file_exists($publicImagePath)){
                
                if(unlink($publicImagePath)) {

                    $image->move($upload_path, $new_image_url);

                } 
            }

            $results=UserSignature::where('user_id',$request->euser_id)
                        ->where('company_id',$request->ecompany_id)
                        ->update([
                            'image_url'=>$new_image_url
                         ]);

            if($results){
              
                return response()->json([

                    'message' => "Data Updated Successfully!",
                    "code"    => 200,
                    
                ]); 

            }

        }else{

            $previousImageUrl=UserSignature::where('user_id',$request->euser_id)
                        ->where('company_id',$request->ecompany_id)
                        ->first(['image_url']);

            $previousImagePath=$previousImageUrl->image_url;

            $results=UserSignature::where('user_id',$request->euser_id)
                        ->where('company_id',$request->ecompany_id)
                        ->update([
                            'image_url'=>$previousImagePath
                         ]);

            return response()->json([

                'message' => "Data Updated Successfully!",
                "code"    => 200,
            
            ]); 


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
}
