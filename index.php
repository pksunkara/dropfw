<?php
/**
 * sunFW(tm) :  PHP Web Development Framework (http://www.suncoding.com)
 * Copyright 2010, Sun Web Dev, Inc.
 *
 * Licensed under The GPLv3 License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright      Copyright 2010, Sun Web Dev, Inc. (http://www.suncoding.com)
 * @version         1.0.0
 * @modifiedby    Pavan Kumar Sunkara
 * @lastmodified  Apr 10, 2010
 * @license         GPLv3
 */

	define('DS', DIRECTORY_SEPARATOR);
	define('HOST', 'http://'.$_SERVER['HTTP_HOST'].DS);
	define('ROOT', dirname(__FILE__).DS);
	define('CORE', ROOT.'sun'.DS);
	define('APP', ROOT.'app'.DS);
	define('WWW', APP.'www'.DS);
	
/**
 * Detects the correct URL excluding the base directory
 * Works without the consideration of  rewrite engine
 * @author	Pavan Kumar Sunkara
 */	
	if(array_key_exists('REDIRECT_STATUS',$_SERVER)) {
		if((int) $_SERVER['REDIRECT_STATUS'] == 200) {
			define('URL', $_SERVER['REDIRECT_QUERY_STRING']);
			$subdirUrl = explode("/",$_SERVER['SCRIPT_NAME']);
			array_pop($subdirUrl);
			$subdirUrl = implode("/",$subdirUrl);
			define('BASE', HOST.$subdirUrl.DS);
			$redirection = true;
		}
	} else {
		define('URL', $_SERVER['PATH_INFO']);
		define('BASE', HOST.$_SERVER['SCRIPT_NAME'].DS);
		$redirection = false;
	}

/**
 * Include boot.php which loads all the files
 */
	require_once CORE.'boot.php';

/**
 * Include index.php which does the main dispatching and outputing
 */	
	require_once WWW.'index.php';

?>
