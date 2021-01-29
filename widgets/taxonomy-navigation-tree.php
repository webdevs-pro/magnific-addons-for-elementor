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


class Aew_Taxonomy_Navigation_Tree_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_taxonomy_navigation_tree';
	}

	public function get_title() {
		return __( 'Taxonomy Navigation Tree', 'magnific-addons' );
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

	protected function _register_controls() {

		// MAIN SECTION
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Settings', 'magnific-addons' ),
			]
		);
			$args = array(
				'public'   => true,
			);
			$taxonomies = get_taxonomies($args);
			$this->add_control(
				'mae_taxonomy_name',
				[
					'label' => __( 'Taxonomy', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'category',
					'options' => $taxonomies,
				]
			);
			$this->add_control(
				'mae_taxonomy_order_by',
				[
					'label' => __( 'Orderby', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'name',
					'options' => [
						'' => '',
						'name' => 'name',
						'ID' => 'ID',
						'slug' => 'slug',
						'count' => 'count',
						'term_group' => 'term_group',
					],
				]
			);
			$this->add_control(
				'mae_taxonomy_order',
				[
					'label' => __( 'Order', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'ASC',
					'options' => [
						'' => '',
						'ASC' => 'ASC',
						'DESC' => 'DESC',
					],
				]
			);
			$this->add_control(
				'mae_taxonomy_parent',
				[
					'label' => __( 'Parent Term', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					
					'description' => __( 'Parent term ID', 'magnific-addons' ),
				]
			);
			$this->add_control(
				'mae_taxonomy_exclude',
				[
					'label' => __( 'Exclude terms', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Enter comma separated term ID`s to exlude from the query', 'magnific-addons' ),
				]
			);
			$this->add_control(
				'hr_1',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<br>',
				]
			);
			$this->add_control(
				'mae_taxonomy_fallback_message',
				[
					'label' => __( 'Fallback message', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'rows' => 4,
					'default' => __( 'Nothing found', 'magnific-addons' ),
				]
			);
			$this->add_control(
				'mae_taxonomy_show_count',
				[
					'label' => __( 'Show count', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'magnific-addons' ),
					'label_off' => __( 'No', 'magnific-addons' ),
					'return_value' => '1',
				]
			);
			$this->add_control(
				'mae_taxonomy_hide_empty',
				[
					'label' => __( 'Hide empty', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'magnific-addons' ),
					'label_off' => __( 'No', 'magnific-addons' ),
					'return_value' => '1',
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
					'description' => __( 'Unfold to current item for single post will work only if post has ONE taxonomy term selected', 'magnific-addons' ),
				]
			);
			$this->add_control(
				'mae_taxonomy_unfold_child',
				[
					'label' => __( 'Unfold current child', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'magnific-addons' ),
					'label_off' => __( 'No', 'magnific-addons' ),
					'return_value' => '1',
					'description' => __( 'Unfold current item childs list', 'magnific-addons' ),
					'conditions' => [
						'terms' => [
							[
								'name' => 'mae_taxonomy_unfold',
								'operator' => '==',
								'value' => 'current',
							],
						]
					],
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
					'name' => 'mae_taxonomy_typography',
					'label' => __( 'Normal font', 'magnific-addons' ),
					'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .mae_navigation_tree li',
				]
			);






			// TABS
			$this->start_controls_tabs( 'mae_taxonomy_text_style' );

				// TAB NORMAL
				$this->start_controls_tab(
					'mae_taxonomy_normal',
					[
						'label' => __( 'Normal', 'magnific-addons' ),
					]
				);
					$this->add_control(
						'mae_taxonomy_color',
						[
							'label' => __( 'Text Color', 'magnific-addons' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree .cat-item a' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
	
				// TAB HOVER
				$this->start_controls_tab(
					'mae_taxonomy_hover',
					[
						'label' => __( 'Hover', 'magnific-addons' ),
					]
				);
					$this->add_control(
						'mae_taxonomy_hover_color',
						[
							'label' => __( 'Text Color', 'magnific-addons' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree .cat-item a:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'mae_taxonomy_hover_underline',
						[
							'label' => __( 'Underline', 'magnific-addons' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_on' => __( 'Yes', 'magnific-addons' ),
							'label_off' => __( 'No', 'magnific-addons' ),
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree .cat-item a:hover' => 'text-decoration: underline'
							],
						]
					);
					$this->add_control(
						'mae_taxonomy_hover_bold',
						[
							'label' => __( 'Bold', 'magnific-addons' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_on' => __( 'Yes', 'magnific-addons' ),
							'label_off' => __( 'No', 'magnific-addons' ),
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree .cat-item a:hover' => 'font-weight: bold'
							],
						]
					);
				$this->end_controls_tab();

				// TAB ACTIVE
				$this->start_controls_tab(
					'mae_taxonomy_active',
					[
						'label' => __( 'Active', 'elementor' ),
					]
				);
					$this->add_control(
						'mae_taxonomy_active_color',
						[
							'label' => __( 'Text Color', 'magnific-addons' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree li.current-cat > a' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'mae_taxonomy_active_underline',
						[
							'label' => __( 'Underline', 'magnific-addons' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_on' => __( 'Yes', 'magnific-addons' ),
							'label_off' => __( 'No', 'magnific-addons' ),
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree li.current-cat > a' => 'text-decoration: underline'
							],
						]
					);
					$this->add_control(
						'mae_taxonomy_active_bold',
						[
							'label' => __( 'Bold', 'magnific-addons' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'label_on' => __( 'Yes', 'magnific-addons' ),
							'label_off' => __( 'No', 'magnific-addons' ),
							'selectors' => [
								'{{WRAPPER}} .mae_navigation_tree li.current-cat > a' => 'font-weight: bold'
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();





			// VERTICAL SPACING
			$this->add_responsive_control(
				'mae_taxonomy_vertical_spacing',
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
				'mae_taxonomy_left_gap',
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
				'mae_taxonomy_icon',
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
				'mae_taxonomy_icon_color',
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
				'mae_taxonomy_line_heading',
				[
					'label' => __( 'Guides', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'mae_taxonomy_line_type',
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
				'mae_taxonomy_line_color',
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
				'mae_taxonomy_line_width',
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

		// get list of terms
		$settings = $this->get_settings_for_display();

		if ($settings['mae_taxonomy_name']) {
			//$current_term_ancestors = get_ancestors($current_term_id, $settings['mae_taxonomy_name']);
			
			if (is_single() && $settings['mae_taxonomy_unfold'] == 'current') {
				global $post;
				$current_term_id = wp_get_post_terms($post->ID, $settings['mae_taxonomy_name'])[0]->term_id;
				$current_term_ancestors = get_ancestors($current_term_id, $settings['mae_taxonomy_name']);
			}

			$args = array(
				'taxonomy' => $settings['mae_taxonomy_name'],
				'orderby' => $settings['mae_taxonomy_order_by'],
				'order' => $settings['mae_taxonomy_order'],
				'title_li' => '',
				'echo' => false,
				'hide_empty'  => $settings['mae_taxonomy_hide_empty'],
				'show_option_none' => $settings['mae_taxonomy_fallback_message'],
				'show_count' => $settings['mae_taxonomy_show_count'],
				'exclude' => $settings['mae_taxonomy_exclude'],
				'child_of' => $settings['mae_taxonomy_parent'],
			);

			$html = wp_list_categories( $args );

			$html = str_replace('</a> (', '</a> <span>(', $html);
			$html = str_replace(')', ')</span>', $html);
			
			if ($html) {

				// DOM object to manipulate results of wp_list_categories()
				$DOM = new DOMDocument();
				$DOM->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
				$uls = $DOM->getElementsByTagName('ul');

				foreach($uls as $ul) {
					
					$parent = $ul->parentNode;
					$firstChild = $parent->firstChild;

					$parent_li_classes = $parent->getAttribute('class');	




					if (is_single() && $settings['mae_taxonomy_unfold'] == 'current') {
						preg_match('#cat-item-([^\s]+)#', $parent_li_classes, $ul_classes_match);

						// ancestors
						if (in_array($ul_classes_match[1], $current_term_ancestors)) {
							$parent_li_classes = $parent_li_classes . ' current-cat-ancestor';
							$parent->setAttribute('class', $parent_li_classes);
						}



						// // current if sub level
						// if ($ul_classes_match[1] == $current_term_ancestors[0]) {

						// 	$lis = $ul->getElementsByTagName('li');
						// 	foreach($lis as $li) {
						// 		$li_classes = $li->getAttribute('class');	
						// 		preg_match('#cat-item-([^\s]+)#', $li_classes, $li_classes_match);
						// 		if ($li_classes_match[1] == $current_term_id) {	
						// 			$li_classes = $li_classes . ' current-cat';
						// 			$li->setAttribute('class', $li_classes);
						// 		}
						// 	}
						// }

						// // curent if top
						// if ($ul_classes_match[1] == $current_term_id) {
						// 	$li = $parent;
						// 	$li_classes = $li->getAttribute('class');	
						// 	$li_classes = $li_classes . ' current-cat';
						// 	$li->setAttribute('class', $li_classes);
						// }
						
					}
					
					

					


					// unfold current item child
					if (strpos($parent_li_classes, 'current-cat') !== false && $settings['mae_taxonomy_unfold_child'] == '1') {
						$unfold_current_child = true;
					} else {
						$unfold_current_child = false;
					}


					
					$toggleSpan = $DOM->createDocumentFragment();
				  
					if ($settings['mae_taxonomy_unfold'] == 'all'  || (strpos($parent_li_classes, 'current-cat-ancestor') && $settings['mae_taxonomy_unfold'] == 'current') || $unfold_current_child == true) {
						$toggleSpan->appendXML('<span class="sub_toggler opened"><i class="' . $settings['mae_taxonomy_icon'] . '"></i></span>');
					} else {
						$toggleSpan->appendXML('<span class="sub_toggler"><i class="' . $settings['mae_taxonomy_icon'] . '"></i></span>');
					}

					$parent->insertBefore($toggleSpan, $firstChild);

				}

				if (is_single() && $settings['mae_taxonomy_unfold'] == 'current') {
					$lis = $DOM->getElementsByTagName('li');
					foreach($lis as $li) {
						$li_classes = $li->getAttribute('class');	
						preg_match('#cat-item-([^\s]+)#', $li_classes, $li_classes_match);
						if ($li_classes_match[1] == $current_term_id) {	
							$li_classes = $li_classes . ' current-cat';
							$li->setAttribute('class', $li_classes);
						}
					}
				}

				$html=$DOM->saveHTML();

			}

		} else {
			$html = '';
		}

		// output
		echo '<ul class="mae_navigation_tree mae_navigation_wrapper">' . $html . '</ul>';		

	}

}


