<?php
/**
 * @var $error string
 * @var $success string
 * @var $nonce string
 * @var $tab string
 * @var $language_options array
 * @var $version_options array
 * @var $media_options array
 * @var $old array
 */
$this->layout( 'layouts/settings', compact( 'tab' ) )
?>

    <form method="post">
		<?php wp_nonce_field( 'dt_admin_form', 'bible_plugin' ) ?>

        <fieldset>
            <div class="br-form-group">
                <sp-field-group>
                    <sp-field-label
                            required
                            for="bible_plugin_bible_brains_key"><?php esc_html_e( 'Bible Brain API Key', 'bible-plugin' ); ?></sp-field-label>

                    <div>
                        <sp-textfield id="bible_plugin_bible_brains_key"
                                      name="bible_plugin_bible_brains_key"
                                      value="<?php echo esc_attr( $old['bible_plugin_bible_brains_key'] ?? null ); ?>"
                                      placeholder="<?php esc_attr_e( 'Enter key...', 'bible-plugin' ); ?>"
                                      required
                        ></sp-textfield>
                        <sp-button variant="secondary"
                                   label="<?php esc_attr_e( 'Validate', 'bible-plugin' ); ?>"
                                   size="m">
							<?php esc_html_e( 'Validate', 'bible-plugin' ); ?>
                            <sp-icon-key slot="icon"></sp-icon-key>
                        </sp-button>
                    </div>

                    <sp-help-text size="s">
                        <sp-link href="https://scripture.api.bible/docs">
							<?php esc_html_e( "Here's how to get your key.", 'bible-plugin' ); ?>
                        </sp-link>
                    </sp-help-text>
                </sp-field-group>
            </div>
        </fieldset>
    </form>

<?php if ( $old['bible_plugin_bible_brains_key'] ): ?>
    <sp-divider size="s" x-show="Object.values(language_options).length > 0"></sp-divider>

    <form method="post"
          x-data="br_bible_brains_form(<?php echo esc_attr(
		      wp_json_encode(
			      array_merge(
				      $old,
				      [
					      'nonce'            => $nonce,
					      'language_options' => $language_options,
					      'version_options'  => $version_options,
					      'media_options'    => $media_options
				      ]
			      )
		      )
	      ); ?>)"
          x-show="Object.values(language_options).length > 0"
          @submit="submit"
    >

        <fieldset>

            <br-alert-banner positive x-show:open="success" open x-ref="successAlert">
				<?php echo esc_html( $success ); ?>
            </br-alert-banner>


            <br-alert-banner negative x-show="!success & error" open x-ref="errorAlert">
				<?php echo esc_html( $error ); ?>
            </br-alert-banner>

            <sp-field-group>
                <sp-field-label
                        required
                        for="bible_plugin_languages"><?php esc_html_e( 'Languages', 'bible-plugin' ); ?></sp-field-label>

                <br-multi-picker id="bible_plugin_languages"
                                 name="bible_plugin_languages"
                                 label="Choose..."
                                 required
                                 :value="bible_plugin_languages"
                                 @change="bible_plugin_languages = $event.target.value"
                >
                    <template x-for="(label, value) in language_options" :key="value">
                        <sp-menu-item
                                :value="value">
                            <span x-text="label"></span>
                        </sp-menu-item>
                    </template>


                </br-multi-picker>

                <sp-help-text size="s">
					<?php esc_html_e( "Select the bible languages you would like to make available.", 'bible-plugin' ); ?>
                </sp-help-text>
            </sp-field-group>

            <sp-field-group
                    x-show="bible_plugin_languages && Object.values(selected_language_options).length > 0">
                <sp-field-label
                        required
                        for="bible_plugin_language"
                ><?php esc_html_e( 'Default Language', 'bible-plugin' ); ?></sp-field-label>

                <sp-picker id="bible_plugin_language"
                           name="bible_plugin_language"
                           label="Choose..."
                           required
                           :key="bible_plugin_languages"
                           :value="bible_plugin_language"
                           @change="bible_plugin_language = $event.target.value">
                    <template x-for="(label, value) in language_options"
                              :key="value"
                    >
                        <sp-menu-item
                                x-show="bible_plugin_languages.includes(value)"
                                :value="value">
                            <span x-text="label"></span>
                        </sp-menu-item>
                    </template>

                </sp-picker>

                <sp-help-text size="s">
					<?php esc_html_e( "Select the bible language that will be used by default.", 'bible-plugin' ); ?>
                </sp-help-text>
            </sp-field-group>

            <sp-field-group x-show="bible_plugin_languages && Object.values(version_options).length">
                <sp-field-label
                        required
                        for="default_version_options.length"><?php esc_html_e( 'Bible Versions', 'bible-plugin' ); ?></sp-field-label>

                <br-multi-picker id="bible_plugin_versions"
                                 name="bible_plugin_versions"
                                 label="Choose..."
                                 required
                                 :value="bible_plugin_versions"
                                 @change="
                                    bible_plugin_versions = $event.target.value;
                                 ">
                    <template
                            x-for="(label, value) in version_options"
                            :key="value"
                    >
                        <sp-menu-item :value="value">
                            <span x-text="label"></span>
                        </sp-menu-item>
                    </template>
                </br-multi-picker>
                <sp-help-text size="s">
					<?php esc_html_e( "Select the bible versions you would like to make available.", 'bible-plugin' ); ?>
                </sp-help-text>
            </sp-field-group>

            <sp-field-group x-show="bible_plugin_versions && Object.values(selected_version_options).length">
                <sp-field-label
                        required
                        for="bible_plugin_version"
                ><?php esc_html_e( 'Default Bible Version', 'bible-plugin' ); ?></sp-field-label>

                <sp-picker id="bible_plugin_version"
                           name="bible_plugin_version"
                           label="Choose..."
                           required
                           :value="bible_plugin_version"
                           @change="bible_plugin_version = $event.target.value"
                >
                    <template x-for="(label, value) in version_options"
                              :key="value">
                        <sp-menu-item
                                x-show="bible_plugin_versions.includes(value)"
                                :value="value">
                            <span x-text="label"></span>
                        </sp-menu-item>
                    </template>

                </sp-picker>

                <sp-help-text size="s">
					<?php esc_html_e( "Select the bible version that will be used by default.", 'bible-plugin' ); ?>
                </sp-help-text>
            </sp-field-group>

            <sp-field-group x-show="bible_plugin_versions && Object.values(media_options).length">
                <sp-field-label
                        required
                        for="bible_plugin_media"
                >
					<?php esc_html_e( 'Media Types', 'bible-plugin' ); ?>
                </sp-field-label>

                <input type="hidden" name="bible_plugin_media" x-model="bible_plugin_media">

                <sp-field-group horizontal>
                    <template x-for="(label, value) in media_options">
                        <sp-checkbox required
                                     size="m"
                                     @change="$stringable_checkbox_change('bible_plugin_media', $event)"
                                     :checked="$as_array('bible_plugin_media').includes(value)"
                                     :value="value"
                        >
                            <span x-text="label"></span>
                        </sp-checkbox>
                    </template>

                </sp-field-group>


                <sp-help-text size="s">
					<?php esc_html_e( "Note that some bible versions do not support all media types.", 'bible-plugin' ); ?>
                </sp-help-text>
            </sp-field-group>

            <sp-button-group>
                <sp-button
                        type="submit"
                        variant="accent"
                        label="Save"
                >
					<?php esc_html_e( 'Save', 'bible-plugin' ); ?>
                </sp-button>
            </sp-button-group>
        </fieldset>
    </form>
<?php endif; ?>