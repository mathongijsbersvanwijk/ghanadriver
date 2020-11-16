<?php
namespace Tests\Unit;

use App\Business\DisplayQuestionAlternative;
use App\Models\User;
use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use App\Support\Helpers\ShellCommand;
use Illuminate\Support\Collection;
use Tests\TestCase;

class QuestionServiceUgcTest extends TestCase {
	protected $qs;
	
	protected function setUp(): void {
		parent::setUp();
		$this->qs = new QuestionService();
	}
	
	protected function tearDown(): void {
	    $sc = new ShellCommand();
	    $sc->restoreDatabase();
	    parent::tearDown();
	}
	
	public function testSaveQuestion() {
	    $qt = QuestionToolkit::createText(0, 'T', 'Can you park here?');
	    $qi = QuestionToolkit::createImage(0, 'B', 'testparking.jpg');

	    $ldqalt = new Collection();
	    $dqalt = new DisplayQuestionAlternative(1, 1);
	    $dqalt->setQuestionText(QuestionToolkit::createText(0, 'T', 'Yes'));
	    $ldqalt->push($dqalt);
	    $dqalt = new DisplayQuestionAlternative(2, 0);
    	$dqalt->setQuestionText(QuestionToolkit::createText(0, 'T', 'No'));
    	$ldqalt->push($dqalt);
    	
    	$que = $this->qs->saveQuestion($qt, $qi, $ldqalt, new User(['id' => 1])) ;
	    $this->assertEquals(11011, $que->que_id);
	    
	    $dq = QuestionToolkit::getDisplayQuestionById($que->que_id, $this->qs);
	    $dqask = $dq->getDisplayQuestionAsked();
	    $this->assertEquals('Can you park here?', $dqask->getQuestionText()->getTekContents());
	    $this->assertEquals('11011_testparking.jpg', $dqask->getQuestionImage()->getGrfFileName());
	    
	    $dqalt = $dq->getDisplayQuestionAlternative(1);
	    $this->assertEquals('Yes', $dqalt->getQuestionText()->getTekContents());
	    $this->assertTrue($dqalt->isCorrect());
	    $dqalt = $dq->getDisplayQuestionAlternative(2);
	    $this->assertEquals('No', $dqalt->getQuestionText()->getTekContents());
	    $this->assertFalse($dqalt->isCorrect());
	}
}
