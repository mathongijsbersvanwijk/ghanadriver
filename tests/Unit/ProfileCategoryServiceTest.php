<?php
namespace Tests\Unit;

use App\Services\CategoryService;
use App\Services\ProfileCategoryService;
use Tests\TestCase;

class ProfileCategoryServiceTest extends TestCase {
	protected $pcs;
	
	protected function setUp(): void {
	    parent::setUp();
		$this->cs = new CategoryService();
		$this->pcs = new ProfileCategoryService();
	}
	
	public function testFind() {
		$pc = $this->pcs->find(['pro_id' => 9310, 'cat_id' => 8]);
		$this->assertNotNull($pc->par_abs);
	}
	
	public function testFindByProfile() {
		$lpc = $this->pcs->findByProfile(9310);
		foreach ($lpc as $pc) {
			//echo $pc->par_abs.PHP_EOL;
		}
		$this->assertEquals(10, sizeof($lpc));
	}
}
