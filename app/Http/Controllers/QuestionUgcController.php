<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        //dd($request);        
        
        $photo = $request->file('photo');
        Log::info($photo->getClientOriginalname());
        
        $asked = $request->input('asked');
        Log::info($asked);
        $alternativea = $request->input('alternative');
        for ($i = 0; $i < sizeof($alternativea); $i++) {
            Log::info($alternativea[i]);
        }
            
        
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
