<?php
/**
 * dropFW :  PHP Web Development Framework
 * Copyright 2010, Pavan Kumar Sunkara
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2010
 * @version	1.0.0
 * @author	Pavan Kumar Sunkara
 * @license	MIT
 */

	// Basic object class for all other libs
	require_once CORE.'object.php';
	
	// Basic file which defines all the paths to MVC
	require_once CORE.'paths.php';
	
/**
 * Basic class for writing and reading configurations
 * Usage: "$Configure->"
 */
	require_once CORE.'configure.php';

	$configure = new Configure();

	// File for configuration in webAPP
	require_once CONFIGS.'config.php';

	// File for database configuration in webAPP
	require_once CONFIGS.'database.php';

/**
 * Basic class for Access control lists
 * Usage: "$ACL->"
 */	
	if($configure->read('lib.acl')) {
		require_once CORE.'acl.php';
	}
	
/**
 * Basic class for using cookie variables
 * Usage: "$Cookie->"
 */
	if($configure->read('lib.cookie')) {
		require_once CORE.'cookie.php';
	}

/**
 * Basic class for using captcha
 * Usage: "$Captcha->"
 */
	if($configure->read('lib.captcha')) {
		require_once CORE.'captcha.php';
	}

/**
 * Basic class for Controllers
 * Usage: "Controller::"
 */
	require_once CORE.'controller.php';

/**
 * Basic class for parsing and dispatching URLs
 * Usage: "$Dispatcher->"
 */
	require_once CORE.'dispatcher.php';

/**
 * Basic class for using MySQL database
 * Usage: "Database::"
 */	
	require_once CORE.'database.php';

/**
 * Basic class for error handling
 * Usage: "Error::"
 */	
	require_once CORE.'error.php';

/**
 * Basic class for sending emails in PHP
 * Usage: "$Email->"
 */
	if($configure->read('lib.email')) {
		require_once CORE.'email.php';
	}
	
/**
 * Basic class for file handling
 * Usage: "$File->"
 */
	if($configure->read('lib.file')) {
		require_once CORE.'file.php';
	}

/**
 * Basic class for HTML helper
 * Usage: "$HTML->"
 */
	if($configure->read('lib.html')) {
		require_once CORE.'html.php';
	}

/**
 * Basic class for maintaining naming conventions
 * Usage: "Inflector::"
 */	
	require_once CORE.'inflector.php';

/**
 * Basic class for manipulating json
 * Usage: "$JSON->"
 */	
	if($configure->read('lib.json')) {
		require_once CORE.'json.php';
	}
	
/**
 * Basic class for Localization of languages
 * It is used in I18n, so no need to initialise here.
 */
	require_once CORE.'l10n.php';

/**
 * Basic class for Internationalization of languages
 * Usage: "$I18n->"
 */
	require_once CORE.'i18n.php';

/**
 * Basic class for logging objects
 * Usage: "$Logger->"
 */	
	if($configure->read('lib.logger')) {
		require_once CORE.'logger.php';
	}

/**
 * Basic class for Object models
 * Usage: "Model::"
 */
	require_once CORE.'model.php';

/**
 * Basic class for using payment modules
 * Usage: "$Pay->"
 */	
	if($configure->read('lib.pay')) {
		require_once CORE.'pay.php';
	}
	
/**
 * Basic class for using RSS feed
 * Usage: "$RSS->"
 */
	if($configure->read('lib.rss')) {
		require_once CORE.'rss.php';
	}

/**
 * Basic class for routing actions and pages
 * Usage: "Router::"
 */
	require_once CORE.'router.php';

/**
 * Basic class for sanitizing strings and conversion
 * Usage: "Sanitize::"
 */	
	require_once CORE.'sanitize.php';

/**
 * Basic class for security hashing and others
 * Usage: "Security::"
 */
	require_once CORE.'security.php';
	
/**
 * Basic class for using session variables
 * Usage: "$Session->"
 */
	if($configure->read('lib.session')) {
		require_once CORE.'session.php';
	}

/**
 * Basic class for manipulating arrays
 * Usage: "Set::"
 */
	require_once CORE.'set.php';
	
/**
 * Basic class for manipulating strings
 * Usage: "String::"
 */
	require_once CORE.'string.php';
	
/**
 * Basic class for using timers
 * Usage: "Timer::"
 */
	require_once CORE.'timer.php';

/**
 * Basic class for various validation techniques
 * Usage: "Validation::"
 */
	require_once CORE.'validation.php';

/**
 * Basic class for View
 * Usage: "View::"
 */
	require_once CORE.'view.php';

/**
 * Basic class for using XML
 * Usage: "$XML->"
 */
	if($configure->read('lib.xml')) {
		require_once CORE.'xml.php';
	}

/**
 * Routing file
 */
	
	//File for routing in webAPP
	require_once CONFIGS.'routes.php';

?>
