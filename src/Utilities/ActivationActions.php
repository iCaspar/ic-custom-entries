<?php
/**
 * ActivationHooks class.
 *
 * @package ICaspar\CustomEntries\Utilities
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Utilities;

/**
 * Class ActivationHooks
 *
 * @package ICaspar\CustomEntries\Utilities
 * @since 1.0.0
 */
class ActivationActions {

	/**
	 * Clean up rewrite rules on deactivation.
	 *
	 * @since 1.0.0
	 *
	 * @static
	 * @return void
	 */
	public static function deactivate(): void {
		flush_rewrite_rules();
		update_option( 'ic-custom-entries-active', false );
	}

	/**
	 * Flush rewrite rules when plugin has not been previously activated.
	 *
	 * @since 1.0.0
	 *
	 * @static
	 * @return void
	 */
	public static function maybe_flush_rewrites(): void {
		if ( true == get_option( 'ic-custom-entries-active' ) ) {
			return;
		}

		flush_rewrite_rules();
		update_option( 'ic-custom-entries-active', true );
	}

}
