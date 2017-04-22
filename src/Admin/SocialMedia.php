<?php
namespace ICaspar\WPHub\Admin;

/**
 * Class SocialMedia
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Admin
 */
class SocialMedia {

	/**
	 * Social Media Options Data.
	 *
	 * @var array
	 */
	protected $media;

	/**
	 * SocialMedia constructor.
	 */
	public function __construct() {
		$this->getSocialMedia();
		$this->setPluginHooks();
	}

	/**
	 * Set hooks to tie plugin functions into WordPress.
	 * @return void
	 */
	private function setPluginHooks() {
		add_action( 'admin_init', [ $this, 'addSocialMediaOptions' ] );
	}

	/**
	 * Get the GA Tracking ID from the DB Options table.
	 * @return void
	 */
	private function getSocialMedia() {
		$this->media = get_option( 'dcllc-social-media' ) ?: [];
	}

	/**
	 * Callback to add the GA Tracking Code Option on the WP Dashboard's General Settings page.
	 * @return void
	 */
	public function addSocialMediaOptions() {
		register_setting( 'general', 'dcllc-social-media', [ $this, 'validate_url_array' ] );

		add_settings_field(
			'dcllc-social-media[facebook]',
			__( 'Facebook URL', ICASPAR_HUB_TEXT_DOMAIN ),
			[ $this, 'renderSocialMediaField' ],
			'general',
			'default',
			[
				'label_for' => 'dcllc-social-media[facebook]',
				'media'     => 'facebook',
			]
		);

		add_settings_field(
			'dcllc-social-media[twitter]',
			__( 'Twitter URL', ICASPAR_HUB_TEXT_DOMAIN ),
			[ $this, 'renderSocialMediaField' ],
			'general',
			'default',
			[
				'label_for' => 'dcllc-social-media[twitter]',
				'media'     => 'twitter',
			]
		);

		add_settings_field(
			'dcllc-social-media[linkedin]',
			__( 'LinkedIn URL', ICASPAR_HUB_TEXT_DOMAIN ),
			[ $this, 'renderSocialMediaField' ],
			'general',
			'default',
			[
				'label_for' => 'dcllc-social-media[linkedin]',
				'media'     => 'linkedin',
			]
		);

	}

	/**
	 * Callback to display the GA Tracking ID field on the WP Dashboard's General Settings page.
	 *
	 * @param array $args Arguments passed from add_settings_field.
	 *
	 * @return void
	 */
	public function renderSocialMediaField( $args ) {
		echo '<input class="regular-text code" type="text" id="' . $args['label_for'] .
		     '" name="' . $args['label_for'] .
		     '" value="' . esc_url( $this->media[ $args['media'] ] ) .
		     '" placeholder="http://' . $args['media'] .
		     '.com" />';
	}

	/**
	 * Validate an array of inpt urls.
	 *
	 * @since 1.0.0
	 *
	 * @param array $input Multiple Url input.
	 *
	 * @return array Sanitized Url input.
	 */
	public function validate_url_array( array $input ) {
		$safe_input = [];
		foreach ( $input as $media => $url ) {
			$safe_input[$media] = esc_url_raw( $url );
		}

		return $safe_input;
	}
}