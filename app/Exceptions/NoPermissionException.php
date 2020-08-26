<?php
namespace App\Exceptions;

use Exception;

class NoPermissionException extends Exception {

	/**
	 * Constructor
	 *
	 * @param \Exception $previous
	 */
	public function __construct(Exception $previous = null) {
		parent::__construct('Permission denied', $previous);
	}
}
