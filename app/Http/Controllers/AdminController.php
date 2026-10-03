<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Feature;
use App\UserFeatures;
use Auth;
use Hash;
use Session;
use App\Role;
use App\Desk;
use App\DeskSetup;
use App\UserRole;
use DB;

class AdminController extends Controller
{ 
    public function __construct()
    {
       $this->middleware('auth');
    }
   
    public function index()
    {   
              
        $admins = User::with('head')->orderBy('id','DESC')->get();
        return View('admin.admin')->with('admins',$admins);
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
        //
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
        $admin = User::find($id);
        $users=User::all();
        return view('admin.admin_edit',compact('admin'))
               ->with('users',$users);
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


        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:20|unique:users,username,'.$id
        ]);

        if($request->active == 'on'){

            $request->active = 1;

        }else{

            $request->active = 0;

        }


        $admin = User::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->active = $request->active;
        $admin->login_type = $request->login_type;
        $admin->save();

        Session::flash('success','Successfully Edited');  
        return redirect('/admin');

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

    public function reset_password_view($id){
          // $this->validate($request,[
          //        'password' => 'required|min:6|confirmed',
          //   ]);
          
          return view('admin.reset_password',compact('id'));
     }

     public function reset_password(Request $request){
          $this->validate($request,[
                 'password' => 'required|min:6|confirmed',
                ]);
       
          
           if (Auth::check()){
              $admin_id = Auth::user()->id;
                 if($this->check_logged_admin_password_match($request->admin_password)){                                  
                    $obj_user = User::find($request->id);
                    $obj_user->password = Hash::make($request->password);
                    $obj_user->save(); 
                    Session::flash('success','Successfully Password Reset'); 
                 }else{
                    Session::flash('danger','Password Reset Unsuccessfull -- Authentication Failed'); 
                 }

            }else{


            }
        
          
           return redirect('/admin');
     } 

     public function check_logged_admin_password_match($admin_password){
          $current_password = Auth::User()->password;           
          if(Hash::check($admin_password, $current_password)){    
            return 1;
          }else{
            return 0;
          }
     
     } //end andmin password match


     public function access_edit($id){
         $features = Feature::all();
         $feature_accessed = UserFeatures::where('user_id',$id)->get();
         $user=User::find($id);

         return view('admin.access_edit',compact('features'))
                    ->with('feature_accessed',$feature_accessed)
                    ->with('id',$user->id)
                    ->with('data',$this)
                    ->with('user_name',$user->name);
     }


     public function access_set(Request $request){
        //  if($request->status == '1'){
        //      $result= $this->assign_feature_to_the_user($request);
        //  }else{
        //      $result= $this->remove_feature_from_user($request);
        //  } 
        $result= $this->assign_feature_to_the_user($request) ;     
         return redirect()->back();
     }


     private function assign_feature_to_the_user($request){

        $maches = ['user_id'=>$request->user_id,'feature_id'=>$request->feature_id];
        $feature_exist = UserFeatures::where($maches)->get();

        if($feature_exist->first()){

             return 'Already Exist';

        }else{

          $admin_id  = Auth::User()->id;  
          $feature_new = new UserFeatures;
          $feature_new->user_id = $request->user_id;
          $feature_new->feature_id =$request->feature_id;
          $feature_new->admin_id = $admin_id;
          $feature_new->save();
          return 'Feature Added';
        }         

     }

     private function remove_feature_from_user($request){
        $maches = ['user_id'=>$request->user_id,'feature_id'=>$request->feature_id];
        $feature_exist = UserFeatures::where($maches)->get();            
        if($feature_exist->first()){
           $res = $feature_exist->first();
           UserFeatures::destroy($res->id);
           return "Feature Removed";
        }else{
            return "Already Removed";
        }
            
    }

    public function delete_user_feature(Request $request){
        $maches = ['user_id'=>$request->user_id,'feature_id'=>$request->feature_id];
        $feature_exist = UserFeatures::where($maches)->get();            
        if($feature_exist->first()){
           $res = $feature_exist->first();
           UserFeatures::destroy($res->id);
           return redirect()->back();
        }else{
            return redirect()->back();
        }
    }


    public static function isFeatureCheckedMarked($feature_id,$user_id){
        $maches = ['user_id'=>$user_id,'feature_id'=>$feature_id];
        $feature_accessable = UserFeatures::where($maches)->get();

        ($feature_accessable->first()) ? $result = 1 : $result = 0;

           return $result;
     }


     public static function isAccessable($feature_id){
        if(Auth::User()){
            $admin_id  = Auth::User()->id;
            $maches = ['user_id'=>$admin_id,'feature_id'=>$feature_id];
            $feature_accessable = UserFeatures::where($maches)->get();

            ($feature_accessable->first()) ? $result = 1 : $result = 0;

        }else{
            
            $result = 0;
        }
      

        return $result;
     }


     public function profile(){
        
        $admin_id = Auth::user()->id; 
        $user = User::find($admin_id);
        return view('admin.profile',compact('user'));
        
     }



     // Reset profile password start
      public function reset_profile_password_view(){

          return view('admin.reset_profile_password');
     }

     public function reset_profile_password_update(Request $request){

         $users=User::where('id',Auth::user()->id)->update([
            'password'=>bcrypt($request->newPassword)
        ]);

        if($users) {
            return response()->json(['success' => true, 'message' => 'Password reset successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to reset password']);
        }
        
     }
     // Reset Profile password end 


     public function getFeatureName($id){
          $feature = Feature::where('id',$id)->get();

         if($feature->first()){
            return $feature->first()->name;
         }else{
             return '';
         }
         
     }


    public function checkroll($id) {

        $user_id = Auth::id();
        return $feature_id = $id;
        $result = DB::table('user_features')
                ->where('user_id', $user_id)
                ->where('feature_id', $feature_id)
                ->get();
        if (count($result) > 0) {

            return 1;
            
        } else {

            return 0;
        }
        
    }  

    public function activeUserPermission(Request $request){
         
        $urers=User::where('active',1)->get();
        foreach ($urers as $key => $value) {

            $userFeatures=new UserFeatures();
            $userFeatures->user_id=$value->id;
            $userFeatures->feature_id=46;
            $userFeatures->admin_id=Auth::user()->id;
            $userFeatures->save();
           
        }
        
        

    }
    
    public function UserReg(){

        $roles=Role::where('is_visible',1)->get();
        $desks=Desk::where('status',1)->get();
        return View('admin.urser_registration')
               ->with('roles',$roles)
               ->with('desks',$desks);

    }

    public function regUser(Request $request){

        $desk = DeskSetup::where('desk_id', $request->desk_id)->first();
        if($desk){
            $desk_head_id = $desk->DESK_HEAD_ID;
        }else{
            $desk_head_id = NULL;
        }
        
        if(User::where('username', $request->staff_id)->count() > 0){

            return response()->json([
                'code' => 404,
                'message' => 'User Already Exists'
            ]);

        }
        
        else if(User::where('email', $request->email)->count()){

            return response()->json([
                'code' => 404,
                'message' => 'Email Already Exists'
            ]);

        } else {
            
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->staff_id;
            $user->email = $request->email ? $request->email : NULL;
            $user->password = bcrypt($request->password);
            $user->head_id = $desk_head_id;
            $user->jo_mail_status = ($request->role_id == 2) ? 1 : 0;
            $user->role_id = $request->role_id;
            $user->login_type = $request->login_type;
            $user->company_id = 1;
            $user->save();
            if($request->role_id==2){

                $deskPermission=UserFeatures::where('user_id',12)->get();
                foreach($deskPermission as $permission){

                    $userFeature=new UserFeatures();   
                    $userFeature->user_id=$user->id;
                    $userFeature->feature_id=$permission->feature_id;
                    $userFeature->admin_id=1;
                    $userFeature->save();

                }

                $regUser=new UserRole();
                $regUser->user_id=$user->id;
                $regUser->role_id=$request->role_id;;
                $regUser->assigned_by=1;
                $regUser->expires_at=NULL;
                $regUser->is_active=1;
                $regUser->save();

            }elseif($request->role_id==11){

                $deskPermission=UserFeatures::where('user_id',28)->get();
                foreach($deskPermission as $permission){

                    $userFeature=new UserFeatures();   
                    $userFeature->user_id=$user->id;
                    $userFeature->feature_id=$permission->feature_id;
                    $userFeature->admin_id=1;
                    $userFeature->save();

                }

                $regUser=new UserRole();
                $regUser->user_id=$user->id;
                $regUser->role_id=$request->role_id;;
                $regUser->assigned_by=1;
                $regUser->expires_at=NULL;
                $regUser->is_active=1;
                $regUser->save();

            }  
          
            if($user->id){
                return response()->json([
                    'code' => 200,
                    'message' => 'User created successfully..!!'
                ]);
            }

        }

    }


     public function getUserList(Request $request){
      
       $users=DB::select("select
                    u.id,
                    u.name,
                    u.username as staff_id,
                    u.email,
                    r.name as role,
                    case when u.active=1 then 'Active' else 'Inactive' end as status
                from users u
                join roles r on r.id = u.role_id
                where u.active=1
                order by u.id asc");
       return response()->json([
          'data'=>$users
       ]);

    }

    public function inactiveUser(Request $request){

        $result=User::where('id',$request->userId)->update([
            'active'=> 0
        ]);

        if($result){
            return response()->json([
                'code'=> 200,
                'message'=> 'Inactive Done..!!'
            ]);
        }else{
            return response()->json([
                'code'=> 500,
                'message'=> 'Inactive Failed..!!'
            ]);
        }
        // return $request->all();

    }


}