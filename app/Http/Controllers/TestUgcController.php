<?php

namespace App\Http\Controllers;

use App\Models\TestConfiguration;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TestUgcController extends Controller
{
    public function index(TestConfigurationService $tcfs) {
        $ltst = $tcfs->findAllByUser(Auth::user());
        
        return view('content.tests.index', compact('ltst'));
    }
    
    public function create(Request $request, QuestionService $qs) {
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        $request->session()->put('ldq', $ldq);
        
        return view('content.tests.create', compact('ldq'));
    }
    
    public function chosenquestions(Request $request, $tstid, QuestionService $qs) {
        // $tstid is null the first time
        $queIdArr = $request->get('queids');
        $ldq = $request->session()->get('ldq');
        $ldqchosen = new Collection();
        foreach ($ldq as $dq) {
            if (in_array($dq->getQueId(), $queIdArr)) {
                $ldqchosen->push($dq);            
            }
        }
        $request->session()->put('ldqchosen', $ldqchosen);
        
        return redirect()->route('tests.sortquestions', ['tstid' => $tstid]);
    }
    
    public function sortquestions(Request $request, $tstid) {
        $ldqchosen = $request->session()->get('ldqchosen');
        
        return view('content.tests.sortquestions', compact('ldqchosen'));
    }
    
    public function store(Request $request, TestConfigurationService $tcfs) {
        $tcfs->save($request->all(), Auth::user());
        
        return redirect()->route('content.tests.index'); // generated
    }
    
    public function show(TestConfiguration $question) {
        //
    }
    
    public function edit(TestConfiguration $question) {
    
        
        return view('content.tests.create', compact('ldq'));
    }
    
    public function update(Request $request, TestConfiguration $question) {
        // get them from session
    
    }
    
    public function destroy(TestConfiguration $question) {
        //
    }
}
