<?php
namespace App\Exceptions;

use Exception;

class NoCacheFoundException extends Exception {

	protected $ckey;

	/**
	 * Constructor
	 *
	 * @param string $ckey        	
	 * @param int $code        	
	 * @param \Exception $previous        	
	 */
	public function __construct($ckey, $code = 0, Exception $previous = null) {
		$this->ckey = $ckey;
		parent::__construct('No cache found for key: '.$this->getCacheKey(), $code, $previous);
	}

	/**
	 * Get the ckey which was not found.
	 *
	 * @return string
	 */
	public function getCacheKey() {
		return $this->ckey;
	}
}
