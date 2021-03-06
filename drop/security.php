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

class Security extends Object {

/**
 * Default hash method
 *
 * @var string
 * @access public
 */
	public static $hashType = 'sha1';

/**
 * Constructor.
 */
	function __construct() {}

/**
 * Generate authorization hash.
 *
 * @return string Hash
 * @access public
 * @static
 */
	public static function generateAuthKey() {
		return Security::hash(String::uuid());
	}

/**
 * Sets the default hash method for the Security object.  This affects all objects using
 * Security::hash().
 *
 * @param string $hash Method to use (sha1/sha256/md5)
 * @access public
 * @return void
 * @static
 * @see Security::hash()
 */
	public static function setHash($hash) {
		self::$hashType = $hash;
	}

/**
 * Create a hash from string using given method.
 * Fallback on next available method.
 *
 * @param string $string String to hash
 * @param string $type Method to use (sha1/sha256/md5)
 * @param boolean $salt If true, automatically appends the application's salt
 *     value to $string (Security.salt)
 * @return string Hash
 * @access public
 * @static
 */
	public static function hash($string, $type = null, $salt = false) {
		if ($salt) {
			if (is_string($salt)) {
				$string = $salt . $string;
			} else {
				$string = $configure->read('security.salt') . $string;
			}
		}

		if (empty($type)) {
			$type = self::$hashType;
		}
		$type = strtolower($type);

		if ($type == 'sha1' || $type == null) {
			if (function_exists('sha1')) {
				$return = sha1($string);
				return $return;
			}
			$type = 'sha256';
		}

		if ($type == 'sha256' && function_exists('mhash')) {
			return bin2hex(mhash(MHASH_SHA256, $string));
		}

		if (function_exists('hash')) {
			return hash($type, $string);
		}
		return md5($string);
	}

/**
 * Encrypts/Decrypts a text using the given key.
 *
 * @param string $text Encrypted string to decrypt, normal string to encrypt
 * @param string $key Key to use
 * @return string Encrypted/Decrypted string
 * @access public
 * @static
 */
	public static function cipher($text, $key) {
		if (empty($key)) {
			Error::emptyCipherKey();
		}

		srand($configure->read('security.cipherSeed'));
		$out = '';
		$keyLength = strlen($key);
		for ($i = 0, $textLength = strlen($text); $i < $textLength; $i++) {
			$j = ord(substr($key, $i % $keyLength, 1));
			while ($j--) {
				rand(0, 255);
			}
			$mask = rand(0, 255);
			$out .= chr(ord(substr($text, $i, 1)) ^ $mask);
		}
		srand();
		return $out;
	}
}

?>
