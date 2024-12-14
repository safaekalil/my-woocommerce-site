<?php
/**
 * Theme Functions
 *
 * @author Jegstudio
 * @package oigny-lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

defined( 'OIGNY_LITE_VERSION' ) || define( 'OIGNY_LITE_VERSION', '1.0.5' );
defined( 'OIGNY_LITE_DIR' ) || define( 'OIGNY_LITE_DIR', trailingslashit( get_template_directory() ) );
defined( 'OIGNY_LITE_URI' ) || define( 'OIGNY_LITE_URI', trailingslashit( get_template_directory_uri() ) );

require get_parent_theme_file_path( 'inc/autoload.php' );

Oigny_Lite\Init::instance();
