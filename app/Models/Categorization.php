<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorization extends Model {
	use Categorizable;

	public $timestamps = false;

	public function categorizable() {
		return $this->morphTo();
	}

	public function category() {
		return $this->belongsTo('App\Models\Category');
	}
}
