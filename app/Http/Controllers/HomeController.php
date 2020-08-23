<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index() {
        return view('z.index');
    }

    public function createyourown() {
        return view('home.createyourown');
    }
    
    public function dvla() {
        return view('home.dvla');
    }
    
    public function privacypolicy() {
        return view('home.privacypolicy');
    }

    public function ridehailing() {
        return view('home.ridehailing');
    }
}
