<?php
namespace App\Services;

use App\Models\Category;

class CategoryService {
	// TODO: use subcategories
	
	public function findAll() {
		return Category::all();
	}

	public function find($id) {
		return Category::findOrFail($id);
	}

	public function findAllByName($nameArr) {
		return Category::whereIn('name', $nameArr)->get();
	}
	
	public function findByName($name) {
		return Category::where('name', $name)->first();
	}

	public function save($untypedArr) {
		$cat = new Category();
		$cat->name = $untypedArr['name'];
		$cat->tag = $untypedArr['tag'];
		$cat->save();
	
		return $cat;
	}
}