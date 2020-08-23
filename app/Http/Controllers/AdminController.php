<?php

namespace App\Http\Controllers;

use App\Business\UserTestQuestion;
use App\Mail\QuestionRejected;
use App\Models\Question;
use App\Models\User;
use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $que = $qs->update($request->all());

        if ($request->input('status') == "REJECTED") {
            $dq = QuestionToolkit::getDisplayQuestionById($que->que_id, $qs);
            $asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents();
            $pathToPhoto = public_path('storage/img/'.$dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName());
            
            $this->notifyUser($que, $que->reason, $asked, $pathToPhoto);
        }
        
        return redirect()->route('admin.questions.index');
    }

    private function notifyUser(Question $que, $reason, $asked, $pathToPhoto) {
        $question = Question::findOrFail($que->id);
        Mail::to($question->owner)->send(new QuestionRejected($question, $reason, $asked, $pathToPhoto));
    }
}
