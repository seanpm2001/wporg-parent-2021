<?php
/**
 * Rosetta customizations.
 */

namespace WordPressdotorg\Theme\Parent_2021\Rosetta_Styles;

defined( 'WPINC' ) || die();

add_filter( 'wp_theme_json_data_user', __NAMESPACE__ . '\inject_i18n_customizations' );

/**
 * Inject customizations for Rosetta sites.
 *
 * @param WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 *
 * @return WP_Theme_JSON_Data The updated user settings.
 */
function inject_i18n_customizations( $theme_json ) {
	$locale_settings = get_locale_settings( get_locale() );
	$locale_styles = get_locale_styles( get_locale() );
	if ( ! $locale_settings && ! $locale_styles ) {
		return $theme_json;
	}

	$config = array(
		'version' => 2,
	);

	if ( $locale_settings ) {
		$config['settings'] = $locale_settings;
	}

	if ( $locale_styles ) {
		$config['styles'] = $locale_styles;
	}

	return $theme_json->update_with( $config, 'custom' );
}

/**
 * Get a theme.json-shaped array with custom values for a given locale.
 *
 * The returned array should match the structure of "settings" in a theme.json
 * file. These will be loaded as the "user" settings, which will override the
 * theme.json values. Rosetta sites can then override any of the generated
 * custom properties (ex, --wp--preset--font-size--normal) in a way that will
 * cascade to any future child themes, and also render correctly in the editor.
 *
 * @param string $locale The current site locale.
 *
 * @return array An array of settings mirroring a theme.json "settings" object.
 */
function get_locale_settings( $locale ) {
	switch ( $locale ) {
		case 'ca':
		case 'fr_FR':
		case 'it_IT':
		case 'ro_RO':
			return [
				'typography' => [
					'fontSizes' => [
						[
							'slug' => 'heading-cta',
							'size' => '96px',
						],
					],
				],
			];
		case 'ja':
			return [
				'custom' => [
					'heading' => [
						'cta' => [
							'breakpoint' => [
								'small-only' => [
									'typography' => [
										'fontSize' => '50px',
									],
								],
							],
						],
						'typography' => [
							'text-wrap' => 'unset',
						],
					],
				],
				'typography' => [
					'fontFamilies' => [
						[
							'fontFamily' => '"Noto Serif JP", serif',
							'slug' => 'noto-serif-jp',
							'name' => 'Noto Serif JP',
						],
					],
					'fontSizes' => [
						[
							'slug' => 'heading-cta',
							'size' => '70px',
						],
						[
							'slug' => 'heading-1',
							'size' => '60px',
						],
						[
							'slug' => 'heading-2',
							'size' => '40px',
						],
					],
				],
			];
	}
	return false;
}

/**
 * Get a theme.json-shaped array with custom values for a given locale.
 *
 * The returned array should match the structure of "styles" in a theme.json
 * file. This can be used to override block, element, and sitewide styles.
 * The `css` key can also be used to inject CSS code into all child themes.
 *
 * @param string $locale The current site locale.
 *
 * @return array An array of styles mirroring a theme.json "styles" object.
 */
function get_locale_styles( $locale ) {
	switch ( $locale ) {
		case 'ja':
			return [
				'css' => 'body { font-feature-settings: "palt"; }',
			];
	}
}
