<?php
namespace FFBlock\Ctrl;

use FFBlock\Helper\Fns;
use FFBlock\Traits\Singleton;

/**
 * Assets control
 */
class AssetCtrl {
	use Singleton;

	/**
	 * Construct method
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_scripts' ] );
	}

	/**
	 * Block editor scripts
	 *
	 * @return void
	 */
	public function block_editor_scripts() {
		// fluent form plugin style for editor script.
		wp_register_style(
			'fluent-form-styles-ffb',
			plugins_url() . '/fluentform/assets/css/fluent-forms-public.css',
			[],
			FFBLOCK_VERSION,
			'all'
		);
		wp_register_style(
			'fluentform-public-default-ffb',
			plugins_url() . '/fluentform/assets/css/fluentform-public-default.css',
			[ 'fluent-form-styles-ffb' ],
			FFBLOCK_VERSION,
			'all'
		);

		/**
		 * Register for only localize script
		 */
		wp_register_script(
			'ffblock-localize-script',
			false,
			[],
			FFBLOCK_VERSION,
			true
		);
		wp_enqueue_script( 'ffblock-localize-script' );
		// localize file.
		$localize_obj = [
			'plugin'                => FFBLOCK_URL,
			'ajaxurl'               => admin_url( 'admin-ajax.php' ),
			'siteUrl'               => site_url(),
			'admin_url'             => admin_url(),
			'ffblock_nonce_key'     => wp_create_nonce( 'ffblock-nonce-val' ),
			'fluent_form_lists'     => wp_json_encode( Fns::get_fluent_forms_list() ),
			'is_fluent_form_active' => defined( 'FLUENTFORM' ) ? true : false,
		];
		wp_localize_script(
			'ffblock-localize-script',
			'ffbBlockParams',
			apply_filters( 'ffblock_localize_script', $localize_obj )
		);
	}
}
