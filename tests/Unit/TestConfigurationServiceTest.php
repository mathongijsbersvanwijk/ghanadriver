<?php
namespace Tests\Unit;

use App\Services\TestConfigurationService;
use Tests\TestCase;

class TestConfigurationServiceTest extends TestCase {
	protected $tcfs;
	
 	public function setUp() {
		parent::setUp();
		$this->tcfs = new TestConfigurationService;	
 	}
	
	public function  testFind() {
		$tcf = $this->tcfs->find(['companyId' => 10131, 'tst_id' => 103]);
		$this->assertNotNull($tcf);
		echo $tcf->tst_description.PHP_EOL;
	}
}
