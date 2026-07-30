<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadFormatController extends Controller
{
    public function download_format(){
        return view('download_format');
    }
}
