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


class Aew_Navigation_Menu_Tree_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_navigation_menu_tree';
	}

	public function get_title() {
		return __( 'Navigation Menu Tree', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-toggle';
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

	protected function register_controls() {

		// MAIN SECTION
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Settings', 'magnific-addons' ),
			]
		);

			$menus = $this->get_available_menus();


			$this->add_control(
				'mae_menu_tree_name',
				[
					'label' => __( 'Menu', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $menus,
					'default' => !empty($menus) ? array_keys( $menus )[0] : '',
				]
			);
			$this->add_control(
				'mae_taxonomy_unfold',
				[
					'label' => __( 'Unfold tree', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => __( 'None', 'magnific-addons' ),
						'current' => __( 'To current item', 'magnific-addons' ),
						'all' => __( 'All', 'magnific-addons' ),
					],
					'prefix_class' => 'mae_unfold_',
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
				'name' => 'mae_menu_tree_typography',
				'label' => __( 'Normal font', 'magnific-addons' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mae_navigation_tree li',
			]
		);






		// TABS
		$this->start_controls_tabs( 'mae_menu_tree_text_style' );

			// TAB NORMAL
			$this->start_controls_tab(
				'mae_menu_tree_normal',
				[
					'label' => __( 'Normal', 'magnific-addons' ),
				]
			);
				$this->add_control(
					'mae_menu_tree_color',
					[
						'label' => __( 'Text Color', 'magnific-addons' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree .menu-item a' => 'color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();

			// TAB HOVER
			$this->start_controls_tab(
				'mae_menu_tree_hover',
				[
					'label' => __( 'Hover', 'magnific-addons' ),
				]
			);
				$this->add_control(
					'mae_menu_tree_hover_color',
					[
						'label' => __( 'Text Color', 'magnific-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree .menu-item a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'mae_menu_tree_hover_underline',
					[
						'label' => __( 'Underline', 'magnific-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'magnific-addons' ),
						'label_off' => __( 'No', 'magnific-addons' ),
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree .menu-item a:hover' => 'text-decoration: underline'
						],
					]
				);
				$this->add_control(
					'mae_menu_tree_hover_bold',
					[
						'label' => __( 'Bold', 'magnific-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'magnific-addons' ),
						'label_off' => __( 'No', 'magnific-addons' ),
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree .menu-item a:hover' => 'font-weight: bold'
						],
					]
				);
			$this->end_controls_tab();

			// TAB ACTIVE
			$this->start_controls_tab(
				'mae_menu_tree_active',
				[
					'label' => __( 'Active', 'elementor' ),
				]
			);
				$this->add_control(
					'mae_menu_tree_active_color',
					[
						'label' => __( 'Text Color', 'magnific-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree li.current-menu-item > a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'mae_menu_tree_active_underline',
					[
						'label' => __( 'Underline', 'magnific-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'magnific-addons' ),
						'label_off' => __( 'No', 'magnific-addons' ),
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree li.current-menu-item > a' => 'text-decoration: underline'
						],
					]
				);
				$this->add_control(
					'mae_menu_tree_active_bold',
					[
						'label' => __( 'Bold', 'magnific-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'magnific-addons' ),
						'label_off' => __( 'No', 'magnific-addons' ),
						'selectors' => [
							'{{WRAPPER}} .mae_navigation_tree li.current-menu-item > a' => 'font-weight: bold'
						],
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();





		// VERTICAL SPACING
		$this->add_responsive_control(
			'mae_menu_tree_vertical_spacing',
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
					'{{WRAPPER}} .mae_navigation_tree li a' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);




		// LEFT INDENT
		$this->add_responsive_control(
			'mae_menu_tree_left_gap',
			[
				'label' => __( 'Sublevel Left Gap', 'magnific-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.5,
					'unit' => 'em',
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
					'{{WRAPPER}} .mae_navigation_tree li ul' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);






		// ICON
		$this->add_control(
			'mae_menu_tree_icon',
			[
				'label' => __( 'Icon', 'magnific-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'eicon-plus-square-o',
				'options' => [
					'eicon-plus-square-o' => 'Plus',
					'eicon-caret-right' => 'Caret',
					'eicon-chevron-right' => 'Shevron',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'mae_menu_tree_icon_color',
			[
				'label' => __( 'Icon Color', 'magnific-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#999',
				'selectors' => [
					'{{WRAPPER}} .mae_navigation_tree .sub_toggler' => 'color: {{VALUE}};',
				],
			]
		);



		// LINE
		$this->add_control(
			'mae_menu_tree_line_heading',
			[
				'label' => __( 'Guides', 'magnific-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'mae_menu_tree_line_type',
			[
				'label' => __( 'Line Style', 'magnific-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dotted',
				'options' => [
					'none' => 'none',
					'solid' => 'solid',
					'dashed' => 'dashed',
					'dotted' => 'dotted',
				],
				'selectors' => [
					'{{WRAPPER}} .mae_navigation_tree li ul' => 'border-left-style: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mae_menu_tree_line_color',
			[
				'label' => __( 'Line Color', 'magnific-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'selectors' => [
					'{{WRAPPER}} .mae_navigation_tree li ul' => 'border-left-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'mae_menu_tree_line_width',
			[
				'label' => __( 'Line Width', 'magnific-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mae_navigation_tree li ul' => 'border-left-width: {{SIZE}}{{UNIT}};',
				],
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

		$menu_id = 'mae_menu_tree_' . $this->get_id();

		$args = [
			'echo' => false,
			'menu' => $settings['mae_menu_tree_name'],
			'container' => '',
			'menu_id' => $menu_id,
			
		];

		$html = wp_nav_menu( $args );
			


		// DOM object to manipulate results of wp_list_categories()
		$DOM = new DOMDocument();
		$DOM->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		$menu = $DOM->getElementById($menu_id);
		$uls = $menu->getElementsByTagName('ul');

		foreach($uls as $ul){
			
			$parent = $ul->parentNode;
			$firstChild = $parent->firstChild;

			// set class to '<li>' if has child
			// $classes = $parent->getAttribute('class');
			// $parent->setAttribute('class', $classes . ' mae_has_children');
			
			// insert toggle
			// $toggleSpan = $DOM->createElement('span');
			// $toggleSpan->setAttribute('class','sub_toggler');
			// $icon = $DOM->createElement('i');
			// $icon->setAttribute('class','eicon-plus-square-o');
			// $toggleSpan->appendChild($icon);

			$toggleSpan = $DOM->createDocumentFragment();

			if ($settings['mae_taxonomy_unfold'] == 'all') {
				$toggleSpan->appendXML('<span class="sub_toggler opened"><i class="' . $settings['mae_menu_tree_icon'] . '"></i></span>');
			} else {
				$toggleSpan->appendXML('<span class="sub_toggler"><i class="' . $settings['mae_menu_tree_icon'] . '"></i></span>');
			}
			
			$parent->insertBefore($toggleSpan, $firstChild);

		}

		$html=$DOM->saveHTML();

			


		// output
		echo '<div class="mae_navigation_tree mae_navigation_wrapper">' . $html . '</div>';		

	}

}


