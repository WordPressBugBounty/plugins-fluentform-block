<?php

use FFBlock\Helper\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$wrap_class       = Fns::get_block_wrapper_class( $settings );
$block_wrap_class = 'ffblock-fluent-form-wrapper';
$formName         = '';

if ( isset( $settings['layout'] ) && ! empty( $settings['layout'] ) ) {
	$block_wrap_class .= ' ffblock-fluent-form-style-' . $settings['layout'] . ' ';
}

if ( isset( $settings['labelEnable'] ) && ! $settings['labelEnable'] ) {
	$block_wrap_class .= 'ffblock-fm-hide-label ';
}

if ( isset( $settings['placeholderEnable'] ) && ! $settings['placeholderEnable'] ) {
	$block_wrap_class .= 'ffblock-fm-hide-placeholder ';
}

if ( isset( $settings['errorMessageEnable'] ) && ! $settings['errorMessageEnable'] ) {
	$block_wrap_class .= 'ffblock-fm-hide-error-message ';
}
if ( ! empty( $settings['formName'] ) ) {
	$block_wrap_class .= $settings['formName'] == 'inline_subscription' ? 'ffblock-fluentform-subscription' : '';
	$formName          = $settings['formName'];
}
?>

<?php if ( isset( $settings['formId'] ) && ! empty( $settings['formId'] ) ) { ?>
	<div class="<?php echo esc_attr( $wrap_class ); ?>">
		<div class="<?php echo esc_attr( $block_wrap_class ); ?>">
			<?php
			$shortcode = sprintf( '[fluentform id="' . $settings['formId'] . '" type="' . $formName . '"]' );
			echo do_shortcode( shortcode_unautop( $shortcode ) );
			?>
		</div>
	</div>
<?php } ?>