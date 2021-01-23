<?php
namespace MagnificAddons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

// use DOMDocument;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Aew_Slide_Navigation_Menu_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_slide_navigation_menu';
	}

	public function get_title() {
		return __( 'Slide Navigation Menu', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'ae-category' ];
	}



	// public function get_style_depends() {
	// 	return [ 'advanced-elementor-widgets-style' ];
	// }
	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function _register_controls() {

		// MAIN SECTION
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Menu', 'magnific-addons' ),
			]
		);

			$menus = $this->get_available_menus();

			// menu select
			$this->add_control(
				'mae_slide_menu_name',
				[
					'label' => __( 'Menu', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $menus,
					'default' => !empty($menus) ? array_keys( $menus )[0] : '',
					'render_type' => 'template',
				]
			);





			// menu horizontal align
			$this->add_responsive_control(
				'menu_h_align',
				[
					'label' => __( 'Menu Horizontal Align', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'flex-start',
					'options' => [
						'flex-start' =>  __( 'Left', 'magnific-addons' ),
						'center' =>  __( 'Center', 'magnific-addons' ),
						'flex-end' =>  __( 'Right', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .mae_slide_menu ul' => 'align-items: {{VALUE}};',
					],
				]
			);





			$this->add_responsive_control(
				'vertical_spacing',
				[
					'label' => __( 'Vertical spacing', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
						'unit' => 'px',
					],
					'range' => [
						'em' => [
							'min' => 0,
							'max' => 5,
							'step' => 0.1,
						],
						'px' => [
							'min' => 0,
							'max' => 50,
							'step' => 1,
						],
					],
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .mae_slide_menu li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'render_type' => 'template',
				]
			);




			// submenu icon
         $this->add_control(
            'submenu_icon',
            [
               'label' => __( 'Submenu indicator', 'magnific-addons' ),
               'type' => Controls_Manager::ICONS,
               'default' => [
                  'value' => 'fas fa-chevron-right',
                  'library' => 'fa-solid',
               ],
               'recommended' => [
                  'fa-solid' => [
                     'chevron-right',
                     'chevron-circle-right',
                     'angle-right',
                     'angle-double-right',
                     'caret-right',
                     'caret-square-right',
                     'arrow-right',
                     'long-arrow-right',
                     'long-arrow-alt-right',
                  ],
                  'fa-regular' => [
                     'caret-square-right',
                  ],
               ],
            ]
         );


			// submenu icon
         $this->add_control(
            'back_icon',
            [
               'label' => __( 'Back indicator', 'magnific-addons' ),
               'type' => Controls_Manager::ICONS,
               'default' => [
                  'value' => 'fas fa-chevron-left',
                  'library' => 'fa-solid',
               ],
               'recommended' => [
                  'fa-solid' => [
                     'chevron-left',
                     'chevron-circle-left',
                     'angle-left',
                     'angle-double-left',
                     'caret-left',
                     'caret-square-left',
                     'arrow-left',
                     'long-arrow-left',
                     'long-arrow-alt-left',
                  ],
                  'fa-regular' => [
                     'caret-square-left',
                  ],
               ],
            ]
         );



			// back text
			$this->add_control(
				'back_text',
				[
					'label' => __( 'Back Item Label', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Back', 'magnific-addons' ),
				]
			);


			// back vertical align
			$this->add_responsive_control(
				'back_v_position',
				[
					'label' => __( 'Back Position', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => [
						'top' =>  __( 'Top', 'magnific-addons' ),
						'bottom' =>  __( 'Bottom', 'magnific-addons' ),
					],
					'render_type' => 'template',
				]
			);
			// back horizontal align
			$this->add_responsive_control(
				'back_h_position',
				[
					'label' => __( 'Back Align', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' =>  __( 'Default', 'magnific-addons' ),
						'flex-start' =>  __( 'Left', 'magnific-addons' ),
						'center' =>  __( 'Center', 'magnific-addons' ),
						'flex-end' =>  __( 'Right', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .mae_slide_menu .menu-item-back' => 'align-self: {{VALUE}};',
					],
				]
			);



			// slide animation speed
			$this->add_control(
				'animation_speed',
				[
					'label' => __( 'Animation Speed (ms)', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 150,
					'max' => 5000,
					'step' => 10,
					'default' => 200,
					'selectors' => [
						'{{WRAPPER}} .slide_in_left' => 'animation-duration: {{VALUE}}ms',
						'{{WRAPPER}} .slide_out_left' => 'animation-duration: {{VALUE}}ms',
						'{{WRAPPER}} .slide_in_right' => 'animation-duration: {{VALUE}}ms',
						'{{WRAPPER}} .slide_out_right' => 'animation-duration: {{VALUE}}ms',
					],
					'render_type' => 'template',
				]
			);
		$this->end_controls_section(); // end main












		// STYLE SECTION 
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);








		$this->end_controls_section(); // end style


	}

	public function get_script_depends() {
		return [ 'mae_widgets-script' ];
	}

	protected function render() {

		$available_menus = $this->get_available_menus();
		if (!$available_menus) return;
		

		$settings = $this->get_settings_for_display();


		// prepare menu
		$menu = wp_get_nav_menu_items( $settings['mae_slide_menu_name'] );
		$menu_arr = array();
		foreach($menu as $item) {
			$item_parent = $item->menu_item_parent;
			$menu_arr[$item_parent][] = $item;
		}
		$parent_items = array_unique(array_column($menu, 'menu_item_parent'));


		// prepare submenu indicator content
		ob_start(); ?>
			<span class="submenu-indicator">
				<?php \Elementor\Icons_Manager::render_icon( $settings['submenu_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</span>
		<?php $submenu_indicator = ob_get_clean();


		// prepare back item content
		ob_start(); ?>
			<li class="menu-back-button">
				<span class="back-indicator">
					<?php \Elementor\Icons_Manager::render_icon( $settings['back_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</span>
				<?php echo $settings['back_text'] ?>
			</li>
		<?php $back_item = ob_get_clean();


		// render html
		foreach($menu_arr as $ul => $items) {

			ob_start();

				if ($ul == 0) {
					echo '<ul class="main-menu">';
				} else {
					echo '<ul class="sub-menu" data-parent="' . $ul . '">';
				}

					// back on top
					if($settings['back_v_position'] == 'top' && $ul != 0) {
						echo $back_item;
					}
					

					foreach($items as $li) {

						// check is menu item has children
						$has_children = in_array($li->ID, $parent_items);


						// menu item classes
						if($has_children) {
							echo '<li class="menu-item-has-children menu-item menu-item-' . $li->ID .'" data-sub-menu-id="' . $li->ID . '">';
						} else {
							echo '<li class="menu-item menu-item-' . $li->ID . '">';
						}


						// menu item link
						echo '<a href="' . $li->url . '">' . $li->title . '</a>';


						// submenu indicator
						if($has_children) {
							echo $submenu_indicator;
						}			

						echo '</li>';

					}


					// back on bottom
					if($settings['back_v_position'] == 'bottom' && $ul != 0) {
						echo $back_item;
					}

				echo '</ul>';

			$output[$ul] = ob_get_clean();

		}

		$front_settings = [
			'menu' => str_replace(array("\r\n", "\r", "\n", "\t"), "", $output), // cleanup whitespaces
			'menu_id' => 'mae-slide-menu-' . $this->get_id()
		];

		

		// output
		?>
		
		<div id="mae-slide-menu-<?php echo $this->get_id() ?>" class="mae-slide-menu swiper-container">
			<div class="swiper-wrapper" style="margin-bottom: 40px;">
				<div class="swiper-slide"><?php echo $output[0] ?></div>
			</div>
			<div class="swiper-pagination"></div>
		</div>


				
		<script>

			var snm_<?php echo $this->get_id(); ?>_settings = '<?php echo str_replace("\u0022","\\\\\"",json_encode($front_settings,JSON_HEX_QUOT)); ?>'; // cleanup JSON

		</script>
		
		<?php


	}



}


