<?php

namespace App\Http\Controllers;

use App\Models\TestConfiguration;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestUgcController extends Controller
{
    public function index(TestConfigurationService $tcfs) {
    }
    
    public function create(QuestionService $qs) {
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        
        return view('content.tests.choosequestions', compact('ldq'));
    }
    
    public function chosenquestions($tstid, QuestionService $qs) {
        // $tstid is null the first time
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        
        return view('content.tests.sortquestions', compact('ldq'));
    }
    
    public function store(Request $request) {

        
        return redirect()->route('content.tests.index'); // generated
    }
    
    public function show(TestConfiguration $question) {
        //
    }
    
    public function edit(TestConfiguration $question) {
    
        
        return view('content.tests.choosequestions', compact('ldq'));
    }
    
    public function update(Request $request, TestConfiguration $question) {
        // get them from session
    
    }
    
    public function destroy(TestConfiguration $question) {
        //
    }
}
