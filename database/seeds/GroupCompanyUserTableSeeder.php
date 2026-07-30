<?php

use Illuminate\Database\Seeder;

class GroupCompanyUserTableSeeder extends Seeder{

    public function run(){
        DB::table('groups')->insert([
            'id'  =>1,
            'name' => "PRAN",
         
        ]);
        DB::table('groups')->insert([
            'id'  =>2,
            'name' => "RFL",
         
        ]);
        
         DB::table('companies')->insert([
            'id'  =>1,
            'name' => "PRAN",
            'code' => "PRAN",
            'erc_no'=> "ERCNO",
            'bin_No' => "BINNO",
            'factory_name' => "Factory PRAN",
            'factory_address' => "Factory Address",
            'ho_address' => "HO Address",
            'group_id' => 1,
        ]);
        DB::table('companies')->insert([
            'id'  =>2,
            'name' => "RFL COMPANY",
            'code' => "RFLC",
            'erc_no'=> "ERCNOR",
            'bin_No' => "BINNOR",
            'factory_name' => "Factory PRAN",
            'factory_address' => "Factory Address",
            'ho_address' => "HO Address",
            'group_id' => 2,
        ]);
       //user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => '111',
            'company_id' => 1,
            'password' => bcrypt('123456'),
        ]);


   



    }
}
