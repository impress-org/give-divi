<?php
defined('ABSPATH') or exit; ?>

<div class="notice notice-error">
    <p>
        <strong><?php
            esc_html_e('Activation Error:', 'give-divi'); ?></strong>
        <?php
        echo GIVE_DIVI_ADDON_NAME; ?>
        <?php
        esc_html_e('add-on requires Divi builder to be activated.', 'give-divi'); ?>
    </p>
</div>
