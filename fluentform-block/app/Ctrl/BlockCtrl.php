<?php
namespace FFBlock\Ctrl;

use FFBlock\Helper\Fns;
use FFBlock\Traits\Singleton;

/**
 * Block control
 */
class BlockCtrl {
	use Singleton;

	/**
	 * Construct method
	 */
	public function __construct() {
		add_filter( 'block_categories_all', [ $this, 'block_category' ], 9999, 2 );
		add_action( 'init', [ $this, 'register_block' ] );
		add_action( 'wp_ajax_ffblock_fluentform', [ $this, 'ffblock_fluentform' ] );
	}
	/**
	 * Register Block
	 *
	 * @return void
	 */
	public function register_block() {
		register_block_type(
			FFBLOCK_PATH . 'build',
			[
				'render_callback' => [ $this, 'render_block' ],
			]
		);
	}

	/**
	 * Render Block
	 *
	 * @param array $attributes .
	 * @return false|string
	 */
	public function render_block( $attributes ) {
		$template_style = 'fluentform';
		$data           = [
			'settings' => $attributes,
		];

		$data = apply_filters( 'ffblock_fluentform_data', $data );
		ob_start();
		Fns::views( $template_style, $data );
		return ob_get_clean();
	}
	/**
	 * Fluent form ajax
	 *
	 * @return void
	 */
	public function ffblock_fluentform() {
		if ( ! isset( $_POST['ffblock_nonce_key'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ffblock_nonce_key'] ) ), 'ffblock-nonce-val' ) ) {
			wp_send_json_error( esc_html__( 'Session Expired!!', 'fluentform-block' ) );
		}

		$formId = isset( $_POST['formId'] ) ? map_deep( wp_unslash( $_POST['formId'] ), 'sanitize_text_field' ) : '';
		$formId = Fns::is_form_exist( $formId );

		if ( ! empty( $formId ) ) {
			$data['html'] = do_shortcode( '[fluentform id="' . $formId . '" ]' );
		} else {
			$data['html'] = '<p>' . __( 'Please select a valid fluentform.', 'fluentform-block' ) . '</p>';
		}
		wp_send_json_success( $data );
	}

	/**
	 * Register block category
	 *
	 * @param array $categories .
	 * @return array
	 */
	public function block_category( $categories ) {
		$gb_category = [
			'slug'  => 'fluentform-block',
			'title' => __( 'Fluent Form Block', 'fluentform-block' ),
		];

		$modifiedCategory   = [];
		$modifiedCategory   = apply_filters( 'ffblock_block_category_lists', $modifiedCategory );
		$modifiedCategory[] = $gb_category;
		$modifiedCategory   = array_merge( $modifiedCategory, $categories );
		return $modifiedCategory;
	}
}
