<?php
namespace App\Services;

use App\Models\TestConfiguration;

class TestConfigurationService {

	public function findAll() {
		return TestConfiguration::all();
	}
	
	public function find($idArr) {
		return TestConfiguration::find($idArr);
	}
	
/* 	public function findByPrimaryKey($companyId, $tst_id) {
		return TestConfiguration::where('companyId', $companyId)->where('tst_id', $tst_id)->first();
	}
 */
}