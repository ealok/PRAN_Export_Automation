<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Videos;
class DownloadFormatController extends Controller
{
    public function download_format(){
        
        return view('download_format');
    }

}
