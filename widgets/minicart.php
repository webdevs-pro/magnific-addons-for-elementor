<?php
namespace MagnificAddons;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Base\Document;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;
// use \Elementor\Group_Control_Border;
use \Elementor\Core\Schemes\Typography;
// use \Elementor\Group_Control_Text_Shadow;
// use \Elementor\Group_Control_Box_Shadow;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Mae_MiniCart_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_minicart';
	}

	public function get_title() {
		return __( 'Mini Cart', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-lightbox';
	}

	public function get_categories() {
		return [ 'mae-widgets' ];
	}


	// public function get_style_depends() {
	// 	return [ 'advanced-elementor-widgets-style' ];
	// }

	protected function register_controls() {


		// TOGGLE SECTION
		$this->start_controls_section(
			'section_main',
			[
				'label' => __( 'Button', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			
      $this->end_controls_section(); 









      
	}

	public function get_script_depends() {
		return [ 'mae_widgets-script' ];
	}

   protected function render() {

		$settings = $this->get_settings_for_display();
		

		?>
			<div class="mini-cart">
				<?php woocommerce_mini_cart(); ?>
			</div>

		<?php

   }


}






