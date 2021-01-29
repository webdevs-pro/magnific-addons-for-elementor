<?php
namespace MagnificAddons;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Box_Shadow;

use DOMDocument;

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
		return [ 'mae-widgets' ];
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








			// MENU HEIGHT
			$this->add_control(
				'mae_slide_menu_hr_menu_height',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			// height type
			$this->add_control(
				'mae_slide_menu_height',
				[
					'label' => __( 'Menu Height', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' =>  __( 'Default', 'magnific-addons' ),
						'by-higest' =>  __( 'By Higest Element', 'magnific-addons' ),
						'custom' =>  __( 'Custom', 'magnific-addons' ),
						'auto' =>  __( 'Auto', 'magnific-addons' ),
					],
					'prefix_class' => 'mae-menu-height-',
					'render_type' => 'template',
				]
			);
			// menu custom height
			$this->add_responsive_control(
				'mae_slide_menu_custom_height',
				[
					'label' => __( 'Menu Custom Height', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => '',
						'unit' => 'px',
					],
					'range' => [
						'px' => [
							'min' => 50,
							'max' => 1000,
							'step' => 1,
						],
					],
					'size_units' => [ 'px', 'vh', ],
					'selectors' => [
						'{{WRAPPER}} .mae_slide_menu' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'mae_slide_menu_height' => 'custom',
					],
					'render_type' => 'template',
				]
			);








			// MENU SCROLL
			$scrollbar_options_condition = [
				'relation' => 'or',
				'terms' => [
					[
						'relation' => 'and',
						'terms' => [
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'default',
							],
							[
								'name' => 'mae_slide_menu_scroll',
								'operator' => '==',
								'value' => 'custom',
							],
						]
					],
					[
						'relation' => 'and',
						'terms' => [
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'custom',
							],
							[
								'name' => 'mae_slide_menu_scroll',
								'operator' => '==',
								'value' => 'custom',
							],
						]
					],
				]
			];
			$this->add_control(
				'mae_slide_menu_hr_scroll',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'default',
							],
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'custom',
							],
						]
					],
				]
			);
			// scroll type
			$this->add_control(
				'mae_slide_menu_scroll',
				[
					'label' => __( 'Menu Scrollbar', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' =>  __( 'Default', 'magnific-addons' ),
						'custom' =>  __( 'Custom', 'magnific-addons' ),
					],
					'prefix_class' => 'mae-menu-scroll-',
					'render_type' => 'template',
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'default',
							],
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'custom',
							],
						]
					],
				]
			);
			// // scrollbar vivsible only on hover
			// $this->add_control(
			// 	'mae_slide_menu_scroll_visible_hover',
			// 	[
			// 		'label' => __( 'Visible only on hover', 'magnific-addons' ),
			// 		'type' => \Elementor\Controls_Manager::SWITCHER,
			// 		'label_on' => __( 'Yes', 'magnific-addons' ),
			// 		'label_off' => __( 'No', 'magnific-addons' ),
			// 		'return_value' => 'yes',
			// 		'default' => 'no',
			// 		'prefix_class' => 'mae_scrollbar_on_hover-',
			// 	]
			// );
			// custom scrollbar side
			$this->add_control(
				'mae_slide_menu_custom_scroll_side',
				[
					'label' => __( 'Scrollbar Side', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'left',
					'options' => [
						'left' =>  __( 'Left', 'magnific-addons' ),
						'right' =>  __( 'Right', 'magnific-addons' ),
					],
					'render_type' => 'template',
					'conditions' => $scrollbar_options_condition,
					'prefix_class' => 'mae_scrollbar-',
				]
			);
			// custom scrollbar content indent
			$this->add_responsive_control(
				'mae_slide_menu_custom_scroll_indent',
				[
					'label' => __( 'Menu Indent', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 12,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mae_slide_menu li' => 'margin-{{mae_slide_menu_custom_scroll_side.VALUE}}: {{SIZE}}{{UNIT}};',
					],
					'conditions' => $scrollbar_options_condition,
				]
			);
			// custom scrollbar position left
			$this->add_responsive_control(
				'mae_slide_menu_custom_scroll_position_left',
				[
					'label' => __( 'Scrollbar Position', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 6,
					],
					'range' => [
						'px' => [
							'min' => -50,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mae_custom_scrollbar' => 'left: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'mae_slide_menu_height',
										'operator' => '==',
										'value' => 'default',
									],
									[
										'name' => 'mae_slide_menu_scroll',
										'operator' => '==',
										'value' => 'custom',
									],
									[
										'name' => 'mae_slide_menu_custom_scroll_side',
										'operator' => '==',
										'value' => 'left',
									],
								]
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'mae_slide_menu_height',
										'operator' => '==',
										'value' => 'custom',
									],
									[
										'name' => 'mae_slide_menu_scroll',
										'operator' => '==',
										'value' => 'custom',
									],
									[
										'name' => 'mae_slide_menu_custom_scroll_side',
										'operator' => '==',
										'value' => 'left',
									],
								]
							],
						]
					],
				]
			);
			// custom scrollbar position right
			$this->add_responsive_control(
				'mae_slide_menu_custom_scroll_position_right',
				[
					'label' => __( 'Scrollbar Position', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
					],
					'range' => [
						'px' => [
							'min' => -50,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mae_custom_scrollbar' => 'right: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'mae_slide_menu_height',
										'operator' => '==',
										'value' => 'default',
									],
									[
										'name' => 'mae_slide_menu_scroll',
										'operator' => '==',
										'value' => 'custom',
									],
									[
										'name' => 'mae_slide_menu_custom_scroll_side',
										'operator' => '==',
										'value' => 'right',
									],
								]
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'mae_slide_menu_height',
										'operator' => '==',
										'value' => 'custom',
									],
									[
										'name' => 'mae_slide_menu_scroll',
										'operator' => '==',
										'value' => 'custom',
									],
									[
										'name' => 'mae_slide_menu_custom_scroll_side',
										'operator' => '==',
										'value' => 'right',
									],
								]
							],
						]
					],
				]
			);






			


			// MENU ALIGN
			$this->add_control(
				'mae_slide_menu_hr_align',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			// menu vertical align
			$this->add_responsive_control(
				'mae_slide_menu_v_align',
				[
					'label' => __( 'Menu Vertical Align', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'flex-start',
					'options' => [
						'flex-start' =>  __( 'Top', 'magnific-addons' ),
						'center' =>  __( 'Middle', 'magnific-addons' ),
						'flex-end' =>  __( 'Bottom', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .mae_slide_menu' => 'justify-content: {{VALUE}};',
						'{{WRAPPER}} .mae_slide_menu ul' => 'justify-content: {{VALUE}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'by-higest',
							],
							[
								'name' => 'mae_slide_menu_height',
								'operator' => '==',
								'value' => 'custom',
							],
						]
					],
				]
			);
			// menu horizontal align
			$this->add_responsive_control(
				'mae_slide_menu_h_align',
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




			// ITEMS VERTICAL SPACING
			$this->add_control(
				'mae_slide_menu_hr_vertical_spacing',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			$this->add_responsive_control(
				'mae_slide_menu_vertical_spacing',
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




			// SUB MENU INDICATOR
			$this->add_control(
				'mae_slide_menu_hr_submenu',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			// submenu icon
			$this->add_control(
				'mae_slide_menu_submenu_icon',
				[
					'label' => __( 'Submenu Indicator', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'eicon-chevron-right',
					'options' => [
						'eicon-chevron-right' => 'Shevron',
						'eicon-caret-right' => 'Caret',
						'eicon-arrow-right' => 'Arrow',
					],
				]
			);




			// BACK
			$this->add_control(
				'mae_slide_menu_hr_back',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			// back text
			$this->add_control(
				'mae_slide_menu_back_text',
				[
					'label' => __( 'Back Item Label', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Back', 'magnific-addons' ),
				]
			);
			// back icon
			$this->add_control(
				'mae_slide_menu_back_icon',
				[
					'label' => __( 'Back Indicator', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'eicon-chevron-left',
					'options' => [
						'eicon-chevron-left' => 'Shevron',
						'eicon-caret-left' => 'Caret',
						'eicon-arrow-left' => 'Arrow',
					],
				]
			);
			// back vertical align
			$this->add_responsive_control(
				'mae_slide_menu_back_v_position',
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
				'mae_slide_menu_back_h_position',
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


			// ANIMATION SPEED
			$this->add_control(
				'mae_slide_menu_animation_speed_hr',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			// slide animation speed
			$this->add_control(
				'mae_slide_menu_animation_speed',
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





		// FONT
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mae_slide_menu_typography',
				'label' => __( 'Typography', 'magnific-addons' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mae_slide_menu a',
			]
		);



		// TABS
		$this->start_controls_tabs( 'mae_slide_menu_text_style' );

			// TAB NORMAL
			$this->start_controls_tab(
				'mae_slide_menu_normal',
				[
					'label' => __( 'Normal', 'magnific-addons' ),
				]
			);
				$this->add_control(
					'mae_slide_menu_color',
					[
						'label' => __( 'Text Color', 'magnific-addons' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333',
						'selectors' => [
							'{{WRAPPER}} .mae_slide_menu .menu-item *' => 'color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();

			// TAB HOVER
			$this->start_controls_tab(
				'mae_slide_menu_hover',
				[
					'label' => __( 'Hover', 'magnific-addons' ),
				]
			);
				$this->add_control(
					'mae_slide_menu_hover_color',
					[
						'label' => __( 'Hover Text Color', 'magnific-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .mae_slide_menu .menu-item:hover *' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'mae_slide_menu_hover_underline',
					[
						'label' => __( 'Underline', 'magnific-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'magnific-addons' ),
						'label_off' => __( 'No', 'magnific-addons' ),
						'selectors' => [
							'{{WRAPPER}} .mae_slide_menu .menu-item a:hover' => 'text-decoration: underline'
						],
					]
				);
				$this->add_control(
					'mae_slide_menu_hover_bold',
					[
						'label' => __( 'Bold', 'magnific-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'magnific-addons' ),
						'label_off' => __( 'No', 'magnific-addons' ),
						'selectors' => [
							'{{WRAPPER}} .mae_slide_menu .menu-item a:hover' => 'font-weight: bold'
						],
					]
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();
		
		// hover transition speed
		$this->add_control(
			'mae_slide_menu_hover_speed',
			[
				'label' => __( 'Hover Transition Speed (ms)', 'magnific-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 10,
				'default' => 300,
				'selectors' => [
					'{{WRAPPER}} li a' => 'transition: all {{VALUE}}ms',
				],
			]
		);




		// CUSTOM SCROLLBAR STYLING
		// scrollbar
		// scrollbar background color
		// custom scrollbar track width
		$this->add_responsive_control(
			'mae_slide_menu_custom_scroll_width',
			[
				'label' => __( 'Scrollbar Track Width', 'magnific-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 6,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mae_custom_scrollbar' => 'height: {{SIZE}}{{UNIT}};',
				],
				'conditions' => $scrollbar_options_condition,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'mae_slide_menu_custom_scroll_background_color',
			[
				'label' => __( 'Scrollbar track color', 'magnific-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ddd',
				'selectors' => [
					'{{WRAPPER}} .mae_custom_scrollbar' => 'background-color: {{VALUE}};',
				],
				'conditions' => $scrollbar_options_condition,
			]
		);
		// scrollbar border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mae_slide_menu_custom_scroll_border',
				'label' => __( 'Scrollbar track border', 'magnific-addons' ),
				'selector' => '{{WRAPPER}} .mae_custom_scrollbar',
				'conditions' => $scrollbar_options_condition,

			]
		);
		// scrollbar border radius
		$this->add_control(
			'mae_slide_menu_custom_scroll_border_radius',
			[
				'label' => __( 'Scrollbar track border radius', 'magnific-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mae_custom_scrollbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'left' => '0',
					'bottom' => '0',
					'right' => '0',
				],
				'conditions' => $scrollbar_options_condition,
			]
		);



		// scrollbar thumb
		$this->add_control(
			'mae_slide_menu_custom_scroll_thumb_style',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<br>',
			]
		);
		// custom scrollbar thumb width
		$this->add_responsive_control(
			'mae_slide_menu_custom_scroll_thumb_width',
			[
				'label' => __( 'Scrollbar Thumb Width', 'magnific-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 6,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mae_custom_scrollbar::-webkit-slider-thumb' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mae_custom_scrollbar::-moz-range-thumb' => 'height: {{SIZE}}{{UNIT}};',
				],
				'conditions' => $scrollbar_options_condition,
			]
		);
		// scrollbar thumb color
		$this->add_control(
			'mae_slide_menu_custom_scroll_thumb_color',
			[
				'label' => __( 'Scrollbar thumb color', 'magnific-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .mae_custom_scrollbar::-webkit-slider-thumb' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mae_custom_scrollbar::-moz-range-thumb' => 'background-color: {{VALUE}};',
				],
				'conditions' => $scrollbar_options_condition,
			]
		);
		// scrollbar thumb border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mae_slide_menu_custom_scroll_thumb_border',
				'label' => __( 'Scrollbar thumb border', 'magnific-addons' ),
				'selector' => '{{WRAPPER}} .mae_custom_scrollbar::-webkit-slider-thumb, {{WRAPPER}} .mae_custom_scrollbar::-moz-range-thumb',
				'conditions' => $scrollbar_options_condition,
			]
		);
		// scrollbar thumb border radius
		$this->add_control(
			'mae_slide_menu_custom_scroll_thumb_border_radius',
			[
				'label' => __( 'Scrollbar thumb border radius', 'magnific-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mae_custom_scrollbar::-webkit-slider-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mae_custom_scrollbar::-moz-range-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'left' => '0',
					'bottom' => '0',
					'right' => '0',
				],
				'conditions' => $scrollbar_options_condition,
			]
		);












	$this->end_controls_section(); // end style
	}

	public function get_script_depends() {
		return [ 'mae_widgets-script' ];
	}

	protected function render() {

		$available_menus = $this->get_available_menus();
		if ( ! $available_menus ) {
			return;
		}

		// get list of terms
		$settings = $this->get_settings_for_display();

		// $menu_id = 'mae_slide_menu_' . $this->get_id();
		$menu_id = 'mae_slide_menu';


		$args = [
			'echo' => false,
			'menu' => $settings['mae_slide_menu_name'],
			'container' => '',
			'menu_id' => $menu_id,
		];

		$html = '<!doctype html>' . wp_nav_menu( $args );
			
		// DOM object to manipulate results of wp_list_categories()
		$DOM = new DOMDocument();
		$DOM->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		$menu = $DOM->getElementById($menu_id);
		$menu_classes = $menu->getAttribute('class');
		$menu->setAttribute('class', 'opened ' . $menu_classes);
		$uls = $menu->getElementsByTagName('ul');



		foreach($uls as $ul){
			$parent = $ul->parentNode;

			$li_has_child_a = $parent->getElementsByTagName('a')->item(0);
			$li_has_child_a->removeAttribute("href");

			$submenu_indicator = $DOM->createDocumentFragment();
			$submenu_indicator->appendXML('<span class="sub_arrow"><i class="' . $settings['mae_slide_menu_submenu_icon'] . '"></i></span>');
			$li_has_child_a->appendChild($submenu_indicator);

			$back_item = $DOM->createDocumentFragment();
			$back_item->appendXML('<li class="menu-item menu-item-back"><a><span class="back_arrow"><i class="' . $settings['mae_slide_menu_back_icon'] . '"></i></span>' . $settings['mae_slide_menu_back_text'] . '</a></li>');

			if ($settings['mae_slide_menu_back_v_position'] == 'top') {
				$ul->insertBefore($back_item, $ul->firstChild);
			} elseif ($settings['mae_slide_menu_back_v_position'] == 'bottom') {
				$ul->appendChild($back_item);
			}

			// if parent dont has ID 
			if (!preg_match('/menu-item-\d+/', $parent->getAttribute('id'), $id)) {
				preg_match('/menu-item-\d+/', $parent->getAttribute('class'), $id);
				$parent->setAttribute("id", $id[0]);
			}

			// if parent menu li dont has class 'menu-item-has-children'
			if (strpos($parent->getAttribute('class'), 'menu-item-has-children') == false) { 
				$parent->setAttribute("class", $parent->getAttribute('class') . ' menu-item-has-children');
			}
			
			$ul->setAttribute('id', 'menu-' . preg_replace('/[^0-9]/', '', $parent->getAttribute('id')));
		}

		$html=$DOM->saveHTML();

		// custom scrollbar
		if ($settings['mae_slide_menu_scroll'] == 'custom') {
			$scrollbar = '<input type="range" min="0" max="100" value="0" class="mae_custom_scrollbar">';
		} else {
			$scrollbar = '';
		}
		// output
		// echo '<div class="mae_slide_menu mae_navigation_wrapper">' . $html . $scrollbar . '</div>';	
		echo '<div class="mae_slide_menu_wrapper"><div class="mae_slide_menu" data-animation-duration="' . $settings['mae_slide_menu_animation_speed'] . '">' . $html . '</div>' . $scrollbar . '</div>';




	}

}


