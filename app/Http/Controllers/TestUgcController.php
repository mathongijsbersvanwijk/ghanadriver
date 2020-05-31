<?php

namespace App\Http\Controllers;

use App\Models\TestConfiguration;
use Illuminate\Http\Request;

class TestUgcController extends Controller
{
    public function index() {
        $tests = [];
        
        return view('content.tests.index', compact('tests'));
    }
    
    public function create() {
        return view('content.tests.create');
    }
    
    public function store(Request $request) {
        return redirect()->route('content.tests.index');
    }
    
    public function show(TestConfiguration $question) {
        //
    }
    
    public function edit(TestConfiguration $question) {
        //
    }
    
    public function update(Request $request, TestConfiguration $question) {
        //
    }
    
    public function destroy(TestConfiguration $question) {
        //
    }
}
