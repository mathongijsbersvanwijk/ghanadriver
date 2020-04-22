<?php
namespace App\Support\Helpers;

class WebConstants {
	public const PREDEFINED_TEST = 1;
	public const PROFILED_TEST = 2;
	
	public const SELF_PACED_MODE = 1;
	public const TIMED_QUESTION_MODE = 2;
	public const TIMED_TEST_MODE = 3;
	
	public const PREVIOUS_QUESTION = 1;
	public const NEXT_QUESTION = 2;
	public const CURRENT_QUESTION = 3;
	public const THIS_QUESTION = 4;
	public const EXACT_QUESTION = 5;
	public const REDO_TEST_FAULTS = 6;
	public const REDO_TEST_SELF_PACED = 7;
	public const REDO_TEST_TIMED_QUESTION = 8;
	public const STOP_TEST = 9;
	
	public const BEGIN_OF_TEST = 1;
	public const END_OF_TEST = 2;
	
	public const QUESTION_PAGE = 1;
	public const RESULT_PAGE = 2;
	
	public const ANSWER_RESOURCE_TYPE_TEXT = 1;
	public const ANSWER_RESOURCE_TYPE_IMAGE = 2;
}