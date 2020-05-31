<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function create() {
        return view('content.questionugc');
    }
    
    public function dynform(Request $request) {
        
        return view('home.dynform');
    }
    
    public function dynsubmit(Request $request) {
        
        Log::info($request->input('firstname'));
        
        $uf = $request->file('photo');
        Log::info($uf->getClientOriginalname());
        
        dd( $request);
        echo $request->input('fields')[0];
        echo $request->input('fields')[1];
        
        //$op = $request->input('op');
        
        return view('home.dvla');
    }
}
