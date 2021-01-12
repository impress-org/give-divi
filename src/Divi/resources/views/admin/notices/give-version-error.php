<?php defined( 'ABSPATH' ) or exit; ?>

<strong>
	<?php _e( 'Activation Error:', 'give-divi' ); ?>
</strong>
<?php _e( 'You must have', 'give-divi' ); ?> <a href="https://givewp.com" target="_blank">GiveWP</a>
<?php _e( 'version', 'give-divi' ); ?> <?php echo GIVE_VERSION; ?>+
<?php printf( esc_html__( 'for the %1$s add-on to activate', 'give-divi' ), GIVE_DIVI_NAME ); ?>.

