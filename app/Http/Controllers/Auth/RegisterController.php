<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\MacAddress;
use App\Company;

class RegisterController extends Controller{
   

    use RegistersUsers;
    protected $redirectTo = '/home';

   
    public function __construct(){

        $this->middleware('auth');

    }


    protected function validator(array $data){

        return Validator::make($data, [

            'name' => 'required|max:255',
            'username' => 'required|max:20|unique:users',
            // 'company_id' => 'required|exists:companies,id',
            // 'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
    }


    protected function create(array $data){
         
        $user_return =  User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'company_id' => 0,
            'password' => bcrypt($data['password']),
            'login_type' => $data['login_type'],
        ]);
        return $user_return;
    }

}
