<?php
namespace App\Exceptions;

use Exception;

class NoCategoryPermissionException extends Exception {

	protected $name;

	/**
	 * Constructor
	 *
	 * @param string $name        	
	 * @param int $code        	
	 * @param \Exception $previous        	
	 */
	public function __construct($name, $code = 0, Exception $previous = null) {
		$this->name = $name;
		parent::__construct('No permission for category: '.$this->getName(), $code, $previous);
	}

	/**
	 * Get the name which was not found.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
}
