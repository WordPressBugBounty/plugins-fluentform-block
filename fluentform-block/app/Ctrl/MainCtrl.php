<?php
namespace FFBlock\Ctrl;

/**
 * Main control class
 */
class MainCtrl {
	/**
	 * Construct method
	 */
	public function __construct() {
		AssetCtrl::getInstance();
		BlockCtrl::getInstance();
		StyleGenerator::getInstance();
		FontLoader::getInstance();
	}
}
