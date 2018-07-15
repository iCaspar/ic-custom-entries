<?php
/**
 * Helpers class.
 *
 * @package ICaspar\CustomEntries\Utilities
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Utilities;

/**
 * Class Helpers
 *
 * @package ICaspar\CustomEntries\Utilities
 *
 * @since 1.0.0
 */
class Helpers {

	/**
	 * Find whether a setting exists as an array.
	 *
	 * @param array $config
	 * @param string $setting
	 *
	 * @static
	 * @return bool
	 */
	public static function isSettingPresentAsArray( array $config, $setting ): bool {
		return isset( $config[ $setting ] ) && is_array( $config[ $setting ] );
	}

	/**
	 * Determine whether plugin is in development mode
	 *
	 * @since 1.0.0
	 *
	 * @static
	 * @return bool
	 */
	public static function is_development_mode(): bool {
		return defined( 'SCRIPT_DEBUG') && SCRIPT_DEBUG == true;
	}

}
