<?php
namespace App\Support\Helpers;

class Utils {
	public static function itemsArray($items) {
		$a = array();
		foreach ($items as $item) {
			$a[] = $item;
		}
		return $a;
	}
	
	public static function idArray($items) {
	    $a = array();
	    foreach ($items as $item) {
	        $a[] = $item->id;
	    }
	    return $a;
	}
	
	public static function queidArray($items) {
	    $a = array();
	    foreach ($items as $item) {
	        $a[] = $item->question_id;
	    }
	    return $a;
	}
	
	public static function medidArray($items) {
	    $a = array();
	    foreach ($items as $item) {
	        $a[] = $item->med_id;
	    }
	    return $a;
	}
	
	public static function uriToArray($uri) {
		$arr = explode('/', $uri);
		$arrnew = array();
		for ($i = 0; $i < sizeof($arr); $i++) {
			$pos = strpos($arr[$i], '{');
			if ($pos === false) {
				array_push($arrnew, $arr[$i]);
			} else {
				return $arrnew;
			}
		}
		
		return $arrnew;
	}

	public static function uriPartToArray($uri) {
		$arr = explode('/', $uri);
		$arrnew = array();
		for ($i = 0; $i < sizeof($arr); $i++) {
			$pos = strpos($arr[$i], '{');
			if ($pos === false) {
				array_push($arrnew, $arr[$i]);
			} else {
				// return only last item in array and create new array from it
				return array($arrnew[sizeof($arrnew) - 1]);
			}
		}
		
		// return only last item in array and create new array from it
		return array($arrnew[sizeof($arrnew) - 1]);
	}
	
	public static function tickedCategories($allowedcats, $cgns) {
		foreach ($allowedcats as $cat) {
			$cat->ticked = false;
			foreach ($cgns as $cgn) {
				if ($cat->category_id == $cgn->category_id) {
					$cat->ticked = true;
				}
			}
		}
		
		return $allowedcats;
	}
	
	public static function toCacheKey($arr) {
		// return only last item in array
		return $arr[sizeof($arr) - 1];
		//return Utils::concat($arr, '_');
	}
	
	public static function toBladeView($sect) {
		$blade = str_replace('/', '.', $sect);
		if (strpos($blade, '.') == false) {
			$blade .= '.index';
		}
		
		return $blade;
	}

	public static function toUri($arr) {
		return Utils::concat($arr, '/');
	}

	public static function toAction($uri) {
		$arr = Utils::uriToArray($uri);
		$i = sizeof($arr) - 1;
		if ($arr[$i] == 'create') {
			$arr[$i] = 'save';
		}
		if ($arr[$i] == 'edit') {
			$arr[$i] = 'update';
		}
		return Utils::concat($arr, '/');
	}

	private static function concat($arr, $sym) {
		$ckey = $arr[0];
		for ($i = 1; $i < sizeof($arr); $i++) {
			$ckey .= $sym.$arr[$i];
		}
		return $ckey;
	}
	
	// it works when passed an id as well
	public static function friendlyUrlToId($friendlyUrl) {
		$arr = explode('-', $friendlyUrl);
		$id = $arr[count($arr)-1];
		return $id;
	}

	public static function tagged($obj, $tag) {
		return new TaggedObject($obj, $tag);
	}
}