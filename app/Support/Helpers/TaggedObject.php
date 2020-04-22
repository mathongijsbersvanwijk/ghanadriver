<?php
namespace App\Support\Helpers;

class TaggedObject {

	public $obj;
	public $tag;
	
	public function __construct($o, $t) {
		$this->obj = $o;
		$this->tag = $t;
	}
}