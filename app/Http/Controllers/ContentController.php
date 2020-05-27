<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function dynform(Request $request) {
        
        return view('home.dynform');
    }

    public function dynsubmit(Request $request) {
        
        //dd( $request->input('fields')[0]);
        echo $request->input('fields')[0];
        echo $request->input('fields')[1];
        
        //$op = $request->input('op');
        
        return view('home.dynform');
    }
}
