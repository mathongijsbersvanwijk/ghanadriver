<?php
namespace Tests\Unit;

use App\Services\TestQuestionService;
use Tests\TestCase;

class TestQuestionServiceTest extends TestCase {
	protected $tqs;
	
	public function setUp() {
		parent::setUp();
		$this->tqs = new TestQuestionService();
	}
	
	public function  testFindByTest() {
		$tqus = $this->tqs->findByTest(102);
		$this->assertEquals(10, sizeof($tqus));
	}
}
