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
	public static function isSettingPresentAsArray( array $config, $setting ) {
		return isset( $config[ $setting ] ) && is_array( $config[ $setting ] );
	}

}
