<?php
namespace Tests\Unit;

use App\Business\ProfiledTest;
use App\Services\ProfileCategoryService;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use Tests\TestCase;

class ProfiledTstTest extends TestCase {
	protected $tcfs;
	protected $pcs;
	protected $qs;
	
	protected function setUp(): void {
	    parent::setUp();
		$this->tcfs = new TestConfigurationService();
		$this->pcs = new ProfileCategoryService();
		$this->qs = new QuestionService();
	}
	
	public function  testGenerate() {
		$pt = new ProfiledTest(103, $this->tcfs, $this->pcs, $this->qs);
		$this->assertNotNull($pt);
		$this->assertEquals(10, sizeof($pt->getQueIds()));
	}
}
