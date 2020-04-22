<?php
namespace App\Exceptions;

use Exception;

class NoRolesPermissionException extends Exception {

	protected $ra;

	/**
	 * Constructor
	 *
	 * @param string $ra        	
	 * @param int $code        	
	 * @param \Exception $previous        	
	 */
	public function __construct($ra, $code = 0, Exception $previous = null) {
		$this->ra = $ra;
		parent::__construct('No permission for roles: '.$this->getRoleIds(), $code, $previous);
	}

	/**
	 * Get the concatenated ids of the roles not found.
	 *
	 * @return string
	 */
	public function getRoleIds() {
		return implode(" ", $this->ra);
	}
}
