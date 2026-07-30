<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Videos;
class VideoController extends Controller
{
    
    public function showVideo(){
        
        $results=Videos::all();
        return view('video')
              ->with('results',$results);

    }


}
