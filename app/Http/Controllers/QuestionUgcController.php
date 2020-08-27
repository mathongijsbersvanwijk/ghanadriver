<?php
namespace App\Http\Controllers;

use App\Business\DisplayQuestion;
use App\Business\DisplayQuestionAlternative;
use App\Mail\QuestionUploaded;
use App\Models\Question;
use App\Models\User;
use App\Services\ImageService;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class QuestionUgcController extends Controller
{
    public function index(QuestionService $qs) {
        $ldq = QuestionToolkit::getDisplayQuestionsByUser(Auth::user()->id, $qs);
        
        return view('content.questions.index', compact('ldq'));
    }

    public function create() {
        return view('content.questions.create');
    }

    public function store(Request $request, QuestionService $qs, ImageService $is) {
        $this->validate($request, [
            'fm'    => 'required',
            'photo' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $fm = $request->input('fm');
        $fmd = json_decode($fm, true);

        if (sizeof($fmd) > 6) {
            throw new Exception("more than 4 alternatives to answer a question are not allowed");
        }
        
        $photo = $request->file('photo');
        $qi = QuestionToolkit::createImage(0, 'B', $photo->getClientOriginalname());
        $qt = QuestionToolkit::createText(0, 'T', $fmd[0]['value']); // $fmd[0]['name'] == 'asked'
        
        $ldqalt = new Collection();
        $i = 1;
        while ($i < sizeof($fmd)) {
            $dqalt = null;
            if ($fmd[$i]['name'] == 'iscorrect') {
                $dqalt = new DisplayQuestionAlternative($i, 1);
                $i++;
            } else {
                $dqalt = new DisplayQuestionAlternative($i, 0);
            }
        
            $dqalt->setQuestionText(QuestionToolkit::createText(0, 'T', $fmd[$i]['value']));
            $ldqalt->push($dqalt);
            $i++;
        }
         
        $que = $qs->saveQuestion($qt, $qi, $ldqalt, Auth::user());
        $request->session()->put('que', $que);
        
        $is->save($photo, $que->que_id);
        
        $this->notifyAdmin($que, "created", $qt->getTekContents(), public_path('storage/img/'.$que->que_id."_".$photo->getClientOriginalname()));
        
        // return is void, because redirect is done on complete event in create.blade.php
        // return response()->json(['success'=>$imageName]);
    }

    public function check(Request $request) {
        $que = $request->session()->get('que');
        
        if ($que == null) {
            return view('errors.app')->withErrors("something went wrong");
        }
        
        return redirect('/z/render/'.$que->que_id.'/5');
    }
     
    // NOT USED
    public function fetch(Request $request, ImageService $is) {
        $photoFileName = $request->input('photoFileName');
        Log::info($photoFileName);
        
        echo $is->get($photoFileName);
        return;
    }
    
    public function show(Question $question) {
        // implicit retrieval of question is done by Laravel
        return redirect('/z/render/'.$question->que_id.'/5');
    }

    public function edit(Question $question) {
        // implicit retrieval of question is done by Laravel
    }
    
    public function editphoto($queid, QuestionService $qs) {
        $dq = new DisplayQuestion($queid);
        $dq = QuestionToolkit::getDisplayQuestion($dq, $qs);
        
        return view('content.questions.editphoto', compact('dq'));
    }
    
    public function edittext($queid, QuestionService $qs) {
        $dq = new DisplayQuestion($queid);
        $dq = QuestionToolkit::getDisplayQuestion($dq, $qs);
        
        return view('content.questions.edittext', compact('dq'));
    }
    
    public function update(Request $request, Question $question) {
        // implicit retrieval of question is done by Laravel
    }

    public function updatephoto(Request $request, QuestionService $qs, ImageService $is, TestConfigurationService $tcfs) {
        Log::info($request->input('fm'));
        
        $this->validate($request, [
            'fm'    => 'required',
            'photo' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $fm = $request->input('fm');
        $fmd = json_decode($fm, true);
        
        $photo = $request->file('photo');
        Log::info($photo->getClientOriginalname());

        $queId = $fmd[0]['value'];
        $qi = QuestionToolkit::createImage($fmd[1]['value'], 'B', $photo->getClientOriginalname()); // $fmd[1]['name'] == 'askedmedid'
        
        $que = $qs->updatePhoto($queId, $qi, Auth::user());
        $tcfs->correctTotalInTestsWithQuestion($que->id, false);
        $request->session()->put('que', $que);
        
        $is->save($photo, $que->que_id);
        
        $this->notifyAdmin($que, "updated photo", null, public_path('storage/img/'.$queId."_".$photo->getClientOriginalname()));
        
        // return is void, because redirect is done on complete event in editphoto.blade.php
    }
    
    public function updatetext(Request $request, QuestionService $qs, TestConfigurationService $tcfs) {
        $this->validate($request, [
            'queid'             => 'required',
            'asked'             => 'required',
            'askedmedid'        => 'required',
            'alternative'       => 'required',
            'alternativemedid'  => 'required',
            'iscorrect'         => 'required',
        ]);
        
        if (sizeof($request->input('alternative')) > 4) {
            throw new Exception("more than 4 alternatives to answer a question are not allowed");
        }
        
        $queId = $request->input('queid');
        $qt = QuestionToolkit::createText($request->input('askedmedid'), 'T', $request->input('asked')); 
        
        $altArr = $request->input('alternative');
        $ldqalt = new Collection();
        $i = 0;
        while ($i < sizeof($altArr)) {
            $dqalt = null;
            if ($request->input('iscorrect') == $i) {
                $dqalt = new DisplayQuestionAlternative($i + 1, 1);
            } else {
                $dqalt = new DisplayQuestionAlternative($i + 1, 0);
            }
            
            $dqalt->setQuestionText(QuestionToolkit::createText($request->input('alternativemedid')[$i], 'T', $request->input('alternative')[$i]));
            $ldqalt->push($dqalt);
            $i++;
        }
        
        $que = $qs->updateText($queId, $qt, $ldqalt, Auth::user());
        $tcfs->correctTotalInTestsWithQuestion($que->id, false);
        
        $this->notifyAdmin($que, "updated text", $qt->getTekContents(), null);
        
        return redirect('/z/render/'.$queId.'/5');
    }
        
    public function destroy(Question $question) {
        //
    }

    private function notifyAdmin(Question $question, $action, $asked, $pathToPhoto) {
        $admin = User::findOrFail(1);
        Mail::to($admin)->send(new QuestionUploaded($question, $action, $asked, $pathToPhoto));
    }
}
