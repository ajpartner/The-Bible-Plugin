<?php

use function CodeZone\Bible\namespace_string;
use function CodeZone\Bible\plugin_url;
use function CodeZone\Bible\rgb;
use function CodeZone\Bible\get_plugin_option;

/**
 * @var $tab string
 **/

/**
 * Variable representing the navigation menu.
 *
 * @var array $nav
 */

$nav = apply_filters( namespace_string( 'settings_tabs' ), [] );

/**
 * Is there a Bible Brain API Key?
 *
 * @var bool $has_api_key
 */
$has_api_key  = ! ! get_plugin_option( 'bible_brains_key', false );
$color_scheme = get_plugin_option( 'color_scheme' );
$colors       = get_plugin_option( 'colors' );
$accent_steps = $colors['accent_steps'] ?? [];
?>

<style>
    .br-cloak {
        display: none;
    }

    <?php if ( $color_scheme === 'dark' ): ?>
    body {
        background-color: #1D2327;
    }

    <?php endif; ?>
</style>

<style>

</style>
<sp-theme scale="medium" color="<?php esc_attr_e( $color_scheme ); ?>" style="
<?php if ( ! empty( $accent_steps['600'] ) ): ?>
        --spectrum-accent-color-default: <?php echo esc_attr( $accent_steps['600'] ?? '' ) ?>;
<?php endif; ?>
<?php foreach ( $accent_steps as $step => $rgba ): ?>
        --spectrum-accent-color-<?php echo esc_attr( $step ) ?>: <?php echo esc_attr( $rgba ) ?>;
<?php endforeach; ?>">
    <div class=" bible-plugin br-cloak wrap">

        <header>
            <div class="header__brand">
                <img src="<?php echo esc_url( plugin_url( 'resources/img/tbp-vertical-dark.svg', __FILE__ ) ) ?>"
                     alt="<?php esc_attr_e( 'The Bible Plugin', 'bible-plugin' ) ?>"
                     width="150"
                     height="135"
                     class="header__logo header__logo--dark"
                >
                <img src="<?php echo esc_url( plugin_url( 'resources/img/tbp-vertical-light.svg', __FILE__ ) ) ?>"
                     alt="<?php esc_attr_e( 'The Bible Plugin', 'bible-plugin' ) ?>"
                     width="150"
                     height="135"
                     class="header__logo header__logo--light"
                >
            </div>

            <div class="header__title hidden">
                <h1><?php esc_html_e( 'The Bible Plugin', 'bible-plugin' ) ?></h1>
            </div>
        </header>

		<?php if ( ! $has_api_key ): ?>
            <sp-toast variant="negative" size="s" float open>
				<?php esc_html_e( 'You must add your Bible Brain API Key in order for this plugin to work.', 'bible-plugin' ) ?>

                <a href="https://scripture.api.bible/docs" slot="action">
                    <sp-button
                            static="white"
                            variant="secondary"
                            treatment="outline"
                            size="s"
                    >
						<?php esc_html_e( "More Info", 'bible-plugin' ); ?>
                    </sp-button>
                </a>
            </sp-toast>
		<?php endif; ?>

        <sp-divider size="l" brown></sp-divider>

        <sp-tabs size="l" emphasized selected="<?php echo esc_attr( $tab ) ?>">
			<?php foreach ( $nav as $index => $item ): ?>
                <sp-tab label="<?php echo esc_html( $item['label'] ) ?>"
                        href="<?php echo esc_url( admin_url( 'admin.php?page=bible-plugin&tab=' . $item['tab'] ) ) ?>"
                        value="<?php echo esc_attr( $item['tab'] ) ?>"
                        onclick="window.location.href = '<?php echo esc_url( admin_url( 'admin.php?page=bible-plugin&tab=' . $item['tab'] ) ) ?>'"
                ></sp-tab>
			<?php endforeach; ?>
        </sp-tabs>

        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
					<?php echo $this->section( 'content' ) ?>
                </div>
            </div>
        </div>

        <div id="postbox-container-1" class="postbox-container">
			<?php echo $this->section( 'right' ) ?>
        </div>
</sp-theme>