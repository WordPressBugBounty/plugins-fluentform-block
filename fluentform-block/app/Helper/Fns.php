<?php

namespace FFBlock\Helper;

/**
 * Helper main class
 */
class Fns {

	/**
	 * Views
	 *
	 * @param template $name .
	 * @param array    $data .
	 * @return void
	 */
	public static function views( $name, $data = [] ) {
		$__file = static::get_views_path( $name );
		$helper = static::class;
		extract( $data );
		if ( is_readable( $__file ) ) {
			include $__file;
		}
	}

	/**
	 * Get view path
	 *
	 * @param string $name .
	 * @return false|string
	 */
	protected static function get_views_path( $name ) {
		$file = FFBLOCK_PATH . 'views/' . $name . '.php';
		if ( file_exists( $file ) ) {
			return $file;
		}
		return false;
	}


	/**
	 * Get fluentform list
	 *
	 * @return array
	 */
	public static function get_fluent_forms_list() {
		$options             = [];
		$options[0]['label'] = __( 'Select a Form', 'fluentform-block' );
		$options[0]['value'] = '';

		if ( defined( 'FLUENTFORM' ) ) {
			global $wpdb;
			$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}fluentform_forms WHERE status = 'published'" );
			if ( ! empty( $result ) ) {
				foreach ( $result as $key => $form ) {
					$options[ $key + 1 ]['label']         = $form->title;
					$options[ $key + 1 ]['value']         = $form->id;
					$options[ $key + 1 ]['template_name'] = self::get_form_attr( $form->id );
				}
			}
		}

		return $options;
	}

	/**
	 * Get Form Attribute
	 *
	 * @param number $form_id .
	 * @return mixed|null
	 */
	public static function get_form_attr( $form_id ) {
		return \FluentForm\App\Helpers\Helper::getFormMeta( $form_id, 'template_name' );
	}

	/**
	 * Block wrapper class
	 *
	 * @param array  $settings .
	 * @param string $class_name .
	 * @return string
	 */
	public static function get_block_wrapper_class( $settings = [], $class_name = '' ) {
		$wrap_class = '';

		if ( isset( $settings['blockId'] ) ) {
			$wrap_class .= $settings['blockId'];
		}
		$wrap_class .= ' ffblock-block-frontend';

		if ( isset( $settings['mainWrapShowHide'] ) ) {
			$wrap_class .= $settings['mainWrapShowHide']['lg'] ? ' ffblock-hide-desktop' : '';
			$wrap_class .= $settings['mainWrapShowHide']['md'] ? ' ffblock-hide-tablet' : '';
			$wrap_class .= $settings['mainWrapShowHide']['sm'] ? ' ffblock-hide-mobile' : '';
		}
		if ( ! empty( $class_name ) ) {
			$wrap_class .= ' ' . $class_name;
		}

		return $wrap_class;
	}
	/**
	 * If form exist
	 *
	 * @param number $form_id .
	 * @return string
	 */
	public static function is_form_exist( $form_id ) {
		global $wpdb;
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}fluentform_forms WHERE id = %d AND status = 'published'",
				$form_id
			)
		);
		return ! empty( $result ) ? $result[0]->id : '';
	}

	/**
	 *  Verify nonce.
	 *
	 * @return bool
	 */
	public static function verify_nonce() {
		$nonce = isset( $_REQUEST[ ffblock()->nonceId ] ) ? sanitize_text_field( $_REQUEST[ ffblock()->nonceId ] ) : null;
		if ( wp_verify_nonce( $nonce, ffblock()->nonceId ) ) {
			return true;
		}

		return false;
	}
}
