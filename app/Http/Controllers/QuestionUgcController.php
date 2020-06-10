<?php
namespace App\Http\Controllers;

use App\Business\DisplayQuestionAlternative;
use App\Models\Question;
use App\Models\User;
use App\Services\ImageService;
use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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

    public function store(Request $request, QuestionService $qs, ImageService $is) {
        $this->validate($request, [
            'fm'    => 'required',
            'photo' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $fm = $request->input('fm');
        $fmd = json_decode($fm, true);

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
         
        $que = $qs->saveQuestion($qt, $qi, $ldqalt, new User(['id' => 1]));
        $request->session()->put('que', $que);
        
        $is->save($photo);
        // return is void, because redirect is done on complete event in create.blade.php
    }

    public function check(Request $request) {
        $que = $request->session()->get('que');
        
        return redirect('/z/render/'.$que->que_id.'/5');
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
