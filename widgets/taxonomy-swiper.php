<?php
namespace MagnificAddons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
// use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
// use Elementor\Group_Control_Text_Shadow;
// use Elementor\Group_Control_Box_Shadow;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Aew_Taxonomy_Swiper_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_taxonomy_swiper';
	}

	public function get_title() {
		return __( 'Taxonomy Swiper', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return [ 'ae-category' ];
	}



	// public function get_style_depends() {
	// 	return [ 'advanced-elementor-widgets-style' ];
	// }

	protected function _register_controls() {

		// MAIN SECTION
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Taxonomy', 'magnific-addons' ),
			]
      );

         // taxonomy select
         $args = array(
            'public'   => true,
         );
         $taxonomies = get_taxonomies($args);

         $this->add_control(
            'mae_ts_taxonomy_name',
            [
               'label' => __( 'Taxonomy', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'category',
               'options' => $taxonomies,
               'frontend_available' => true,
            ]
         );
         // term parent
         $this->add_control(
            'mae_ts_parent_term',
            [
               'label' => __( 'Parent Term', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 0,
            ]
         ); 
         // include terms
         $this->add_control(
            'mae_ts_include',
            [
               'label' => __( 'Include Terms', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'description' => __( 'Comma separated id`s of terms to include', 'magnific-addons' ),
            ]
         );        
         // exclude terms
         $this->add_control(
            'mae_ts_exclude',
            [
               'label' => __( 'Exclude Terms', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'description' => __( 'Comma separated id`s of terms to exclude', 'magnific-addons' ),
               'separator' => 'after',
            ]
         );    
         // term image field name
         $this->add_control(
            'mae_ts_image_field_name',
            [
               'label' => __( 'Images Field Name', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'description' => __( 'Taxonomy term image custom field name', 'magnific-addons' ),
            ]
         );

         // term fallback image
         $this->add_control(
            'mae_ts_fallback_image',
            [
               'label' => __( 'Fallback Image', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::MEDIA,
            ]
         );
         // image height
         $this->add_responsive_control(
            'mae_ts_image_height',
            [
               'label' => __( 'Image Size', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 150,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => '',
               ],
					'selectors' => [
						'{{WRAPPER}} .mae_taxonomy_swiper_term_image' => 'height: {{SIZE}}{{UNIT}}',
					],
               
            ]
         );  
         // image height
         $this->add_responsive_control(
            'mae_ts_image_spacing',
            [
               'label' => __( 'Image Spacing', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 50,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 0,
               ],
					'selectors' => [
						'{{WRAPPER}} .mae_taxonomy_swiper_term_image' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
               
            ]
         );           
         // // image padding
         // $this->add_responsive_control(
         //    'mae_ts_image_padding',
         //    [
         //       'label' => __( 'Image Padding', 'magnific-addons' ),
         //       'type' => Controls_Manager::DIMENSIONS,
         //       'size_units' => [ 'px' ],
         //       'selectors' => [
         //          '{{WRAPPER}} .mae_taxonomy_swiper_term_image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
         //       ],
         //    ]
         // );


         // slides per view
         $this->add_responsive_control(
            'mae_ts_slidesPerView',
            [
               'label' => __( 'Items to Show', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 30,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 10,
               ],
               'render_type' => 'template',
               'separator' => 'before',
            ]
         );

         // slides to scroll
         $this->add_responsive_control(
            'mae_ts_slidesPerGroup',
            [
               'label' => __( 'Items to Scroll', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 30,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 10,
               ],
               'render_type' => 'template',
            ]
         );
         // space between
         $this->add_responsive_control(
            'mae_ts_spaceBetween',
            [
               'label' => __( 'Space Between', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 100,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 0,
               ],
               'render_type' => 'template',
            ]
         );


         // transition speed
         $this->add_control(
            'mae_ts_speed',
            [
               'label' => __( 'Trasition Speed', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 100,
               'max' => 5000,
               'step' => 50,
               'default' => 1000,
               'render_type' => 'template',
               'separator' => 'after',
            ]
         );

         // // image position
         // $this->add_control(
         //    'mae_ts_image_positition',
         //    [
         //       'label' => __( 'Transition', 'magnific-addons' ),
         //       'type' => \Elementor\Controls_Manager::SELECT,
         //       'default' => 'slide',
         //       'options' => [
         //          'slide' => 'Slide',
         //          'fade' => 'Fade',             
         //       ],
         //    ]
         // );


         // --------------------------------------------------------------------

         // typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'mae_ts_typography',
					'label' => __( 'Typography', 'magnific-addons' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_3,
               'selector' => '{{WRAPPER}} .mae_taxonomy_swiper_term_title',
               
				]
         );
         
			// color
			$this->add_control(
				'mae_ts_color',
				[
					'label' => __( 'Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mae_taxonomy_swiper_term_title' => 'color: {{VALUE}}',
					],
				]
         );
         $this->add_responsive_control(
            'mae_ts_align',
            [
               'label' => __( 'Text Alignment', 'magnific-addons' ),
               'type' => Controls_Manager::CHOOSE,
               'options' => [
                  'left' => [
                     'title' => __( 'Left', 'magnific-addons' ),
                     'icon' => 'eicon-text-align-left',
                  ],
                  'center' => [
                     'title' => __( 'Center', 'magnific-addons' ),
                     'icon' => 'eicon-text-align-center',
                  ],
                  'right' => [
                     'title' => __( 'Right', 'magnific-addons' ),
                     'icon' => 'eicon-text-align-right',
                  ],
               ],
               'default' => '',
               'selectors' => [
                  '{{WRAPPER}} .mae_taxonomy_swiper_term_title' => 'text-align: {{VALUE}};',
               ],
            ]
         );
         

      $this->end_controls_section(); 
































      $this->start_controls_section( // ----------------------------------------------------------------------------------------------
         'mae_section_arrows',
         [
            'label' => __( 'Arrows', 'magnific-addons' ),
         ]
      );
         
         // arrows enable
         $this->add_control(
            'mae_ts_arrows_type',
            [
               'label' => __( 'Arrows Type', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'options' => [
                  'icon' => [
                     'title' => __( 'Icon', 'magnific-addons' ),
                     'icon' => 'fa fa-star',
                  ],
                  'image' => [
                     'title' => __( 'Image', 'magnific-addons' ),
                     'icon' => 'fa fa-image',
                  ],
               ],
               'default' => 'icon',
               'toggle' => true,

            ]
         );


         // hide svg uploader
         ?><style>
            .elementor-control-media .elementor-control-dynamic-switcher-wrapper {
               display: none !important;
            }
         </style><?php

         // prev arrow icon
         $this->add_control(
            'mae_ts_arrows_prev_icon',
            [
               'label' => __( 'Prev Icon', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::ICONS,
               'default' => [
                  'value' => 'fas fa-chevron-left',
                  'library' => 'solid',
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
               'condition' => [
                  'mae_ts_arrows_type' => 'icon',
               ],
            ]
         );
         // prev arrow image
         $this->add_control(
            'mae_ts_arrows_prev_image',
            [
               'label' => __( 'Prev Image', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
               'condition' => [
                  'mae_ts_arrows_type' => 'image',
               ],
            ]
         );
         // next arrow icon
         $this->add_control(
            'mae_ts_arrows_next_icon',
            [
               'label' => __( 'Next Icon', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::ICONS,
               'default' => [
                  'value' => 'fas fa-chevron-right',
                  'library' => 'solid',
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
               'condition' => [
                  'mae_ts_arrows_type' => 'icon',
               ],
            ]
         );
         // next arrow image
         $this->add_control(
            'mae_ts_arrows_next_image',
            [
               'label' => __( 'Next Image', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
               'condition' => [
                  'mae_ts_arrows_type' => 'image',
               ],
            ]
         );




         // icons color
         $this->add_control(
            'mae_ts_arrows_icons_color',
            [
               'label' => __( 'Icons Color', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
                  '{{WRAPPER}}  .taxonomy-swiper-button-prev' => 'color: {{VALUE}}',
                  '{{WRAPPER}}  .taxonomy-swiper-button-next' => 'color: {{VALUE}}',
               ],
               'condition' => [
                  'mae_ts_arrows_type' => 'icon',
               ],
               'default' => '#000',
            ]
         );
         // icons size
         $this->add_control(
            'mae_ts_arrows_icons_size',
            [
               'label' => __( 'Icon Size', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 100,
                     'step' => 1,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 24,
               ],
               'selectors' => [
                  '{{WRAPPER}} .taxonomy-swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-prev i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-prev .image' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next .image' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );


         // icons bg color
         $this->add_control(
            'mae_ts_arrows_icons_background-color',
            [
               'label' => __( 'Background Color', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
                  '{{WRAPPER}}  .taxonomy-swiper-button-prev' => 'background-color: {{VALUE}}',
                  '{{WRAPPER}}  .taxonomy-swiper-button-next' => 'background-color: {{VALUE}}',
               ],
               'default' => '',
               'separator' => 'before',
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );
         // icons padding
         $this->add_control(
            'mae_ts_arrows_icons_spacing',
            [
               'label' => __( 'Padding', 'magnific-addons' ),
               'type' => Controls_Manager::DIMENSIONS,
               'size_units' => [ 'px' ],
               'default' => [
                  'top' => '0',
                  'right' => '0',
                  'bottom' => '0',
                  'left' => '0',
                  'isLinked' => true,
               ],
               'selectors' => [
                  '{{WRAPPER}} .taxonomy-swiper-button-prev i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-prev .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );



         // arrows vertical position anchor 
         $this->add_control(
            'mae_ts_arrows_vertical_anchor',
            [
               'label' => __( 'Vertical Orientation', 'magnific-addons' ),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'options' => [
                  'top' => [
                     'title' => __( 'Top', 'magnific-addons' ),
                     'icon' => 'eicon-v-align-top',
                  ],
                  'bottom' => [
                     'title' => __( 'Bottom', 'magnific-addons' ),
                     'icon' => 'eicon-v-align-bottom',
                  ],
               ],
               'default' => 'top',
               'toggle' => false,
               'separator' => 'before',
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ],
               'selectors_dictionary' => [
                  'top' => '-50%',
                  'bottom' => '50%',
              ],
               'selectors' => [
                  '{{WRAPPER}} .taxonomy-swiper-button-prev' => 'transform: translateY({{VALUE}});',
                  '{{WRAPPER}} .taxonomy-swiper-button-next' => 'transform: translateY({{VALUE}});',
               ],
            ]
         );



         // icons vertical position top
         $this->add_control(
            'mae_ts_arrows_icons_vertical_from_top',
            [
               'label' => __( 'Vertical Position', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px', '%' ],
               'range' => [
                  'px' => [
                     'min' => -100,
                     'max' => 500,
                  ],
                  '%' => [
                     'min' => 0,
                     'max' => 100,
                  ],
               ],
               'default' => [
                  'unit' => '%',
                  'size' => 50,
               ],
               'selectors' => [
                  '{{WRAPPER}} .taxonomy-swiper-button-prev' => 'bottom: auto; top: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next' => 'bottom: auto; top: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'terms' => [
                           [
                                 'name' => 'mae_ts_arrows_type',
                                 'operator' => '==',
                                 'value' => 'icon',
                           ],
                           [
                                 'name' => 'mae_ts_arrows_vertical_anchor',
                                 'operator' => '==',
                                 'value' => 'top',
                           ]
                        ]
                     ],
                     [
                        'terms' => [
                           [
                                 'name' => 'mae_ts_arrows_type',
                                 'operator' => '==',
                                 'value' => 'image',
                           ],
                           [
                                 'name' => 'mae_ts_arrows_vertical_anchor',
                                 'operator' => '==',
                                 'value' => 'top',
                           ],
                        ]
                     ]
                  ]
               ]
            ]
         );
         // icons vertical position bottom
         $this->add_control(
            'mae_ts_arrows_icons_vertical_from_bottom',
            [
               'label' => __( 'Vertical Position', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px', '%' ],
               'range' => [
                  'px' => [
                     'min' => -100,
                     'max' => 500,
                  ],
                  '%' => [
                     'min' => 0,
                     'max' => 100,
                  ],
               ],
               'default' => [
                  'unit' => '%',
                  'size' => 50,
               ],
               'selectors' => [
                  '{{WRAPPER}} .taxonomy-swiper-button-prev' => 'top: auto; bottom: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next' => 'top: auto; bottom: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'terms' => [
                           [
                                 'name' => 'mae_ts_arrows_type',
                                 'operator' => '==',
                                 'value' => 'icon',
                           ],
                           [
                                 'name' => 'mae_ts_arrows_vertical_anchor',
                                 'operator' => '==',
                                 'value' => 'bottom',
                           ]
                        ]
                     ],
                     [
                        'terms' => [
                           [
                                 'name' => 'mae_ts_arrows_type',
                                 'operator' => '==',
                                 'value' => 'image',
                           ],
                           [
                                 'name' => 'mae_ts_arrows_vertical_anchor',
                                 'operator' => '==',
                                 'value' => 'bottom',
                           ],
                        ]
                     ]
                  ]
               ]
            ]
         );





         // icons horizontal position
         $this->add_control(
            'mae_ts_arrows_icons_horizontal',
            [
               'label' => __( 'Horizontal Position', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px', '%' ],
               'range' => [
                  'px' => [
                     'min' => -300,
                     'max' => 300,
                  ],
                  '%' => [
                     'min' => -100,
                     'max' => 100,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 0,
               ],
               'selectors' => [
                  '{{WRAPPER}} .taxonomy-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .taxonomy-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_ts_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );           

      $this->end_controls_section(); 
      
	}

	public function get_script_depends() {
		return [ 'mae_widgets-script' ];
	}

   protected function render() {

      $settings = $this->get_settings_for_display();

      $args = array(
         'taxonomy' => $settings['mae_ts_taxonomy_name'],
         'hide_empty'   => false,
         'parent' => $settings['mae_ts_parent_term'],
         'include' => $settings['mae_ts_include'],
         'exclude' => $settings['mae_ts_exclude'],
      );

      $terms = get_terms( $args );

      $html = '<div class="swiper-container">';

         $html .= '<div class="swiper-wrapper">';

            foreach($terms as $term) {
               
               $image_id = get_term_meta($term->term_id, $settings['mae_ts_image_field_name']);

               // echo '<pre>' . print_r($image_id, true) . '</pre><br>';

               if ($image_id && isset($image_id[0]) && $image_id[0] != '0')  {
                  $image_url = wp_get_attachment_url($image_id[0]);
               } else {
                  $image_url = $settings['mae_ts_fallback_image']['url'];
               }

               // echo '<pre>' . print_r($settings['mae_ts_fallback_image'], true) . '</pre><br>';
               // echo '<pre>' . print_r($image_url, true) . '</pre><br>';

               if(isset(get_queried_object()->term_id) && get_queried_object()->term_id == $term->term_id) {
                  $active_class = ' current_term';
               } else {
                  $active_class = '';
               }

               $html .= '<div class="mae_taxonomy_swiper_term swiper-slide ' . $active_class . '">';

                  $html .= '<a href="' . get_term_link( $term ) . '">';

                     $html .= '<div class="mae_taxonomy_swiper_term_image"><img class="mae_taxonomy_swiper_term_image" src="' . $image_url . '" /></div>';

                     $html .= '<div class="mae_taxonomy_swiper_term_title">' . $term->name . '</div>';

                  $html .= '</a>';
                  
               $html .= '</div>';
               
            }

         $html .= '</div>';
      
      $html .= '</div>';



      // arrows
      // icons
      if ($settings['mae_ts_arrows_type'] == 'icon') { 
         $html .= '<div class="taxonomy-swiper-button-prev"><i class="' . $settings['mae_ts_arrows_prev_icon']['value'] . '"></i></div>';
         $html .= '<div class="taxonomy-swiper-button-next"><i class="' . $settings['mae_ts_arrows_next_icon']['value'] . '"></i></div>';    
      }
      // images
      if ($settings['mae_ts_arrows_type'] == 'image') {
         $html .= '<div class="taxonomy-swiper-button-prev"><div class="image"><img src="' . $settings['mae_ts_arrows_prev_image']['url'] . '"/></div></div>';
         $html .= '<div class="taxonomy-swiper-button-next"><div class="image"><img src="' . $settings['mae_ts_arrows_next_image']['url'] . '"/></div></div>';    
      }








      $slider_settings = array(
         // 'enabled' => $settings['mae_ts_enabled'],
         'slidesPerView' => $settings['mae_ts_slidesPerView']['size'],
         'slidesPerView_tablet' => $settings['mae_ts_slidesPerView_tablet']['size'] ?: $settings['mae_ts_slidesPerView']['size'],
         'slidesPerView_mobile' => $settings['mae_ts_slidesPerView_mobile']['size'] ?: ($settings['mae_ts_slidesPerView_tablet']['size'] ?: $settings['mae_ts_slidesPerView']['size']), 
         'slidesPerGroup' => $settings['mae_ts_slidesPerGroup']['size'],
         'slidesPerGroup_tablet' => $settings['mae_ts_slidesPerGroup_tablet']['size'] ?: $settings['mae_ts_slidesPerGroup']['size'],
         'slidesPerGroup_mobile' => $settings['mae_ts_slidesPerGroup_mobile']['size'] ?: ($settings['mae_ts_slidesPerGroup_tablet']['size'] ?: $settings['mae_ts_slidesPerGroup']['size']),
         'spaceBetween' => $settings['mae_ts_spaceBetween']['size'],
         'spaceBetween_tablet' => $settings['mae_ts_spaceBetween_tablet']['size'] ?: $settings['mae_ts_spaceBetween']['size'],
         'spaceBetween_mobile' => $settings['mae_ts_spaceBetween_mobile']['size'] ?: ($settings['mae_ts_spaceBetween_tablet']['size'] ?: $settings['mae_ts_spaceBetween']['size']),
         'speed' => $settings['mae_ts_speed'],
      );

    
      ?>
         <script>

            var as_<?php echo $this->get_id(); ?>_settings = '<?php echo json_encode($slider_settings); ?>';

         </script>

      <?php

      echo $html;


   }


}






