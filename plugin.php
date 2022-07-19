<?php
namespace MagnificAddons;

use \Elementor\Core\Settings\Manager as SettingsManager;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Query;

use Elementor\TemplateLibrary\Source_Local;
use ElementorPro\Modules\ThemeBuilder\Documents\Loop;
use ElementorPro\Plugin;
use ElementorPro\Modules\ThemeBuilder\Documents\Theme_Document;
use Elementor\Core\Documents_Manager;
use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;



// RAW PHP CODE PROTECTION 
add_action('init', function() {
	if( isset( $_GET['mae_safe']) || (isset(get_option('mae_settings')['php_safe_mode']['enable_php_safe_mode']) && get_option('mae_settings')['php_safe_mode']['enable_php_safe_mode'] == '1')) {
		define('MAE_PHP_SAFE_MODE', true);
	}
});



// TAXONOMY NAVIGATION TREE WIDGET
if (isset(get_option('mae_settings')['enabled_widgets']['enable_taxonomy_navigation_tree_widget']) && get_option('mae_settings')['enabled_widgets']['enable_taxonomy_navigation_tree_widget'] == '1') {
	new Aew_Taxonomy_Navigation_Tree();
}
class Aew_Taxonomy_Navigation_Tree {
	public function widget_scripts() {
		// wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), array( 'jquery', 'elementor-frontend' ), '', true);
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);

		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/taxonomy-navigation-tree.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aew_Taxonomy_Navigation_Tree_Widget() );
	}
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}

// NAVIGATION MENU TREE WIDGET
if (isset(get_option('mae_settings')['enabled_widgets']['enable_navigation_menu_tree_widget']) && get_option('mae_settings')['enabled_widgets']['enable_navigation_menu_tree_widget'] == '1') {
	new Aew_Navigation_Menu_Tree();
}
class Aew_Navigation_Menu_Tree {
	public function widget_scripts() {
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/navigation-menu-tree.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aew_Navigation_Menu_Tree_Widget() );
	}
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}


// SLIDE NAVIGATION MENU WIDGET
if (isset(get_option('mae_settings')['enabled_widgets']['enable_slide_navigation_menu_widget']) && get_option('mae_settings')['enabled_widgets']['enable_slide_navigation_menu_widget'] == '1') {
	new Aew_Slide_Navigation_Menu();
}
class Aew_Slide_Navigation_Menu {
	public function widget_scripts() {
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		include( MAE_PATH . '/inc/helpers/slides-nav-walker.php' );
		require_once( MAE_PATH . '/widgets/slide-navigation-menu.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aew_Slide_Navigation_Menu_Widget() );
	}
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}


// RAW PHP CODE WIDGET
if (isset(get_option('mae_settings')['enabled_widgets']['enable_raw_php_code_widget']) && get_option('mae_settings')['enabled_widgets']['enable_raw_php_code_widget'] == '1') {
	new Aew_Raw_Php_Code();
}
class Aew_Raw_Php_Code {
	public function widget_scripts() {
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/raw_php_code.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aew_Raw_Php_Code_Widget() );
	}
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}


if (isset(get_option('mae_settings')['enabled_widgets']['enable_raw_php_code_skin']) && get_option('mae_settings')['enabled_widgets']['enable_raw_php_code_skin'] == '1') {
	new Aew_Raw_Php_Code_Skin();
}
class Aew_Raw_Php_Code_Skin {
	public function widget_scripts() {
		// wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		// wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		// wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/raw_php_code_skin.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();
	}
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}



// TAXONOMY SWIPER WIDGET
if (isset(get_option('mae_settings')['enabled_widgets']['enable_taxonomy_swiper_widget']) && get_option('mae_settings')['enabled_widgets']['enable_taxonomy_swiper_widget'] == '1') {
	new Taxonomy_Swiper();
}
class Taxonomy_Swiper {
	public function widget_scripts() {
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/taxonomy-swiper.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aew_Taxonomy_Swiper_Widget() );
	}
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}



// TEMPLATE POPUP BUTTON
if (isset(get_option('mae_settings')['enabled_widgets']['enable_template_popup']) && get_option('mae_settings')['enabled_widgets']['enable_template_popup'] == '1') {
	new Template_Popup();
}
class Template_Popup {
	private $mae_offcanvas_templates = [];
	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widget' ] );
		add_action( 'elementor/frontend/widget/before_render', [ $this, 'before_render' ] );
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'ajax_update_counter' ] );
		add_action( 'wp_footer', [ $this, 'print_templates_in_footer' ] );
		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
	}
	public function widget_scripts() {
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/template-popup.php' );
	}
	public function register_widget() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Aew_Template_Popup_Widget() );
	}
	public function before_render(\Elementor\Element_Base $widget) {
		if ('mae_template_popup' === $widget->get_name()) {
			$settings = $widget->get_active_settings();
			if($settings['type'] == 'offcanvas') {
				$this->mae_offcanvas_templates[] = [
					'widget_id' => $widget->get_id(),
					'template_id' => $settings['template_id'],
					'with_css' => $settings['css_load']
				];
			}
		}
	}
	public function ajax_update_counter($fragments) {
		global $woocommerce;
		$count = $woocommerce->cart->cart_contents_count;
		ob_start(); ?>
			<span class="cart-contents-count" data-counter="<?php echo $count ?>"><?php echo $count ?></span>
		<?php $fragments['span.cart-contents-count'] = ob_get_clean();
		return $fragments;
	}
	public function print_templates_in_footer() {
		if(!empty($this->mae_offcanvas_templates)) {
			foreach($this->mae_offcanvas_templates as $template) {
				echo '<div id="mae-offcanvas-template-' . $template['widget_id'] . '" class="mae-offcanvas-template" data-widget-id="' .  $template['widget_id'] . '">';
				echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template['template_id'], boolval($template['with_css']));
				echo '</div>';
			}
		}		
	}
	public function wpml_widgets_to_translate_filter($widgets) {
		$widgets[ 'mae_template_popup' ] = [
			'conditions' => [ 
				'widgetType' => 'mae_template_popup' 
			],
			'fields'     => [
				[
					'field'       => 'title',
					'type'        => __( 'MAE Toggle Content: Title', 'magnific-addons' ),
					'editor_type' => 'LINE'
				]
			],
		];
		return $widgets;
	}
}

// MINI CART WIDGET
if (isset(get_option('mae_settings')['enabled_widgets']['enable_minicart']) && get_option('mae_settings')['enabled_widgets']['enable_minicart'] == '1') {
	new MAE_MiniCart();
}
class MAE_MiniCart {

	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'ajax_update_minicart' ] );
		add_action( 'wp_ajax_mae_minicart_product_remove', [ $this, 'ajax_product_remove' ] );
		add_action( 'wp_ajax_nopriv_mae_minicart_product_remove', [ $this, 'ajax_product_remove' ] );
		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
	}
	public function widget_scripts() {
		wp_register_script('mae_widgets-script', plugins_url( '/assets/js/mae_widgets-script.js', __FILE__ ), [ 'jquery', 'elementor-frontend' ], MAE_VERSION, true);
		wp_localize_script( 'mae_widgets-script', 'mae_ajax',
			array( 
				'ajax_url' => admin_url( 'admin-ajax.php' ) 
			)
		);
		wp_register_style('mae_widgets-styles', plugins_url( '/assets/css/mae_widgets-styles.css', __FILE__ ));
		wp_enqueue_style('mae_widgets-styles');
	}
	private function include_widgets_files() {
		require_once( MAE_PATH . '/widgets/minicart.php' );

	}
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Mae_MiniCart_Widget() );
	}
	public function ajax_update_minicart($fragments) {
		ob_start(); ?>
			<div class="mini-cart">
				<?php woocommerce_mini_cart(); ?>
			</div>
		<?php $fragments['.elementor-widget-mae_minicart .mini-cart'] = ob_get_clean();
		return $fragments;
	}
	public function ajax_product_remove() {
		ob_start();
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			if($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] ) {
				WC()->cart->remove_cart_item($cart_item_key);
			}
		}
		WC()->cart->calculate_totals();
		WC()->cart->maybe_set_cart_cookies();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();
	
		// Fragments and mini cart are returned
		$data = array(
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
				'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
			)),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);
		// error_log( "data\n" . print_r($data, true) . "\n" );
		wp_send_json( $data );
		die();
	}
	// public function wpml_widgets_to_translate_filter($widgets) {
	// 	$widgets[ 'mae_minicart' ] = [
	// 		'conditions' => [ 
	// 			'widgetType' => 'mae_minicart'
	// 		],
	// 		'fields' => [
	// 			[
	// 				'field'       => 'title',
	// 				'type'        => __( 'MAE Cart Dropdown: Title', 'magnific-addons' ),
	// 				'editor_type' => 'LINE'
	// 			]
	// 		],
	// 	];
	// 	return $widgets;
	// }
}














// enqueue frontend js
add_action( 'elementor/frontend/after_enqueue_scripts', function() {
	wp_enqueue_script( 'mae-editor-frontend', plugin_dir_url( __FILE__ ) . '/assets/js/magnific-addons-frontend.js', [ 'jquery' ], MAE_VERSION );
	// wp_localize_script('frontend', 'MagnificAddonsFrontend', array(
	// 	'mae_plugin_url' => plugin_dir_url( __FILE__ ),
  	// ));
});









// custom html
if (isset(get_option('mae_settings')['custom_html']) && get_option('mae_settings')['custom_html'] == '1') {
	require_once( __DIR__ . '/inc/custom-html/controls.php' );
	Aee_Custom_HTML::instance();
	
	require_once( __DIR__ . '/inc/custom-html/render.php' );
	add_action( 'elementor/widget/render_content', 'MagnificAddons\mae_render_custom_html', 10, 3 );
	add_action('elementor/widget/print_template',  'MagnificAddons\mae_render_js_custom_html', 10, 3 );
}

// column custom width
if (isset(get_option('mae_settings')['custom_column_width']) && get_option('mae_settings')['custom_column_width'] == '1') {
	require_once( __DIR__ . '/inc/column-cusom-width.php' );
	Aee_Columns_Custom_Width_For_Elementor::instance();
}


// responsive customm css
if (isset(get_option('mae_settings')['responsive_custom_css']) && get_option('mae_settings')['responsive_custom_css'] == '1') {
	require_once( __DIR__ . '/inc/responsive-custom-css.php' );
	Aee_Responsive_Custom_CSS::instance();
}

























// element conditional visibility
if (isset(get_option('mae_settings')['conditional_visibility']) && get_option('mae_settings')['conditional_visibility'] == '1') {
	require_once( __DIR__ . '/inc/conditional-visibility/controls.php' );
	new Aee_Сonditional_Visibility();

	// logic
	require_once( __DIR__ . '/inc/conditional-visibility/compare.php' );
	add_filter( 'elementor/frontend/section/should_render', 'MagnificAddons\mae_conditional_visibility_is_display', 10, 3);
   add_filter( 'elementor/frontend/column/should_render', 'MagnificAddons\mae_conditional_visibility_is_display', 10, 3);
   add_filter( 'elementor/frontend/widget/should_render', 'MagnificAddons\mae_conditional_visibility_is_display', 10, 3);

}













// allow to edit _elementor_data custom field
add_filter('elementor/template_library/sources/local/register_post_type_args', function($args) {
	array_push($args['supports'], 'custom-fields');
	return $args;
});
add_filter( 'is_protected_meta', function( $protected, $meta_key, $meta_type ) {
    $allowed = array( '_elementor_data' );
    if( in_array( $meta_key, $allowed ) )
        return false;
    return $protected;
}, 10, 3 );





// TO DO add settings
// ICONS-LIST TEXTAREA
add_action( 'elementor/element/icon-list/section_icon/before_section_end', function( $widget, $args ) {
	
	$control_data = \Elementor\Plugin::instance()->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'icon_list' );
	if ( is_wp_error( $control_data ) ) {
		return;
	}

	$control_data['fields']['text']['type'] = \Elementor\Controls_Manager::TEXTAREA;

	$widget->update_control( 'icon_list', $control_data );

},10 ,2 );






// TO DO add settings
add_action( 'elementor/element/posts/section_query/before_section_end', function( $widget, $args ) {

	$widget->start_injection( [
		'at' => 'after',
		'of' => 'posts_ignore_sticky_posts',
	] );
	$widget->add_control(
		'only_sticky_posts',
		[
			'label' => __( 'MAE Only Sticky Posts', 'magnific-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'magnific-addons' ),
			'label_off' => __( 'Off', 'magnific-addons' ),
			'return_value' => 'yes',
			'default' => '',
			'description' => __( 'Sticky-posts ordering is visible on frontend only.', 'magnific-addons' ),
		]
	);
	$widget->end_injection();

	$widget->add_control(
		'enable_custom_query',
		[
			'label' => __( 'MAE Use Custom Query', 'magnific-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'magnific-addons' ),
			'label_off' => __( 'Off', 'magnific-addons' ),
			'return_value' => 'yes',
			'default' => '',
			'description' => __( 'This will override all previous query settings.', 'magnific-addons' ),
			'separator' => 'before',
		]
	);
	$widget->add_control(
		'custom_query_params',
		[
			'label' => __( 'MAE Custom Query', 'magnific-addons' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
			'rows' => 8,
			'description' => __( 'Insert here WP_Query args in JSON format, you can use this <a href="https://crocoblock.com/freemium/tools/wp-query-generator/" target="blank">generator</a>', 'magnific-addons' ),
			'condition' => [
				'enable_custom_query' => 'yes'
			],
		]
	);

}, 10 , 2 );

add_filter( 'elementor/query/query_args', function( $args, $widget ) {

	// only sticky posts
	if ($widget->get_settings('only_sticky_posts') == 'yes') {
		$args['post__in'] = get_option('sticky_posts');
	}

	// custom query params
	$custom_query_params = json_decode($widget->get_settings('custom_query_params'));
	if ($widget->get_settings('enable_custom_query') == 'yes' && $custom_query_params && is_object($custom_query_params)) {
		$args = $custom_query_params;
	}

	return $args;

}, 10, 2);






























// // this will work for single template condition
// add_action( 'elementor/theme/register_conditions', function( $conditions_manager ) {
// 	class Page_Template_Condition extends \ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base {
// 		public static function get_type() {
// 			return 'singular';
// 		}

// 		public static function get_priority() {
// 			return 100;
// 		}

// 		public function get_name() {
// 			return 'page_template';
// 		}

// 		public function get_label() {
// 			return __( 'Page Template' );
// 		}

// 		public function check( $args ) {
// 			return isset( $args['id'] ) && is_page_template( $args['id'] );
// 		}

// 		protected function register_controls() {
// 			$this->add_control(
// 				'page_template',
// 				[
// 					'section' => 'settings',
// 					'label' => __( 'Page Template' ),
// 					'type' => \Elementor\Controls_Manager::SELECT,
// 					'options' => array_flip( get_page_templates() ),
// 				]
// 			);
// 		}
// 	}

// 	$conditions_manager->get_condition( 'singular' )->register_sub_condition( new Page_Template_Condition() );
// }, 100 );








add_action( 'elementor/theme/register_conditions', function( $conditions_manager ) {
	class MAE_Mobile extends \ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base {
		public static function get_type() {
			return 'singular';
		}
		public static function get_priority() {
			return 100;
		}
		public function get_name() {
			return 'mobile';
		}
		public function get_label() {
			return __( 'Mobile', 'elementor-pro' );
		}
		public function check( $args ) {
			return wp_is_mobile();
		}
	}
	$conditions_manager->get_condition('singular')->register_sub_condition( new MAE_Mobile() );
 },100);

 add_action( 'elementor/theme/register_conditions', function( $conditions_manager ) {
	class MAE_Desktop extends \ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base {
		public static function get_type() {
			return 'singular';
		}
		public static function get_priority() {
			return 20;
		}
		public function get_name() {
			return 'desktop';
		}
		public function get_label() {
			return __( 'Desktop', 'elementor-pro' );
		}
		public function check( $args ) {
			return !wp_is_mobile();
		}
	}
	$conditions_manager->get_condition('singular')->register_sub_condition( new MAE_Desktop() );
 },100);



add_action( 'elementor/theme/register_conditions', function( $conditions_manager ) {
	class MAE_Device_Type  extends \ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base {
		protected $sub_conditions = [];
		public static function get_type() {
			return 'device_type';
		}
		public function get_name() {
			return 'device_type';
		}
		public static function get_priority() {
			return 60;
		}
		public function get_label() {
			return __( 'Device Type', 'ele-custom-skin' );
		}
		public function get_all_label() {
			return __( 'All', 'ele-custom-skin' );
		}
		public function register_sub_conditions() {
			$this->sub_conditions[] = 'desktop';
			$this->sub_conditions[] = 'mobile';
		}
		public function check( $args ) {
			return true;
		}
	}
  	$conditions_manager->get_condition('general')->register_sub_condition( new MAE_Device_Type() );
},100);