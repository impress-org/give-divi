<?php defined( 'ABSPATH' ) or exit; ?>

<div class="notice notice-error">
	<p>
		<strong><?php esc_html_e( 'Activation Error:', 'give-divi' ); ?></strong>
		<?php sprintf( esc_html_e( '%s add-on requires Divi theme to be activated.', 'give-divi' ), GIVE_DIVI_ADDON_NAME ); ?>
	</p>
</div>
