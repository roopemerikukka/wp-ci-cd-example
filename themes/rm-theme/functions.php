<?php
namespace RM\Example;

// Hooks.
add_action( 'wp_enqueue_scripts', '\\RM\\Example\\front_scripts', 999 );

/**
 * Function registers and enqueues the scripts
 * for frontend.
 *
 * @return void
 */
function front_scripts() {

		$scripts = [
			[
				'handle'  => 'rm-main-js',
				'src'     => search_theme_file_uri( '/assets/dist/', 'main.', '.js' ) . '?async',
				'deps'    => [],
				'version' => '',
				'footer'  => true,
			],
		];

		foreach ( $scripts as $s ) {
			wp_register_script( $s['handle'], $s['src'], $s['deps'], $s['version'], $s['footer'] );
			wp_enqueue_script( $s['handle'] );
		}

}

/**
 * Get a file uri by searching a given theme relative directory for a match
 *
 * @example search_theme_file_uri('/library/dist/js/', 'main', '.js');
 * @param string $folder_path     - The path where to find the file. Relative to the stylesheet directory.
 * @param string $starts_with     - The filename starting pattern.
 * @param string $ends_with       - The filename ending pattern.
 * @return string|bool            - The absolute path to file or false if not found.
 */
function search_theme_file_uri( $folder_path, $starts_with, $ends_with ) {
	// Get theme path.
	$theme_path = get_stylesheet_directory();
	$theme_uri  = get_stylesheet_directory_uri();

	// Get a list of files in the given theme folder path.
	if ( ! is_dir( $theme_path . $folder_path ) ) {
		return false;
	}

	$files = scandir( $theme_path . $folder_path );

	if ( ! is_array( $files ) ) {
		return false;
	}

	// Try to find a match if we got a list of files from scnadir.
	if ( $files ) {
		foreach ( $files as $file ) {
			if (
			substr( $file, 0, strlen( $starts_with ) ) === $starts_with && // Starts with.
			substr( $file, -strlen( $ends_with ), strlen( $ends_with ) ) === $ends_with // Ends with.
			) {
				return $theme_uri . $folder_path . $file;
			}
		}
	}

	// scandir failed or we couldn't find a file that matches the requirements.
	return false;
}