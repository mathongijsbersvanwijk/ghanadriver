<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(QuestionService $qs, $status = null) {
        $ldq = QuestionToolkit::getDisplayQuestionsByStatus($status, $qs);
        
        return view('content.admin.questionsindex', compact('ldq', 'status'));
    }
    
    public function create(Request $request, QuestionService $qs) {
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        $dqidarr = [];
        $request->session()->put('ldq', $ldq);
        
        return view('content.admin.edit', compact('ldq', 'dqidarr'));
    }
    
    public function store(Request $request, QuestionService $qs) {
        $qs->save($request->all(), Auth::user());
        
        return redirect()->route('admin.index'); 
    }
    
    public function show(Question $question) {
        //
    }
    
    public function update(Request $request, QuestionService $qs) {
        $qs->update($request->all(), Auth::user());
        
        return redirect()->route('admin.index');
    }
    
}
