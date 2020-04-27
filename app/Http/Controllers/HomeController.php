<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index() {
        return view('z.index');
    }

    public function ridehailing() {
        return view('home.ridehailing');
    }

    public function dvla() {
        return view('home.dvla');
    }
}
