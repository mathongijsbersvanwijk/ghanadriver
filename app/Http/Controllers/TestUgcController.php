<?php

namespace App\Http\Controllers;

use App\Models\TestConfiguration;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestUgcController extends Controller
{
    public function index(TestConfigurationService $tcfs) {
        $ltst = $tcfs->findAllByUser(Auth::user());
        
        return view('content.tests.index', compact('ltst'));
    }
    
    public function create(Request $request, QuestionService $qs) {
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        $request->session()->put('ldq', $ldq);
        
        return view('content.tests.edit', compact('ldq'));
    }
    
    public function chosenquestions(Request $request, QuestionService $qs) {
        $id = $request->input('id');
        $idArr = $request->get('dqids');
        $ldq = $request->session()->get('ldq');
        $ldqchosen = new Collection();
        foreach ($ldq as $dq) {
            if (in_array($dq->getId(), $idArr)) {
                $ldqchosen->push($dq);            
            }
        }
        $request->session()->put('ldqchosen', $ldqchosen);
        
        return redirect()->route('tests.sortquestions', ['id' => $id]);
    }
    
    public function sortquestions(Request $request, $id) {
        $ldqchosen = $request->session()->get('ldqchosen');
        
        return view('content.tests.sortquestions', compact('ldqchosen', 'id'));
    }
    
    public function store(Request $request, TestConfigurationService $tcfs) {
        $tcfs->save($request->all(), Auth::user());
        
        return redirect()->route('tests.index'); 
    }
    
    public function show(TestConfiguration $test) {
        //
    }
    
    public function edit(Request $request, TestConfiguration $test, QuestionService $qs) {
        // implicit retrieval of test is done by Laravel
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        $request->session()->put('ldq', $ldq);
        
        // todo: merge existing questions into full list
        
        return view('content.tests.edit', compact('ldq', 'test'));
    }
    
    public function update(Request $request, TestConfiguration $test, TestConfigurationService $tcfs) {
        error_log('Some update  ..................  '.$test->id);
        $tcfs->update($request->all(), Auth::user());
        
        return redirect()->route('tests.index');
    }
    
    public function destroy(TestConfiguration $testConfiguration) {
        //
    }
}
