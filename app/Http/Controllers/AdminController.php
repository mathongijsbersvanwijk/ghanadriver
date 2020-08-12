<?php

namespace App\Http\Controllers;

use App\Business\UserTestQuestion;
use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(QuestionService $qs, $status = null) {
        $ldq = QuestionToolkit::getDisplayQuestionsByStatus($status, $qs);
        
        return view('content.admin.questionsindex', compact('ldq', 'status'));
    }
    
    public function show(Request $request, $id, QuestionService $qs) {
        $que = $qs->find($id);
        $utq = new UserTestQuestion($que->que_id);

        return view('z.questionexact', compact('utq', 'que'));
    }
    
    public function updatestatus(Request $request, QuestionService $qs) {
        $qs->update($request->all());
        
        return redirect()->route('admin.questions.index');
    }
}
