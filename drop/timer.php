<?php
/**
 * dropFW(tm) :  PHP Web Development Framework (http://www.suncoding.com)
 * Copyright 2010, Sun Web Dev, Inc.
 *
 * Licensed under The GPLv3 License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2010, Sun Web Dev, Inc. (http://www.suncoding.com)
 * @version	1.0.0
 * @author	Pavan Kumar Sunkara
 * @license	GPLv3
 */

	define('SECOND', 1);
	define('MINUTE', 60 * SECOND);
	define('HOUR', 60 * MINUTE);
	define('DAY', 24 * HOUR);
	define('WEEK', 7 * DAY);
	define('MONTH', 30 * DAY);
	define('YEAR', 365 * DAY);
	
class Timer extends Object {

/**
 * Private time Array
 */
	public static $privateTime = Array ();
/**
 * Time array
 */
	public static $timeArray = Array ();

/**
 * Constructor.
 */
	function __construct() {}
	
/**
 * Get time
 */
	function getTime() {
		$time = microtime();
		$time = explode (' ', $time);
		$time = $time [1] + $time [0];
		return $time;
	}
	
/**
 * Extend record
 */
	function extendRecord ($label) {
		$value = &self::$timeArray [$label];
		if ($value ["stop"] > 0) {
			$value ["range"] = self::$privateTime [$label]["allranges"];
			$value ["status"] = "stopped";
		} else {
			$value ["range"] = (self::getTime() - $value ["start"]) + self::$privateTime [$label]["allranges"];
			$value ["status"] = "running";
		}
		$value ["average"] = $value["range"]/$value["starts"];
		$value ["average_human"] = sprintf ("%01.2f", $value ["average"]); 
		$value ["range_human"] = sprintf ("%01.2f", $value ["range"]); 
	}
	
/**
 * Time start
 */
	function start ($label) {
		self::$timeArray[$label]["start"] = self::getTime();
		self::$timeArray[$label]["stop"] = 0;
		if (! isset (self::$timeArray[$label]["starts"]))
			self::$timeArray[$label]["starts"] = 1;
		else
			self::$timeArray[$label]["starts"]++;
		if (! isset (self::$privateTime [$label]["allranges"]))
			self::$privateTime [$label]["allranges"] = 0;
	}
	

/**
 * Timer stop
 */
	function stop ($label) {
		if (isset (self::$timeArray[$label]["stop"])) {
			self::$timeArray[$label]["stop"] = self::getTime();
			self::$privateTime [$label]["allranges"] += self::$timeArray[$label]["stop"]-self::$timeArray[$label]["start"];
		}
	}
	

/**
 * Timer restart
 */      
	function restart ($label) {
		if (isset (self::$timeArray[$label]["stop"]))
			unset (self::$privateTime [$label]["allranges"]);
		self::start ($label);
	}

/**
 * Timer stop all lables
 */
	function stopAll () {
		foreach (self::$timeArray as $label => $value)
			self::stop ($label);
	}
	
/**
 * Delete label
 */
	function del ($label) {
		if (isset (self::$timeArray[$label])) {
			unset (self::$timeArray[$label]);
		}
	}
	
/**
 * Delete all timer labels
 */
	function delAll () {
		self::$timeArray = Array ();
	}
	
/**
 * Get timer lablels
 */
	function get ($label) {
		if (isset (self::$timeArray[$label])) {
			self::extendRecord ($label);
			return self::$timeArray[$label];
		} else {
			return false;
		}
	}
	
/**
 * Get all timers
 */
	function getAll () {
		foreach (self::$timeArray as $label => $value)
			self::extendRecord ($label);
		return self::$timeArray;
	}

}

?>
