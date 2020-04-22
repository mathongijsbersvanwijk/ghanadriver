<?php
namespace App\Exceptions;

use Exception;

class RedoFaultsNotPossibleException extends Exception {

	/**
	 * Constructor
	 *
	 * @param \Exception $previous
	 */
	public function __construct(Exception $previous = null) {
		parent::__construct('Redo faults not possible', $previous);
	}
}
