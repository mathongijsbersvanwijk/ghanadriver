<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionUgcController extends Controller
{
    public function index() {
        $questions = [];

        return view('content.questions.index', compact('questions'));
    }

    public function create() {
        return view('content.questions.create');
    }

    public function store(Request $request) {
        return redirect()->route('content.questions.index');
    }

    public function show(Question $question) {
        //
    }

    public function edit(Question $question) {
        //
    }

    public function update(Request $request, Question $question) {
        //
    }

    public function destroy(Question $question) {
        //
    }
}
