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

class Database extends Object {

/**
 * Database connection and link
 */
	public static $link = null;
/**
 * Database result
 */
	public static $result = null;

/**
 * Constructor.
 */
	function __construct() {}

/**
 * Database connector
 */
	public static function connect() {
		if(DB_CONNECT) {
			$server = DB_HOST.((DB_PORT) ? ':'.DB_PORT : '');
			self::$link = @mysql_connect($server, DB_USER, DB_PASS);

			if (!is_resource(self::$link))
				Error::databaseConnection($server, DB_USER, DB_PASS);

			self::setdb(DB_NAME);
			self::charset(DB_CHARSET);
		}
	}

/**
 * Set the database name if possible
 * @params	string	$name	Name of Database
 * @return	void
 */
	public static function setdb($name) {
		if (!@mysql_select_db($name, self::$link)) {
			@mysql_close(self::$link);
			Error::databaseDb($name);
		}
	}

/*
 * Show the tables in the database
 * @return array
 */
	public static function showTables() {
		self::exec('SHOW TABLES');
		return self::row();
	}

/**
 * Describe a table
 * @param string $table Table name to describe
 * @return array
 */
	public static function describeTable($table) {
		self::query('DESCRIBE @',array($table));
		return self::row();
	}

/**
 * Sets the charset for the database
 * @params	string 	$charset	charset for MySQL database
 * @return 	void
 */
	public static function charset($char) {
		$char = strtolower($char);

		switch($char) {
				case "utf-8":
				$char = "utf8";
				break;

				case "windows-1250":
				$char = "cp1250";
				break;

				case "iso-8859-1":
				$char = "latin1";
				break;

				case "iso-8859-2":
				$char = "latin2";
				break;

				default:
				$char = "";
				break;
		}

    		if( !empty($char) )
			mysql_query("SET NAMES '".$char."'");
	}

/**
 * Sanitizing the query
 * @params      string	  The string to queried
 * @params      array	   The array of params in query represented by '#'
 * @return      void
 */
	public static function query($query, $params = array(), $ret = false) {
		// No parameters presented, execute query
		if(empty($params))
			return self::exec($query);

		$sql = "";
		$sqlt_ar = explode('@', $query);

		for( $i = 0; $i < sizeof($sqlt_ar) - 1; $i++) {
			$sql .= $sqlt_ar[$i];
			$sql .= "`".DB_PREFIX.$params[$i]."`";
		}

		$sql_ary = explode('#', $sqlt_ar[$i]);

		for( $k = 0; $i < sizeof($params); $i++, $k++) {
			$val = $params[$i];
			$sql .= $sql_ary[$k];

			$type = gettype($val);

			if( $type == 'string' )
				$sql .= Sanitize::escape($val);
			elseif( $type == 'boolean' )
				$sql .= ( $val ) ? 1 : 0;
			elseif( $val === null)
				$sql .=  "NULL";
			else
				$sql .= $val;
		}

		$sql .= $sql_ary[$k];

		if( $k + 1 != sizeof($sql_ary) )
			Error::databaseAPI($query,$k+1);

		self::exec($sql);

		if($ret)
			return self::$result;
	}
	
/**
 * Executing the query after sanitization
 * @params      string	  The sql statement
 * @return      void
 */
	protected static function exec($sql) {
		Timer::start('db');
		self::$result = @mysql_query($sql, self::$link);
		Timer::stop('db');

		if(mysql_errno(self::$link))
			Error::databaseSQL(mysql_error(self::$link), $sql);
	}

/**
 * Getting the number of affected rows
 * @return 	int 	Affected rows for last Insert, Update or Delete query
 */
	public static function affected() {
		return @mysql_affected_rows(self::$link);
	}

/**
 * Getting the incremented id of last query
 * @return 	int		Auto-increment ID for last Insert query
 */
	public static function getId() {
		return @mysql_insert_id(self::$link);
	}

/**
 * Freeing the memory after big results
 * @params      resource	  The sql resource
 * @return      void
 */
	public static function free($rs = null) {
		if(empty($rs))
			$rs = self::$result;

		if (is_resource($rs))
			@mysql_free_result($rs);
	}

/**
 * Getting the object of sql result
 * @params      resource	  The sql resource
 * @return      object
 */
	public static function obj($rs = null) {
		if(empty($rs))
			$rs = self::$result;

		if (is_resource($rs)) {
			$ret = array();
			for($i=0; $i<self::count(); $i++)
				array_push($ret,@mysql_fetch_object($rs));
			return $ret;
		} else
			return false;
	}

/**
 * Getting the array of sql result
 * @params      resource	  The sql resource
 * @return      array
 */
	public static function row($rs = null ) {
		if(empty($rs))
			$rs = self::$result;

		if (is_resource($rs)) {
			$ret = array();
			for($i=0; $i<self::count(); $i++)
				array_push($ret,@mysql_fetch_assoc($rs));
			return $ret;
		} else
			return false;
	}

/**
 * Getting the number of rows of sql result
 * @params      resource	  The sql resource
 * @return      int	       Number of rows in resource
 */
	public static function count($rs = null ) {
		if(empty($rs))
			$rs = self::$result;

		if (is_resource($rs))
			return @mysql_num_rows($rs);
		else
			return false;
	}
}

?>
