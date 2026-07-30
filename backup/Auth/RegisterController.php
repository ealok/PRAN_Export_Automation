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

        // $this->middleware('auth');

    }


    protected function validator(array $data){

        return Validator::make($data, [

            'name' => 'required|max:255',
            'username' => 'required|max:20|unique:users',
            'company_id' => 'required|exists:companies,id',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'head_id'=>'required',
        ]);
    }


    protected function create(array $data){

    
        $user_return =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'company_id' => $data['company_id'],
            'password' => bcrypt($data['password']),
            'head_id' => $data['head_id'],
        ]);
        return $user_return;
    }

}
