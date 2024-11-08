<?php
namespace FFBlock\Ctrl;

use FFBlock\Traits\Singleton;

/**
 * Style generator
 */
class StyleGenerator {
	use Singleton;

	/**
	 * Init constructor.
	 */
	public function __construct() {
		add_filter( 'render_block', [ $this, 'generate_dynamic_style' ], 10, 2 );
	}
	/**
	 * Dynamic style generate
	 *
	 * @param string $block_content .
	 * @param array  $block .
	 * @return mixed
	 */
	public function generate_dynamic_style( $block_content, $block ) {
		if ( isset( $block['blockName'] ) && str_contains( $block['blockName'], 'ffblock/' ) ) {

			do_action( 'ffb_render_block', $block );

			if ( isset( $block['attrs']['blockCSS'] ) ) {
				$style  = $this->get_block_style( $block['attrs']['blockCSS'] );
				$handle = $block['attrs']['blockId'] ?? 'fluentform-block';
				// minify style to remove extra space.
				$style = preg_replace( '/\s+/', ' ', $style );
				// register style.
				wp_register_style( $handle, false, [], FFBLOCK_VERSION, 'all' );
				wp_enqueue_style( $handle );
				wp_add_inline_style( $handle, $style );
			}
		}
		return $block_content;
	}

	/**
	 * Get Block Style.
	 *
	 * @param array $style Block Attribute.
	 */
	public function get_block_style( $style ) {
		$css = null;
		if ( isset( $style['desktop'] ) && strlen( $style['desktop'] ) > 0 ) {
			$css .= $style['desktop'];
		}
		if ( isset( $style['tablet'] ) && strlen( $style['tablet'] ) > 0 ) {
			$css .= sprintf(
				'@media all and (max-width: 1024px) {%1$s}',
				$style['tablet']
			);
		}
		if ( isset( $style['mobile'] ) && strlen( $style['mobile'] ) > 0 ) {
			$css .= sprintf(
				'@media all and (max-width: 767px) {%1$s}',
				$style['mobile']
			);
		}
		if ( isset( $style['customCss'] ) && strlen( $style['customCss'] ) > 0 ) {
			$css .= $style['customCss'];
		}
		return $css;
	}
}
