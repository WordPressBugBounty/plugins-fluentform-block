<?php
namespace FFBlock\Ctrl;

use FFBlock\Traits\Singleton;

/**
 * Google Font loader class
 */
class FontLoader {

	use Singleton;

	/**
	 * @var array
	 */
	private static $all_fonts = [];
	/**
	 * Construct method
	 */
	public function __construct() {
		add_action( 'ffb_render_block', [ $this, 'font_generator' ] );
		add_action( 'wp_head', [ $this, 'fonts_loader' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'fonts_loader' ] );
	}

	/**
	 * Font generator
	 *
	 * @param array $block .
	 * @return void
	 */
	public function font_generator( $block ) {
		if ( isset( $block['attrs'] ) && is_array( $block['attrs'] ) ) {
			$attributes = $block['attrs'];
			foreach ( $attributes as $key => $value ) {
				if ( isset( $value['family'] ) ) {
					self::$all_fonts[] = $value['family'];
				}
			}
		}
	}

	/**
	 * Fonts loader
	 *
	 * @return void
	 */
	public function fonts_loader() {
		if ( is_array( self::$all_fonts ) && count( self::$all_fonts ) > 0 ) {
			$fonts = array_filter( array_unique( self::$all_fonts ) );

			if ( ! empty( $fonts ) ) {
				$system = [
					'Arial',
					'Tahoma',
					'Verdana',
					'Helvetica',
					'Times New Roman',
					'Trebuchet MS',
					'Georgia',
				];

				$gfonts      = '';
				$gfonts_attr = ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
				foreach ( $fonts as $font ) {
					if ( ! in_array( $font, $system, true ) && ! empty( $font ) ) {
						$gfonts .= str_replace( ' ', '+', trim( $font ) ) . $gfonts_attr . '|';
					}
				}

				if ( ! empty( $gfonts ) ) {
					$query_args = [
						'family' => $gfonts,
					];
					wp_register_style(
						'ffblock-block-fonts',
						add_query_arg( $query_args, '//fonts.googleapis.com/css' ),
						[],
						FFBLOCK_VERSION
					);
					wp_enqueue_style( 'ffblock-block-fonts' );
				}
				$gfonts = '';
			}
		}
	}
}
