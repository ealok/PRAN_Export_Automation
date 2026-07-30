<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PFP;
use App\ODP;
use App\User;
use App\ProductionFloor;
use App\Depot;
class ProcessDataController extends Controller
{

    public function pfpDataGen(){

      $prodFloors=ProductionFloor::orderBy('id','ASC')->get();  
      $users=User::where('active',1)->get();
      foreach ($users as $key => $user) {

        foreach ($prodFloors as $key => $floor) {
             
            $pfp=new PFP();
            $pfp->user_id=$user->id;
            $pfp->pfp_id=$floor->id;
            $pfp->save();
            
        }     
        
       
      }

    }

    public function odpDataGen(){
         
        $depos=Depot::orderBy('id','ASC')->get();  
        $users=User::where('active',1)->get();
        foreach ($users as $key => $user) {
  
          foreach ($depos as $key => $depo) {
               
            $odp=new ODP();
            $odp->user_id=$user->id;
            $odp->odp_id=$depo->id;
            $odp->save();
              
          }     
          
         
        } 

        
    }


}
