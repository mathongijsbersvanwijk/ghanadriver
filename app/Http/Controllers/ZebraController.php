<?php
namespace App\Http\Controllers;

use App\Business\UserTest;
use App\Business\UserTestQuestion;
use App\Exceptions\RedoFaultsNotPossibleException;
use App\Services\ArticleService;
use App\Services\ProfileCategoryService;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Services\TestQuestionService;
use App\Services\UserTestResultService;
use App\Support\Helpers\WebConstants;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class ZebraController extends Controller
{
    public function starttest(Request $request, TestConfigurationService $tcfs, ProfileCategoryService $pcs,
        QuestionService $qs, TestQuestionService $tqs) {
        $tstId = $request->input('tstId');
        $op = $request->input('op');
        $mode = $request->input('mode');

        $userId = $request->session()->getId();
        $ut = new UserTest($userId);

        $ut->createTest($tstId, $op, $mode, $tcfs, $pcs, $qs, $tqs);
        $request->session()->put('ut', $ut);
        // Session::

        // jsp redirects to first question
        return $this->render($request, 0, WebConstants::NEXT_QUESTION);
    }

    public function answerQuestionAndProceed(Request $request, UserTestResultService $utrs) {
        $tquId = $request->input('tquId');
        $altId = $request->input('altId');
        $op = $request->input('op');

        $ut = $request->session()->get('ut');

        if ($ut != null) {
            // answer current
            if ($altId > 0) {
                $utq = $ut->answerQuestion($tquId, $altId);
            }
            // redirect
            if ($op == WebConstants::STOP_TEST) {
                $ut->stopTest($utrs);
                return $this->render($request, null, null, WebConstants::RESULT_PAGE);
            } else {
                if ($op == WebConstants::NEXT_QUESTION) {
                    if (($ut->whereInTest() & WebConstants::END_OF_TEST) == WebConstants::END_OF_TEST) {
                        $ut->stopTest($utrs);
                        return $this->render($request, null, null, WebConstants::RESULT_PAGE);
                    }
                }
            }
        }

        return $this->render($request, $tquId, $op);
    }

    public function redoFaults(Request $request) {
        $ut = $request->session()->get('ut');

        if ($ut != null) {
            try {
                $ut->setMode(WebConstants::SELF_PACED_MODE);
                $ut->setFaultsOnly(true);
                $ut->getNextQuestion(0);
                return $this->render($request, 0, WebConstants::NEXT_QUESTION);
            } catch (RedoFaultsNotPossibleException $e) {
                // SessionMessages.add(req, PortalUtil.getPortletId(req) + SessionMessages.KEY_SUFFIX_HIDE_DEFAULT_ERROR_MESSAGE);
                // resp.setRenderParameter("mvcPath", getView() + "/result.jsp");
                throw ($e);
            }
        } else {
            return $this->render($request, 0, WebConstants::NEXT_QUESTION);
        }
    }

    public function render(Request $request, $id, $op, $page = WebConstants::QUESTION_PAGE) {
        if ($op == WebConstants::EXACT_QUESTION) {
            $utq = new UserTestQuestion($id);
            return view('z.questionexact', compact('utq'));
        }
        
        $ut = $request->session()->get('ut');
        if ($ut != null) {
            if ($op == null) {
                $utq = $ut->getCurrentQuestion();
            } else if ($op == WebConstants::CURRENT_QUESTION) {
                $utq = $ut->getCurrentQuestion();
            } else if ($op == WebConstants::PREVIOUS_QUESTION) {
                $utq = $ut->getPreviousQuestion($id);
            } else if ($op == WebConstants::NEXT_QUESTION) {
                $utq = $ut->getNextQuestion($id);
            } else if ($op == WebConstants::THIS_QUESTION) {
                $utq = $ut->getThisQuestion($id);
            } else if ($op == WebConstants::REDO_TEST_SELF_PACED) {
                $ut->setMode(WebConstants::SELF_PACED_MODE);
                $ut->setFaultsOnly(false);
                $utq = $ut->getNextQuestion($id);
            } else if ($op == WebConstants::REDO_TEST_TIMED_QUESTION) {
                $ut->setMode(WebConstants::TIMED_QUESTION_MODE);
                $ut->setFaultsOnly(false);
                $utq = $ut->getNextQuestion($id);
            } else {
                return view('z.index');
            }
        } else {
            return view('z.index');
        }

        if ($page == WebConstants::QUESTION_PAGE) {
            return view('z.question', compact('ut', 'utq'));
        } else {
            return view('z.result', compact('ut', 'utq'));
        }
    }

    public function book($title, ArticleService $as) {
        // $arts = $as->findBySingleCategoryTitle($title);
        // $art = $arts->get(0);
        $art = App::make('articles')->getByTitle($title)->first();
        return view('z.book', compact('art'));
    }

    public function booknav($title, ArticleService $as) {
        // $art = $as->findByTitle($title);
        $art = App::make('articles')->getByTitle($title)->first();
        return view('z.book', compact('art'));
    }
}
