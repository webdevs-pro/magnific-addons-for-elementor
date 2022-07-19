<?php
/**
* Plugin Name: Magnific Addons for Elementor
* Description: This plugin is addon for Elementor Page Builder plugin with range of great features and widgets
* Plugin URI: https://plugins.magnificsoft.com/magnific-addons/
* Version: 1.0
* Author: MagnificSoft
* Author URI: https://plugins.magnificsoft.com/
* License: GPL 3.0
* Text Domain: magnific-addons
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! function_exists('get_plugin_data') ){
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
define('MAE_VERSION', get_plugin_data( __FILE__ )['Version']);
define('MAE_PATH', plugin_dir_path(__FILE__));
define('MAE_URL', plugins_url('', __FILE__));
define('MAE_BASENAME', plugin_basename(__FILE__));

if (is_admin()) {
	include( plugin_dir_path( __FILE__ ) . 'admin/admin.php');
}

final class Magnific_Addons {

	const MINIMUM_ELEMENTOR_VERSION = '3.0.2';

	const MINIMUM_PHP_VERSION = '5.6';

	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function i18n() {
		load_plugin_textdomain( 'magnific-addons', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
	}

	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
		//include( plugin_dir_path( __FILE__ ) . 'widgets.php');

		// register web devs category
		add_action( 'elementor/elements/categories_registered', function($elements_manager) {
			$elements_manager->add_category(
				'mae-widgets',
				[
					'title' => __( 'Magnific Widgets', 'magnific-addons' ),
					'icon' => 'fa fa-plug',
				]
			);
		});

	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'magnific-addons' ),
			'<strong>' . esc_html__( 'Magnific Addons for Elementor', 'magnific-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'magnific-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'magnific-addons' ),
			'<strong>' . esc_html__( 'Magnific Addons for Elementor', 'magnific-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'magnific-addons' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'magnific-addons' ),
			'<strong>' . esc_html__( 'Magnific Addons for Elementor', 'magnific-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'magnific-addons' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate Magnific_Addons.
new Magnific_Addons();


// updates
require 'plugin-update-checker/plugin-update-checker.php';
$maeUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/magnific-addons-for-elementor',
	__FILE__,
	'magnific-addons-for-elementor'
);

//Set the branch that contains the stable release.
$maeUpdateChecker->setBranch( 'main' );