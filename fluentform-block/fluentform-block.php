<?php
/**
 * Plugin Name:       Fluent Forms Block
 * Plugin URI:        https://wordpress.org/plugins/fluentform-block
 * Description:       Fluent forms block is the extension of Fluent forms plugin.You can build advanced Contact form by Fluent form  block.
 * Version:           2.0.4
 * Requires at least: 5.5
 * Requires PHP:      7.4
 * Author:            wpmetablock
 * Author URI:        https://github.com/wpmetablock
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fluentform-block
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || die( 'Keep Silent' );
define( 'FFBLOCK_FILE', __FILE__ );
define( 'FFBLOCK_PATH', plugin_dir_path( FFBLOCK_FILE ) );
define( 'FFBLOCK_ABSPATH', dirname( FFBLOCK_FILE ) );
define( 'FFBLOCK_URL', plugins_url( '', FFBLOCK_FILE ) );
define( 'FFBLOCK_VERSION', '2.0.4' );

if ( ! class_exists( 'FFBlock' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'app/FFBlock.php';
}
