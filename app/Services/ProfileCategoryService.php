<?php
namespace App\Services;

use App\Models\ProfileCategory;
use Illuminate\Support\Facades\DB;

class ProfileCategoryService {
	public function findAll() {
		return ProfileCategory::all();
	}
	
	public function find($idArr) {
		return ProfileCategory::find($idArr);
	}
	
	public function findByProfile($pro_id) {
		return ProfileCategory::where('pro_id', $pro_id)->get();
	}
	
	public function findByProfileDB($pro_id) {
		$lpc = DB::table('quagga_partition')->select('pro_id', 'cat_id', 'par_abs');
		$lpc = $lpc->where('quagga_partition.pro_id', '=', $pro_id)->get();

		return $lpc;
	}
}