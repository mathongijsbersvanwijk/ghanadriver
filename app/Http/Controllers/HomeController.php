<?php
namespace App\Http\Controllers;


class HomeController extends Controller {
    public function __construct() {
        // $this->middleware('auth');
    }

    public function index() {
        return view('z.index');
    }

    public function ridehailing() {
        return view('home.ridehailing');
    }
}
