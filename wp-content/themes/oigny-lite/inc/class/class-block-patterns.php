<?php
/**
 * Block Pattern Class
 *
 * @author Jegstudio
 * @package oigny-lite
 */

namespace Oigny_Lite;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_Block_Pattern_Categories_Registry;

/**
 * Init Class
 *
 * @package oigny-lite
 */
class Block_Patterns {

	/**
	 * Instance variable
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @return BlockPatterns
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->register_block_patterns();
		$this->register_synced_patterns();
	}

	/**
	 * Register Block Patterns
	 */
	private function register_block_patterns() {
		$block_pattern_categories = array(
			'oigny-lite-core' => array( 'label' => __( 'Oigny Lite Core Patterns', 'oigny-lite' ) ),
		);

		if ( defined( 'GUTENVERSE' ) ) {
			$block_pattern_categories['oigny-lite-gutenverse'] = array( 'label' => __( 'Oigny Lite Gutenverse Patterns', 'oigny-lite' ) );
			$block_pattern_categories['oigny-lite-pro'] = array( 'label' => __( 'Oigny Lite Gutenverse PRO Patterns', 'oigny-lite' ) );
		}

		$block_pattern_categories = apply_filters( 'oigny-lite_block_pattern_categories', $block_pattern_categories );

		foreach ( $block_pattern_categories as $name => $properties ) {
			if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
				register_block_pattern_category( $name, $properties );
			}
		}

		$block_patterns = array(
            'oigny-lite-home-core-hero',			'oigny-lite-home-core-about',			'oigny-lite-home-core-service',			'oigny-lite-home-core-feature',			'oigny-lite-home-core-project',			'oigny-lite-home-core-blog',			'oigny-lite-home-core-cta',			'oigny-lite-single-core-hero',			'oigny-lite-archive-core-hero',			'oigny-lite-index-core-hero',			'oigny-lite-404-core-hero',			'oigny-lite-page-core-hero',			'oigny-lite-search-core-hero',
		);

		if ( defined( 'GUTENVERSE' ) ) {
            $block_patterns[] = 'oigny-lite-home-gutenverse-hero';			$block_patterns[] = 'oigny-lite-home-gutenverse-about';			$block_patterns[] = 'oigny-lite-home-gutenverse-services';			$block_patterns[] = 'oigny-lite-home-gutenverse-why-choose';			$block_patterns[] = 'oigny-lite-home-gutenverse-projects';			$block_patterns[] = 'oigny-lite-home-gutenverse-blog';			$block_patterns[] = 'oigny-lite-gutenverse-cta';			$block_patterns[] = 'oigny-lite-gutenverse-header';			$block_patterns[] = 'oigny-lite-gutenverse-footer';			$block_patterns[] = 'oigny-lite-projects-gutenverse-hero';			$block_patterns[] = 'oigny-lite-projects-gutenverse-projects';			$block_patterns[] = 'oigny-lite-projects-gutenverse-feature';			$block_patterns[] = 'oigny-lite-projects-gutenverse-testimoni';			$block_patterns[] = 'oigny-lite-gutenverse-cta';			$block_patterns[] = 'oigny-lite-contact-gutenverse-hero';			$block_patterns[] = 'oigny-lite-contact-gutenverse-contact';			$block_patterns[] = 'oigny-lite-contact-gutenverse-faq';			$block_patterns[] = 'oigny-lite-blog-gutenverse-hero';			$block_patterns[] = 'oigny-lite-blog-gutenverse-post-block';			$block_patterns[] = 'oigny-lite-blog-gutenverse-newsletter';			$block_patterns[] = 'oigny-lite-blog-gutenverse-list';			$block_patterns[] = 'oigny-lite-404-gutenverse-hero';			$block_patterns[] = 'oigny-lite-index-gutenverse-hero';			$block_patterns[] = 'oigny-lite-page-gutenverse-hero';			$block_patterns[] = 'oigny-lite-single-post-gutenverse-hero';			$block_patterns[] = 'oigny-lite-single-post-gutenverse-content';			$block_patterns[] = 'oigny-lite-archive-gutenverse-hero';			$block_patterns[] = 'oigny-lite-search-gutenverse-hero';			$block_patterns[] = 'oigny-lite-about-gutenverse-hero';			$block_patterns[] = 'oigny-lite-home-gutenverse-about';			$block_patterns[] = 'oigny-lite-about-gutenverse-feature';			$block_patterns[] = 'oigny-lite-about-gutenverse-stats';			$block_patterns[] = 'oigny-lite-about-gutenverse-team';
            
		}

		$block_patterns = apply_filters( 'oigny-lite_block_patterns', $block_patterns );
		$pattern_list   = get_option( 'oigny-lite_synced_pattern_imported', false );
		if ( ! $pattern_list ) {
			$pattern_list = array();
		}

		if ( function_exists( 'register_block_pattern' ) ) {
			foreach ( $block_patterns as $block_pattern ) {
				$pattern_file = get_theme_file_path( '/inc/patterns/' . $block_pattern . '.php' );
				$pattern_data = require $pattern_file;

				if ( (bool) $pattern_data['is_sync'] ) {
					$post = get_page_by_path( $block_pattern . '-synced', OBJECT, 'wp_block' );
					/**Download Image */
					$content = wp_slash( $pattern_data['content'] );
					if ( $pattern_data['images'] ) {
						$images = json_decode( $pattern_data['images'] );
						foreach ( $images as $key => $image ) {
							$url  = $image->image_url;
							$data = Helper::check_image_exist( $url );
							if ( ! $data ) {
								$data = Helper::handle_file( $url );
							}
							$content = str_replace( $url, $data['url'], $content );
						}
					}
					if ( empty( $post ) ) {
						$post_id = wp_insert_post(
							array(
								'post_name'    => $block_pattern . '-synced',
								'post_title'   => $pattern_data['title'],
								'post_content' => $content,
								'post_status'  => 'publish',
								'post_author'  => 1,
								'post_type'    => 'wp_block',
							)
						);
						if ( ! is_wp_error( $post_id ) ) {
							$pattern_category = $pattern_data['categories'];
							foreach( $pattern_category as $category ){
								wp_set_object_terms( $post_id, $category, 'wp_pattern_category' );
							}
						}
						$pattern_data['content']  = '<!-- wp:block {"ref":' . $post_id . '} /-->';
						$pattern_data['inserter'] = false;
						$pattern_data['slug']     = $block_pattern;

						$pattern_list[] = $pattern_data;
					}
				} else {
					register_block_pattern(
						'oigny-lite/' . $block_pattern,
						require $pattern_file
					);
				}
			}
			update_option( 'oigny-lite_synced_pattern_imported', $pattern_list );
		}
	}

	/**
	 * Register Synced Patterns
	 */
	 private function register_synced_patterns() {
		$patterns = get_option( 'oigny-lite_synced_pattern_imported' );

		 foreach ( $patterns as $block_pattern ) {
			 register_block_pattern(
				'oigny-lite/' . $block_pattern['slug'],
				$block_pattern
			);
		 }
	 }
}
