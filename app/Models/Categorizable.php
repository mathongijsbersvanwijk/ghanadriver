<?php
namespace App\Models;

trait Categorizable {

	public function categorizations() {
		return $this->morphMany('App\Models\Categorization', 'categorizable');
	}
}
