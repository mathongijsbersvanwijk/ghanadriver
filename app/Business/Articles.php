<?php
namespace App\Business;

use App\Services\ArticleService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Articles {
	private $arts;
	
	public function __construct() {
		$this->arts = Cache::get('arts');
		if ($this->arts == null) {
			$as = new ArticleService();
			$this->arts = $as->findAll();
			Cache::put('arts', $this->arts, 60);
		}
	}
	
	public function getAll() {
		return $this->arts;
	}

	public function getByTitle($title) {
		return $this->arts->where('title', $title);
	}
}	





