<?php 




add_filter('plugin_action_links_' . MAE_BASENAME , function ( $links ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=mae-options' ) . '">' . __('Settings', 'magnific-addons') . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
});



function mae_add_plugin_menu() {
	add_menu_page (
		'Magnific Addons',	// page title 
		'Magnific Addons', // menu title
		'manage_options',	// capability
		'mae-options',	// menu-slug
		'mae_options',	// function that will render its output
		'dashicons-star-filled', // link to the icon that will be displayed in the sidebar
		99 // position of the menu option
	);
	add_submenu_page( 
		'mae-options', 
		'MAE Settings', 
		'Settings', 
		'manage_options', 
		'mae-options', 
		'mae_options'
	); 

}
add_action('admin_menu', 'mae_add_plugin_menu');

function mae_options() {
		?>
		<div class="wrap">
			<h2><?php echo __('Magnific Addons for Elementor Settings', 'magnific-addons'); ?></h2>
			<?php settings_errors(); ?> 


			<form method="post" action="options.php"> 
			<?php
				settings_fields( 'mae-main-settings-group' );
				do_settings_sections( 'mae-options-main' );
				submit_button(); 
			?> 
			</form> 

		</div>
		<?php
}


// MAIN PLUGIN SETTINGS
function mae_initialize_main_options() {  
	register_setting(  
		'mae-main-settings-group',  
		'mae_settings'  
	);
	add_settings_section(  
		'main_section',
		'Widgets Settings',
		'mae_main_section_callback',
		'mae-options-main'
	);

	add_settings_field (   
		'enabled_widgets',	   
		'Widgets',	   
		'mae_enabled_widgets_callback',	   
		'mae-options-main',    
		'main_section'    
	);

	add_settings_field (   
		'php_safe_mode',	   
		'Safe Mode',	   
		'mae_php_safe_mode_callback',	   
		'mae-options-main',    
		'main_section'    
	);







	add_settings_field (   
		'conditional_visibility',	   
		'Сonditional Visibility',	   
		'mae_conditional_visibility_callback',	   
		'mae-options-main',    
		'main_section'    
	);


	// DEFAULTS
	if ( get_option( 'mae_settings' ) === false ) {
		$defaults = array(
			'enabled_widgets' => array(
				'enable_taxonomy_navigation_tree_widget'   => '1',
				'enable_navigation_menu_tree_widget'   => '1',
				'enable_slide_navigation_menu_widget'   => '1',
				'enable_raw_php_code_widget'   => '1',
				'enable_taxonomy_swiper_widget'   => '1',
				'enable_template_popup'   => '1',
				'enable_minicart'   => '1',
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
		if (!isset($options['enabled_widgets']['enable_taxonomy_swiper_widget'])) {
			$options['enabled_widgets']['enable_taxonomy_swiper_widget'] = '1';
			$updated = true;
		}	
		if (!isset($options['enabled_widgets']['enable_template_popup'])) {
			$options['enabled_widgets']['enable_template_popup'] = '1';
			$updated = true;
		}
		if (!isset($options['enabled_widgets']['enable_minicart'])) {
			$options['enabled_widgets']['enable_minicart'] = '1';
			$updated = true;
		}


		if (!isset($options['php_safe_mode']['enable_php_safe_mode'])) {
			$options['php_safe_mode']['enable_php_safe_mode'] = '0';
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
			<input type="hidden" name="mae_settings[enabled_widgets][enable_taxonomy_swiper_widget]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_taxonomy_swiper_widget]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_taxonomy_swiper_widget']); ?> />
			<?php echo __( 'Taxonomy Swiper', 'magnific-addons' ); ?>
		</label>
		<br>	

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_template_popup]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_template_popup]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_template_popup']); ?> />
			<?php echo __( 'Template Popup', 'magnific-addons' ); ?>
		</label>
		<br>

		<label style="display: block">
			<input type="hidden" name="mae_settings[enabled_widgets][enable_minicart]" value="0" />
			<input type="checkbox" name="mae_settings[enabled_widgets][enable_minicart]" value="1"<?php checked(get_option('mae_settings')['enabled_widgets']['enable_minicart']); ?> />
			<?php echo __( 'Mini Cart', 'magnific-addons' ); ?>
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














