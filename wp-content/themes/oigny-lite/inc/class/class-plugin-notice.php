<?php
/**
 * Init Configuration
 *
 * @author Jegstudio
 * @package oigny-lite
 */

namespace Oigny_Lite;

use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Notice Class
 *
 * @package oigny-lite
 */
class Plugin_Notice {

	/**
	 * Instance variable
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @return Init
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
		$this->load_hooks();
	}

	/**
	 * Load initial hooks.
	 */
	private function load_hooks() {
		add_action( 'admin_notices', array( $this, 'notice_install_plugin' ) );
	}

	/**
	 * Show notification to install Gutenverse Plugin.
	 */
	public function notice_install_plugin() {
		// Skip if gutenverse block activated.
		if ( defined( 'GUTENVERSE' ) ) {
			return;
		}

		// Skip if gutenverse pro activated.
		if ( defined( 'GUTENVERSE_PRO' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'themes.php' === $screen->parent_file && 'appearance_page_oigny-lite-dashboard' === $screen->id ) {
			return;
		}

		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		if ( 'true' === get_user_meta( get_current_user_id(), 'gutenverse_install_notice', true ) ) {
			return;
		}

        $active_plugins = get_option( 'active_plugins' );
		$plugins = array();
		foreach( $active_plugins as $active ) {
			$plugins[] = explode( '/', $active)[0];
		}
		$all_plugin = get_plugins();
		$plugins_required    = array(
            array(
					'slug'       		=> 'gutenverse',
					'title'      		=> 'Gutenverse',
					'short_desc' 		=> 'GUTENVERSE – GUTENBERG BLOCKS AND WEBSITE BUILDER FOR SITE EDITOR, TEMPLATE LIBRARY, POPUP BUILDER, ADVANCED ANIMATION EFFECTS, 45+ FREE USER-FRIENDLY BLOCKS',
					'active'    		=> in_array( 'gutenverse', $plugins, true ),
					'installed'  		=> $this->is_installed( 'gutenverse' ),
					'icons'      		=> array (
  '1x' => 'https://ps.w.org/gutenverse/assets/icon-128x128.gif?rev=3132408',
  '2x' => 'https://ps.w.org/gutenverse/assets/icon-256x256.gif?rev=3132408',
),
					'download_url'      => '',
				),
				array(
					'slug'       		=> 'gutenverse-form',
					'title'      		=> 'Gutenverse Form',
					'short_desc' 		=> 'GUTENVERSE FORM – FORM BUILDER FOR GUTENBERG BLOCK EDITOR, MULTI-STEP FORMS, CONDITIONAL LOGIC, PAYMENT, CALCULATION, 15+ FREE USER-FRIENDLY FORM BLOCKS',
					'active'    		=> in_array( 'gutenverse-form', $plugins, true ),
					'installed'  		=> $this->is_installed( 'gutenverse-form' ),
					'icons'      		=> array (
  '1x' => 'https://ps.w.org/gutenverse-form/assets/icon-128x128.png?rev=3135966',
),
					'download_url'      => '',
				)
        );
		$actions    = array();

		foreach ( $plugins_required as $plugin ) {
			$slug   = $plugin['slug'];
			$path   = "$slug/$slug.php";
			$active = is_plugin_active( $path );

			if ( isset( $all_plugin[ $path ] ) ) {
				if ( $active ) {
					$actions[ $slug ] = 'active';
				} else {
					$actions[ $slug ] = 'inactive';
				}
			} else {
				$actions[ $slug ] = '';
			}
		}

		?>
		<style>
            .install-gutenverse-plugin-notice {
                border: 1px solid #E6E6EF;
                position: relative;
                overflow: hidden;
                padding: 0 !important;
                margin-bottom: 30px !important;
                background: url( <?php echo esc_url( OIGNY_LITE_URI . '/assets/img/background-banner.png' ); ?> );
                background-size: cover;
                background-position: center;
            }

            .install-gutenverse-plugin-notice .gutenverse-notice-content {
                display: flex;
                align-items: center;
                position: relative;
            }

            .gutenverse-notice-text, .gutenverse-notice-image {
                width: 50%;
            }

            .gutenverse-notice-text {
                padding: 40px 0 40px 40px;
                position: relative;
                z-index: 2;
            }

            .install-gutenverse-plugin-notice img {
                max-height: 100%;
                display: flex;
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
            }

            .install-gutenverse-plugin-notice:after {
                content: "";
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 5px;
                display: block;
                background: linear-gradient(to bottom, #68E4F4, #4569FF, #F045FF);
            }

            .install-gutenverse-plugin-notice .notice-dismiss {
                top: 20px;
                right: 20px;
                padding: 0;
                background: white;
                border-radius: 6px;
            }

            .install-gutenverse-plugin-notice .notice-dismiss:before {
                content: "\f335";
                font-size: 17px;
                width: 25px;
                height: 25px;
                line-height: 25px;
                border: 1px solid #E6E6EF;
                border-radius: 3px;
            }

            .install-gutenverse-plugin-notice h3 {
                margin-top: 5px;
                margin-bottom: 15px;
                font-weight: 600;
                font-size: 25px;
                line-height: 1.4em;
            }

            .install-gutenverse-plugin-notice h3 span {
                font-weight: 700;
                background-clip: text !important;
                -webkit-text-fill-color: transparent;
                background: linear-gradient(80deg, rgba(208, 77, 255, 1) 0%,rgba(69, 105, 255, 1) 48.8%,rgba(104, 228, 244, 1) 100%);
            }

            .install-gutenverse-plugin-notice p {
                font-size: 13px;
                font-weight: 400;
                margin: 5px 100px 20px 0 !important;
            }

            .install-gutenverse-plugin-notice .gutenverse-bottom {
                display: flex;
                align-items: center;
                margin-top: 30px;
            }

            .install-gutenverse-plugin-notice a {
                text-decoration: none;
                margin-right: 20px;
            }

            .install-gutenverse-plugin-notice a.gutenverse-button {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", serif;
                text-decoration: none;
                cursor: pointer;
                font-size: 12px;
                line-height: 18px;
                border-radius: 5px;
                background: #3B57F7;
                color: #fff;
                padding: 10px 15px;
                font-weight: 500;
                background: linear-gradient(to left, #68E4F4, #4569FF, #F045FF);
                transition: transform 0.5s ease, color 0.5s ease;
            }

            .install-gutenverse-plugin-notice a.gutenverse-button:hover {
                color: hsla(0, 0%, 100%, .749);
                transform: scale(.94);
            }

            #gutenverse-install-plugin.loader:after {
                display: block;
                content: "";
                border: 5px solid white;
                border-radius: 50%;
                border-top: 5px solid rgba(255, 255, 255, 0);
                width: 10px;
                height: 10px;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
            }

            @-webkit-keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }

            @media screen and (max-width: 1024px) {
                .gutenverse-notice-text {
                    width: 100%;
                }

                .gutenverse-notice-image {
                    display: none;
                }
            }
        </style>
		<script>
        var promises = [];
        var actions = <?php echo wp_json_encode( $actions ); ?>;

        function sequenceInstall (plugins, index = 0) {
            if (plugins[index]) {
                var plugin = plugins[index];

                switch (actions[plugin?.slug]) {
                    case 'active':
                        break;
                    case 'inactive':
                        var path = plugin?.slug + '/' + plugin?.slug;
                        promises.push(
                            wp.apiFetch({
                                path: 'wp/v2/plugins/plugin?plugin=' + path,									
                                method: 'POST',
                                data: {
                                    status: 'active'
                                }
                            }).then(() => {
                                sequenceInstall(plugins, index + 1);
                            }).catch((error) => {
                            })
                        );
                        break;
                    default:
                        promises.push(
                            wp.apiFetch({
                                path: 'wp/v2/plugins',
                                method: 'POST',
                                data: {
                                    slug: plugin?.slug,
                                    status: 'active'
                                }
                            }).then(() => {
                                sequenceInstall(plugins, index + 1);
                            }).catch((error) => {
                            })
                        );
                        break;
                }
            }

            return;
        };

        jQuery( function( $ ) {
            $( 'div.notice.install-gutenverse-plugin-notice' ).on( 'click', 'button.notice-dismiss', function( event ) {
                event.preventDefault();
                $.post( ajaxurl, {
                    action: 'oigny-lite_set_admin_notice_viewed',
                    nonce: '<?php echo esc_html( wp_create_nonce( 'oigny-lite_admin_notice' ) ); ?>',
                } );
            } );

            $('#gutenverse-install-plugin').on('click', function(e) {
                var hasFinishClass = $(this).hasClass('finished');
                var hasLoaderClass = $(this).hasClass('loader');

                if(!hasFinishClass) {
                    e.preventDefault();
                }

                if(!hasLoaderClass && !hasFinishClass) {
                    promises = [];
                    var plugins = <?php echo wp_json_encode( $plugins_required ); ?>;
                    $(this).addClass('loader').text('');

                    sequenceInstall(plugins);
                    Promise.all(promises).then(() => {						
                        window.location.reload();
                        $(this).removeClass('loader').addClass('finished').text('All is Done!');
                    });
                }
            });
        } );
        </script>
		<div class="notice is-dismissible install-gutenverse-plugin-notice">
            <div class="gutenverse-notice-inner">
                <div class="gutenverse-notice-content">
                    <div class="gutenverse-notice-text">
                        <h3><?php esc_html_e( 'Take Your Website To New Height with', 'oigny-lite' ); ?> <span>Gutenverse!</span></h3> 
                        <p><?php esc_html_e( 'Oigny Lite theme work best with Gutenverse plugin. By installing Gutenverse plugin you may access Oigny Lite templates built with Gutenverse and get access to more than 40 free blocks, hundred free Layout and Section.', 'oigny-lite' ); ?></p>
                        <div class="gutenverse-bottom">
                            <a class="gutenverse-button" id="gutenverse-install-plugin" href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'themes.php?page=oigny-lite-dashboard' ), 'install-plugin_gutenverse' ) ); ?>">
                                <?php echo esc_html( __( 'Install Required Plugins', 'oigny-lite' ) ); ?>
                            </a>
                        </div>
                    </div>
                    <div class="gutenverse-notice-image">
                        <img src="<?php echo esc_url( OIGNY_LITE_URI . '/assets/img/banner-install-gutenverse.png' ); ?>"/>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
    
    /**
	 * Check if plugin is installed.
	 *
	 * @param string $plugin_slug plugin slug.
	 * 
	 * @return boolean
	 */
	public function is_installed( $plugin_slug ) {
		$all_plugins = get_plugins();
		foreach ( $all_plugins as $plugin_file => $plugin_data ) {
			$plugin_dir = dirname($plugin_file);

			if ($plugin_dir === $plugin_slug) {
				return true;
			}
		}

		return false;
	}
}
