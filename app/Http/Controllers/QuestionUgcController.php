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
        $fm = $request->input('fm');
        $fmdec = json_decode($fm, true);
        Log::info($fmdec);
        
        $photo = $request->file('photo');
        Log::info($photo->getClientOriginalname());
       
        for ($i = 0; $i < sizeof($fmdec); $i++) {
            $elem = $fmdec[$i];
            Log::info($elem['name']);
            Log::info($elem['value']);
        } 
            
        
        return redirect()->route('ridehailing');
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
