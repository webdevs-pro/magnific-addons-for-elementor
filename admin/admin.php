<?php 

/* ----------------------------------------------------------------------------- */
/* Add Menu Page */
/* ----------------------------------------------------------------------------- */ 



define('MAE_APP_API_URL', 'https://plugins.magnificsoft.com/index.php');
define('MAE_PRODUCT_ID', 'MAE');
define('MAE_INSTANCE', str_replace(array ("https://" , "http://"), "", network_site_url()));

include_once(MAE_PATH . 'admin/class.wooslt.php');
include_once(MAE_PATH . 'admin/class.licence.php');
include_once(MAE_PATH . 'admin/class.options.php');
include_once(MAE_PATH . 'admin/class.updater.php');


// function MAE_activated() 
// 	 {

// 	 }

// function MAE_deactivated() 
// 	 {

// 	 }

global $MAE;
$MAE = new MAE();


add_filter('plugin_action_links_' . MAE_BASENAME , function ( $links ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=ae-options' ) . '">' . __('Settings') . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
});


// add `check for updates` or `Activate license` links to plugin meta
add_filter( 'plugin_row_meta', function ($links, $file) {
	if ( $file === 'advanced-elementor-widgets/advanced-elementor-widgets.php' ) {
		// add `view details` link
		if (!isset(get_plugin_updates()[$file])) {
			$links[] = '<a class="thickbox open-plugin-details-modal" href="' . add_query_arg( 'tab', 'plugin-information&plugin=advanced-elementor-widgets&TB_iframe=true&width=772&height=970', admin_url('plugin-install.php')) . '" title="' . __('View details', 'magnific-addons') . '" data-title="Magnific Addons for Elementor">' . __('View details', 'magnific-addons') . '</a>';
		}
		// add `check for updates` / `buy license`
		if (isset(get_site_option('mae_license')['key']) && get_site_option('mae_license')['key'] != '') {
			$links[] = '<a href="' . add_query_arg( 'action', 'mae_check_updates', admin_url('plugins.php')) . '" title="' . __('Check for updates', 'magnific-addons') . '">' . __('Check for updates', 'magnific-addons') . '</a>';
		} else {
			$links[] = '<a href="' . admin_url("admin.php?page=ae-license") . '" title="' . __('Enter license', 'magnific-addons') . '">' . __('Activate license', 'magnific-addons') . '</a> to receive plugin updates';
		}
	}
	return $links;
}, 10, 2 );


// NO LICENSE UPDATE NOTICE
$license_data = get_site_option('mae_license');
if (!isset($license_data['key'])) {
	add_action( 'in_plugin_update_message-advanced-elementor-widgets/advanced-elementor-widgets.php', function ( $plugin_data, $r ) {
		echo '<br />' . sprintf( __('To enable updates, please enter your license key on the <a href="%s">License</a> page. If you don\'t have a licence key, please <a href="%s">buy license</a>.', 'magnific-addons'), admin_url('admin.php?page=ae-license'), 'https://plugins.magnificsoft.com/advanced-elementor-widgets/' );
	}  , 10, 2 );
}



// FORCE CHECK FOR PLUGINS UPDATES
add_action( 'admin_init', function() {
	if( !isset( $_GET['action'] ) || 'mae_check_updates' != $_GET['action'] ) {
		return;
	}
	if( !current_user_can( 'install_plugins' ) ) {
		return;
	}
	set_site_transient( 'update_plugins', null );
	wp_safe_redirect( network_admin_url( 'plugins.php' ) ); 
	exit;
});


function mae_add_plugin_menu() {
	add_menu_page (
		'Advanced Elementor',	// page title 
		'Advanced Elementor', // menu title
		'manage_options',	// capability
		'ae-options',	// menu-slug
		'mae_options',	// function that will render its output
		'dashicons-star-filled', // link to the icon that will be displayed in the sidebar
		99 // position of the menu option
	);
	add_submenu_page( 
		'ae-options', 
		'MAE Settings', 
		'Settings', 
		'manage_options', 
		'ae-options', 
		'mae_options'
	); 

}
add_action('admin_menu', 'mae_add_plugin_menu');

function mae_options() {
		?>
		<div class="wrap">
			<h2><?php echo __('Advanced Elementor Settings', 'magnific-addons'); ?></h2>
			<?php settings_errors(); ?> 


			<form method="post" action="options.php"> 
			<?php
				settings_fields( 'ae-main-settings-group' );
				do_settings_sections( 'ae-options-main' );
				submit_button(); 
			?> 
			</form> 

		</div>
		<?php
}


// MAIN PLUGIN SETTINGS
function mae_initialize_main_options() {  
	register_setting(  
		'ae-main-settings-group',  
		'mae_settings'  
	);
	add_settings_section(  
		'main_section', // ID used to identify this section and with which to register options  
		'Widgets Settings', // Title to be displayed on the administration page  
		'mae_main_section_callback', // Callback used to render the description of the section  
		'ae-options-main' // Page on which to add this section of options  
	);

	add_settings_field (   
		'enabled_widgets',	// ID used to identify the field throughout the theme  
		'Widgets',	// The label to the left of the option interface element  
		'mae_enabled_widgets_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'php_safe_mode',	// ID used to identify the field throughout the theme  
		'Safe Mode',	// The label to the left of the option interface element  
		'mae_php_safe_mode_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'enabled_popups',	// ID used to identify the field throughout the theme  
		'Popups',	// The label to the left of the option interface element  
		'mae_enabled_popups_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'custom_html',	// ID used to identify the field throughout the theme  
		'Custom HTML',	// The label to the left of the option interface element  
		'mae_custom_html_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'advanced_responsive',	// ID used to identify the field throughout the theme  
		'Advanced Responsive',	// The label to the left of the option interface element  
		'mae_advanced_responsive_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'section_fix',	// ID used to identify the field throughout the theme  
		'Section Columns Wrap',	// The label to the left of the option interface element  
		'mae_section_fix_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'custom_column_width',	// ID used to identify the field throughout the theme  
		'Custom Column Width',	// The label to the left of the option interface element  
		'mae_custom_column_width_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'flex_order',	// ID used to identify the field throughout the theme  
		'Flex Order',	// The label to the left of the option interface element  
		'mae_flex_order_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'wrapper_link',	// ID used to identify the field throughout the theme  
		'Wrapper Link',	// The label to the left of the option interface element  
		'mae_wrapper_link_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);

	add_settings_field (   
		'responsive_custom_css',	// ID used to identify the field throughout the theme  
		'Responsive Custom CSS',	// The label to the left of the option interface element  
		'mae_responsive_custom_css_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);
	add_settings_field (   
		'conditional_visibility',	// ID used to identify the field throughout the theme  
		'Сonditional Visibility',	// The label to the left of the option interface element  
		'mae_conditional_visibility_callback',	// The name of the function responsible for rendering the option interface  
		'ae-options-main', // The page on which this option will be displayed  
		'main_section' // The name of the section to which this field belongs  
	);


	// DEFAULTS
	if ( get_option( 'mae_settings' ) === false ) {
		$defaults = array(
			'enabled_widgets' => array(
				'enable_taxonomy_navigation_tree_widget'   => '1',
				'enable_navigation_menu_tree_widget'   => '1',
				'enable_slide_navigation_menu_widget'   => '1',
				'enable_raw_php_code_widget'   => '1',
				'enable_raw_php_code_skin'   => '1',
				'enable_advanced_styling_widget'   => '1',
				'enable_taxonomy_swiper_widget'   => '1',
				'enable_posts_swiper_widget'   => '1',
				'enable_template_popup'   => '1',
				'enable_cart_dropdown'   => '1',
				'enable_lang_dropdown'   => '1',
			),

		);
		//$settings = wp_parse_args( get_option( 'mae_settings', $defaults), $defaults );
		update_option('mae_settings', $defaults);
	}


		// DEFAULTS
		$options = get_option( 'mae_settings' );
		if(!$options) {
			$options = array();
		}
		$updated = false;
		if (!isset($options['enabled_widgets']['enable_taxonomy_navigation_tree_widget'])) {
			$options['enabled_widgets']['enable_taxonomy_navigation_tree_widget'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_navigation_menu_tree_widget'])) {
			$options['enabled_widgets']['enable_navigation_menu_tree_widget'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_slide_navigation_menu_widget'])) {
			$options['enabled_widgets']['enable_slide_navigation_menu_widget'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_raw_php_code_widget'])) {
			$options['enabled_widgets']['enable_raw_php_code_widget'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_raw_php_code_skin'])) {
			$options['enabled_widgets']['enable_raw_php_code_skin'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_advanced_styling_widget'])) {
			$options['enabled_widgets']['enable_advanced_styling_widget'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_advanced_swiper_widget'])) {
			$options['enabled_widgets']['enable_advanced_swiper_widget'] = '1';
			$updated = true;
		}	
		if (!isset($options['enabled_widgets']['enable_taxonomy_swiper_widget'])) {
			$options['enabled_widgets']['enable_taxonomy_swiper_widget'] = '1';
			$updated = true;
		}	
		if (!isset($options['enabled_widgets']['enable_posts_swiper_widget'])) {
			$options['enabled_widgets']['enable_posts_swiper_widget'] = '1';
			$updated = true;
		}	
		if (!isset($options['enabled_widgets']['enable_template_popup'])) {
			$options['enabled_widgets']['enable_template_popup'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_cart_dropdown'])) {
			$options['enabled_widgets']['enable_cart_dropdown'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_lang_dropdown'])) {
			$options['enabled_widgets']['enable_lang_dropdown'] = '1';
			$updated = true;
		}


		if (!isset($options['php_safe_mode']['enable_php_safe_mode'])) {
			$options['php_safe_mode']['enable_php_safe_mode'] = '0';
			$updated = true;
		}	


		if (!isset($options['enabled_popups']['enable_code_popup'])) {
			$options['enabled_popups']['enable_code_popup'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_popups']['enable_wysiwyg_popup'])) {
			$options['enabled_popups']['enable_wysiwyg_popup'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_popups']['enable_textarea_popup'])) {
			$options['enabled_popups']['enable_textarea_popup'] = '1';
			$updated = true;
		}


		if (!isset($options['custom_html'])) {
			$options['custom_html'] = '1';
			$updated = true;
		}
		if (!isset($options['advanced_responsive']['enable_advanced_responsive'])) {
			$options['advanced_responsive']['enable_advanced_responsive'] = '1';
			$updated = true;
		}
		if (!isset($options['section_fix'])) {
			$options['section_fix'] = '1';
			$updated = true;
		}
		if (!isset($options['custom_column_width'])) {
			$options['custom_column_width'] = '1';
			$updated = true;
		}
		if (!isset($options['flex_order'])) {
			$options['flex_order'] = '1';
			$updated = true;
		}
		if (!isset($options['wrapper_link'])) {
			$options['wrapper_link'] = '1';
			$updated = true;
		}
		if (!isset($options['responsive_custom_css'])) {
			$options['responsive_custom_css'] = '1';
			$updated = true;
		}
		if (!isset($options['conditional_visibility'])) {
			$options['conditional_visibility'] = '1';
			$updated = true;
		}

	
		// update only if something changes
		if($updated) {
			update_option('mae_settings', $options);
		}


}
add_action('admin_init', 'mae_initialize_main_options');

function mae_main_section_callback() {  
	//echo '<p>Here you can enable or disable widgets</p>';  
}

function mae_enabled_widgets_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_taxonomy_navigation_tree_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_taxonomy_navigation_tree_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_taxonomy_navigation_tree_widget'], '1'); ?> />
			<?php echo __( 'Taxonomy Navigation Tree', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_navigation_menu_tree_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_navigation_menu_tree_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_navigation_menu_tree_widget']); ?> />
			<?php echo __( 'Navigation Menu Tree', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_slide_navigation_menu_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_slide_navigation_menu_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_slide_navigation_menu_widget']); ?> />
			<?php echo __( 'Slide Navigation Menu', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_raw_php_code_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_raw_php_code_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_raw_php_code_widget']); ?> />
			<?php echo __( 'Raw PHP Code', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_raw_php_code_skin]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_raw_php_code_skin]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_raw_php_code_skin']); ?> />
			<?php echo __( 'Raw PHP Code Posts Widget Skin', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_advanced_styling_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_advanced_styling_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_advanced_styling_widget']); ?> />
			<?php echo __( 'Advanced Styling Widget', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_advanced_swiper_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_advanced_swiper_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_advanced_swiper_widget']); ?> />
			<?php echo __( 'Section Slider', 'magnific-addons' ); ?>
		</label>
		<br>	

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_taxonomy_swiper_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_taxonomy_swiper_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_taxonomy_swiper_widget']); ?> />
			<?php echo __( 'Taxonomy Swiper', 'magnific-addons' ); ?>
		</label>
		<br>	

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_posts_swiper_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_posts_swiper_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_posts_swiper_widget']); ?> />
			<?php echo __( 'Posts Swiper', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_template_popup]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_template_popup]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_template_popup']); ?> />
			<?php echo __( 'Template Popup', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_cart_dropdown]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_cart_dropdown]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_cart_dropdown']); ?> />
			<?php echo __( 'Cart Dropdown', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_lang_dropdown]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_lang_dropdown]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_lang_dropdown']); ?> />
			<?php echo __( 'Lang Dropdown', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}


function mae_php_safe_mode_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[php_safe_mode][enable_php_safe_mode]" value="0" />
			<input type="checkbox" name="mae_settings[php_safe_mode][enable_php_safe_mode]" value="1"<?php checked(get_option('mae_settings')['php_safe_mode']['enable_php_safe_mode'], '1'); ?> />
			<?php echo __( 'Enable Safe Mode', 'magnific-addons' ); ?>
		</label>
		<br>
		
	<?php
}


function mae_enabled_popups_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_popups][enable_code_popup]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_popups][enable_code_popup]" value="1"<?php checked(get_option('mae_settings')['enabled_popups']['enable_code_popup'], '1'); ?> />
			<?php echo __( 'Popup for code control', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_popups][enable_wysiwyg_popup]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_popups][enable_wysiwyg_popup]" value="1"<?php checked(get_option('mae_settings')['enabled_popups']['enable_wysiwyg_popup']); ?> />
			<?php echo __( 'Popup for WYSIWYG control', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_popups][enable_textarea_popup]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_popups][enable_textarea_popup]" value="1"<?php checked(get_option('mae_settings')['enabled_popups']['enable_textarea_popup']); ?> />
			<?php echo __( 'Popup for textarea control', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}






function mae_custom_html_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[custom_html]]" value="0" />
			<input type="checkbox" name="mae_settings[custom_html]]" value="1"<?php checked(get_option('mae_settings')['custom_html'], '1'); ?> />
			<?php echo __( 'Custom HTML', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}

function mae_advanced_responsive_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[advanced_responsive][enable_advanced_responsive]" value="0" />
			<input type="checkbox" name="mae_settings[advanced_responsive][enable_advanced_responsive]" value="1"<?php checked(get_option('mae_settings')['advanced_responsive']['enable_advanced_responsive'], '1'); ?> />
			<?php echo __( 'Advanced Responsive Mode', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}

function mae_section_fix_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[section_fix]" value="0" />
			<input type="checkbox" name="mae_settings[section_fix]" value="1"<?php checked(get_option('mae_settings')['section_fix'], '1'); ?> />
			<?php echo __( 'Section Columns Wrap', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}

function mae_custom_column_width_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[custom_column_width]" value="0" />
			<input type="checkbox" name="mae_settings[custom_column_width]" value="1"<?php checked(get_option('mae_settings')['custom_column_width'], '1'); ?> />
			<?php echo __( 'Custom Column Width', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}
function mae_flex_order_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[flex_order]" value="0" />
			<input type="checkbox" name="mae_settings[flex_order]" value="1"<?php checked(get_option('mae_settings')['flex_order'], '1'); ?> />
			<?php echo __( 'Flex Order', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}
function mae_wrapper_link_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[wrapper_link]" value="0" />
			<input type="checkbox" name="mae_settings[wrapper_link]" value="1"<?php checked(get_option('mae_settings')['wrapper_link'], '1'); ?> />
			<?php echo __( 'Wrapper Link', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}
function mae_responsive_custom_css_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[responsive_custom_css]" value="0" />
			<input type="checkbox" name="mae_settings[responsive_custom_css]" value="1"<?php checked(get_option('mae_settings')['responsive_custom_css'], '1'); ?> />
			<?php echo __( 'Responsive Custom CSS', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}
function mae_conditional_visibility_callback($args) {  
	?>
		<label style="display: block">
			<input type="hidden" name="mae_settings[conditional_visibility]" value="0" />
			<input type="checkbox" name="mae_settings[conditional_visibility]" value="1"<?php checked(get_option('mae_settings')['conditional_visibility'], '1'); ?> />
			<?php echo __( 'Сonditional Visibility', 'magnific-addons' ); ?>
		</label>
		<br>
	<?php
}













