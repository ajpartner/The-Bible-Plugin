<div class="alerts">
    <br-alert-banner accent x-ref="success_alert">
        <span x-show="!!success && typeof success !== 'boolean'" x-text="success"></span>
        <span x-show="success === true"><?php esc_html_e( 'Success!', 'bible-plugin' ); ?></span>
    </br-alert-banner>

    <br-alert-banner negative x-ref="error_alert">
        <span x-show="!!error && typeof error !== 'boolean'" x-text="error"></span>
        <span x-show="error === true"><?php esc_html_e( 'An error has occurred.', 'bible-plugin' ); ?></span>
    </br-alert-banner>
</div>
