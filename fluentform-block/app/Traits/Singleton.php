<?php

/**
 * Singleton
 *
 * @since 1.0.0
 * @package FFB Project
 * @author NurencyDigital
 */

namespace FFBlock\Traits;

trait Singleton {

	/**
	 * @var bool
	 */
	private static $singleton = false;

	/**
	 * Fetch an instance of the class.
	 */
	public static function getInstance() {
		if ( false === self::$singleton ) {
			self::$singleton = new self();
		}

		return self::$singleton;
	}
}
