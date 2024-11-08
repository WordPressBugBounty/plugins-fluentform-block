<?php
use FFBlock\Traits\Singleton;
use FFBlock\Ctrl\MainCtrl;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once FFBLOCK_PATH . 'vendor/autoload.php';

/**
 * Class FFBlock
 */
final class FFBlock {

	use Singleton;

	/**
	 * @var string
	 */
	public $nonceId = 'ffblock_wpnonce';

	/**
	 * FFB Project Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'language' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ], 100 );
	}

	/**
	 * Plugins loaded init file
	 *
	 * @return void
	 */
	public function init() {
		do_action( 'ffblock_before_init' );
		new MainCtrl();
		do_action( 'ffblock_init' );
	}

	/**
	 * Load Text Domain
	 */
	public function language() {
		load_plugin_textdomain( 'fluentform-block', false, FFBLOCK_ABSPATH . '/languages/' );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( FFBLOCK_FILE ) );
	}

	/**
	 * @return mixed
	 */
	public function version() {
		return FFBLOCK_VERSION;
	}


	/**
	 * Render block
	 *
	 * @param string  $viewName .
	 * @param array   $args .
	 * @param boolean $return .
	 * @return false|string|void
	 */
	public function render( $viewName, $args = [], $return = false ) {
		$path     = str_replace( '.', '/', $viewName );
		$viewPath = FFBLOCK_PATH . 'view/' . $path . '.php';

		if ( ! file_exists( $viewPath ) ) {
			return;
		}

		if ( $args ) {
			extract( $args );
		}

		if ( $return ) {
			ob_start();
			include $viewPath;

			return ob_get_clean();
		}
		include $viewPath;
	}
}

/**
 * @return bool|Singleton|FFBlock
 */
function ffblock() {
	return FFBlock::getInstance();
}
ffblock();
