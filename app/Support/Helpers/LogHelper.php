<?php
namespace App\Support\Helpers;

use Illuminate\Support\Facades\Log;

// TODO: Override Illuminate\Foundation\Bootstrap\ConfigureLogging and add multiple loggers there.
class LogHelper {
	public static function appError($message) {
		//Log::useDailyFiles(storage_path().'/logs/app.log', 1, 'error');
		Log::error($message);
	}
	
	public static function dbError($message) {
		//Log::useDailyFiles(storage_path().'/logs/db.log', 1, 'error');
		Log::error($message);
	}
	
	public static function memCacheInfo($message) {
		//Log::useDailyFiles(storage_path().'/logs/memcache.log', 'info');
		Log::error($message);
	}
	
	private static function something() {

	}
}