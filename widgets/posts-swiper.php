<?php
namespace MagnificAddons;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Responsive\Responsive;
// use Elementor\Group_Control_Typography;
// use Elementor\Group_Control_Border;
// use Elementor\Scheme_Typography;
// use Elementor\Group_Control_Text_Shadow;
// use Elementor\Group_Control_Box_Shadow;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Aew_posts_Swiper_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_posts_swiper';
	}

	public function get_title() {
		return __( 'Posts Swiper', 'magnific-addons' );
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
		$this->start_controls_section( // ----------------------------------------------------------------------------------------------
			'mae_section_main_settings',
			[
				'label' => __( 'Posts Swiper', 'magnific-addons' ),
			]
      );

      
         // target selector
         $this->add_control(
            'mae_as_target',
            [
               'label' => __( 'Target Selector', 'magnific-addons' ),
               'label_block' => true,
               'type' => Controls_Manager::TEXT,
               'description' => __( 'Connect section you want to transform to slider and this widget with a unique ID or class name', 'magnific-addons' ),
               'dynamic' => [
                  'active' => true,
               ],
               'frontend_available' => true,
            ]
         );       


         $this->add_control(
				'mae_as_enabled',
				[
					'label' => __( 'Enable Swiper Preview', 'magnific-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'magnific-addons' ),
					'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
               'separator' => 'before',
               'selectors' => [
                  '{{WRAPPER}} > .elementor-widget-container > .elementor-posts-container' => 'display: flex !important; flex-wrap: nowrap;',
               ],
               'render_type' => 'template',
				]
         );


      $this->end_controls_section(); 

      

      $this->start_controls_section( // ----------------------------------------------------------------------------------------------
         'mae_section_settings',
         [
            'label' => __( 'Slider Settings', 'magnific-addons' ),
         ]
      );

         // slider height
         $this->add_responsive_control(
            'mae_as_slider_height',
            [
               'label' => __( 'Height', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px', 'vh', 'vw' ],
               'range' => [
                  'px' => [
                     'min' => 100,
                     'max' => 1000,
                  ],
                  'vh' => [
                     'min' => 0,
                     'max' => 100,
                  ],
                  'vw' => [
                     'min' => 0,
                     'max' => 100,
                  ],
               ],
               'selectors' => [
                  '{{WRAPPER}} > .elementor-widget-container > .elementor-posts-container > article' => 'min-height: {{SIZE}}{{UNIT}} !important;',
               ],
            ]
         );
         // effect
         $this->add_control(
            'mae_as_effect',
            [
               'label' => __( 'Transition', 'magnific-addons' ),
               'type' => Controls_Manager::SELECT,
               'default' => 'slide',
               'options' => [
                  'slide' => 'Slide',
                  'fade' => 'Fade',
                  'coverflow' => 'Coverflow'
               ],
            ]
         );
         // fade crosfade
         $this->add_control(
            'mae_as_fade_crossfade',
            [
               'label' => __( 'CrossFade', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
               'default' => '1',
               'condition' => [
                  'mae_as_effect' => 'fade',
               ],
            ]
         );         
         // coverflow shadow
         $this->add_control(
            'mae_as_coverflow_shadows',
            [
               'label' => __( 'Slide Shadows', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => 'true',
               'default' => '',
               'condition' => [
                  'mae_as_effect' => 'coverflow',
               ],
            ]
         );          
         // centered slides
         $this->add_control(
            'mae_as_centered',
            [
               'label' => __( 'Centered Slides', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => 'true',
               'default' => '',
               'condition' => [
                  'mae_as_effect' => ['coverflow', 'slide' ]
               ],
            ]
         );
         // centered slides bound
         $this->add_control(
            'mae_as_centered_bounds',
            [
               'label' => __( 'Centered Slides Bounds', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => 'true',
               'default' => '',
               'conditions' => [
                  'relation' => 'and',
                  'terms' => [
                     [
                        'name' => 'mae_as_centered',
                        'operator' => '==',
                        'value' => 'true'
                     ],
                     [
                        'relation' => 'or',
                        'terms' => [
                           [
                              'name' => 'mae_as_effect',
                              'operator' => '==',
                              'value' => 'slide'
                           ],
                           [
                              'name' => 'mae_as_effect',
                              'operator' => '==',
                              'value' => 'coverflow'
                           ]
                        ]
                     ]
                  ]
               ]
            ]
         );
         // slides per view
         $this->add_responsive_control(
            'mae_as_slidesPerView',
            [
               'label' => __( 'Slides Per View', 'magnific-addons' ),
               'type' => Controls_Manager::SELECT,
               'default' => '3',
               'options' => [
                  'auto' => 'Auto',
                  '1' => '1',
                  '2' => '2',
                  '3' => '3',
                  '4' => '4',
                  '5' => '5',
                  '6' => '6',
               ],
               'condition' => [
                  'mae_as_effect!' => 'fade',
               ],
            ]
         );
         // space between
         $this->add_responsive_control(
            'mae_as_space_between',
            [
               'label' => __( 'Space Between', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px' ],
               'range' => [
                  'px' => [
                     'min' => 0,
                     'max' => 300,
                  ],
               ],
               'default' => [
                  'unit' => 'px',
                  'size' => 30,
               ],
               'condition' => [
                  'mae_as_effect!' => 'fade',
               ],
            ]
         );
         // transition speed
         $this->add_control(
            'mae_as_speed',
            [
               'label' => __( 'Trasition Speed', 'magnific-addons' ),
               'type' => Controls_Manager::NUMBER,
               'min' => 100,
               'max' => 5000,
               'step' => 50,
               'default' => 1000,
               'separator' => 'before',
               'classes' => "MAEcontrolWidth100px",
               'description' => '<style>.MAEcontrolWidth100px input{width:100px}</style>',
            ]
         );
         // loop
         $this->add_control(
            'mae_as_loop',
            [
               'label' => __( 'Loop', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
            ]
         );
         // autoplay
         $this->add_control(
            'mae_as_autoplay',
            [
               'label' => __( 'Autoplay', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
               'separator' => 'before',
            ]
         );
         // autoplay speed
         $this->add_control(
            'mae_as_autoplay_delay',
            [
               'label' => __( 'Autoplay Delay', 'magnific-addons' ),
               'type' => Controls_Manager::NUMBER,
               'min' => 100,
               'max' => 5000,
               'step' => 50,
               'default' => 1000,
               'condition' => [
                  'mae_as_autoplay' => '1',
               ],
               'classes' => "MAEcontrolWidth100px",
            ]
         );
         // pause on hover
         $this->add_control(
            'mae_as_autoplay_pause_on_hover',
            [
               'label' => __( 'Pause On Hover', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
               'condition' => [
                  'mae_as_autoplay' => '1',
               ],
            ]
         );
         // navigation enabled
         $this->add_control(
            'mae_as_navigation',
            [
               'label' => __( 'Navigation Arrows', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
               'separator' => 'before',
               'selectors' => [
                  '{{WRAPPER}} > .mae_as_navigation' => 'display: block !important;',
               ],
               'render_type' => 'template',

            ]
         );      
         // pagination enabled
         $this->add_control(
            'mae_as_pagination',
            [
               'label' => __( 'Pagination', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
            ]
         );     
         // scrolbar enabled
         $this->add_control(
            'mae_as_scrollbar',
            [
               'label' => __( 'Scrollbar', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
            ]
         );    
         // parallax
         $this->add_control(
            'mae_as_parallax',
            [
               'label' => __( 'Parallax', 'magnific-addons' ),
               'type' => Controls_Manager::SWITCHER,
               'label_on' => __( 'On', 'magnific-addons' ),
               'label_off' => __( 'Off', 'magnific-addons' ),
               'return_value' => '1',
               'separator' => 'before',
               'description' => __( 'Read more about parallax <a href=https://swiperjs.com/api/#parallax" target="_blank" rel="noopener" rel="noreferrer">here</a> slider init settings', 'magnific-addons' ),
            ]
         );

         $this->add_control(
            'mae_as_custom_settings',
            [
               'label' => __( 'Custom Swiper Parameters', 'magnific-addons' ),
               'type' => Controls_Manager::CODE,
               'rows' => 5,
               'separator' => 'before',
               'description' => __( 'You can add here custom <a href="https://swiperjs.com/api/#initialize" target="_blank" rel="noopener" rel="noreferrer">Swiper API</a> slider init settings', 'magnific-addons' ),
            ]
         );


      $this->end_controls_section(); 

























      $this->start_controls_section( // ----------------------------------------------------------------------------------------------
         'mae_section_arrows',
         [
            'label' => __( 'Arrows', 'magnific-addons' ),
            'condition' => [
               'mae_as_navigation' => '1',
            ],
         ]
      );
         
         // arrows enable
         $this->add_control(
            'mae_as_arrows_type',
            [
               'label' => __( 'Arrows Type', 'magnific-addons' ),
               'type' => Controls_Manager::CHOOSE,
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
               'toggle' => false,
            ]
         );



         // prev arrow icon
         $this->add_control(
            'mae_as_arrows_prev_icon',
            [
               'label' => __( 'Prev Icon', 'magnific-addons' ),
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
               'condition' => [
                  'mae_as_arrows_type' => 'icon',
               ],
            ]
         );
         // prev arrow image
         $this->add_control(
            'mae_as_arrows_prev_image',
            [
               'label' => __( 'Prev Image', 'magnific-addons' ),
               'type' => Controls_Manager::MEDIA,
               'default' => [
                  'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
               'condition' => [
                  'mae_as_arrows_type' => 'image',
               ],
            ]
         );
         // next arrow icon
         $this->add_control(
            'mae_as_arrows_next_icon',
            [
               'label' => __( 'Next Icon', 'magnific-addons' ),
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
               'condition' => [
                  'mae_as_arrows_type' => 'icon',
               ],
            ]
         );
         // next arrow image
         $this->add_control(
            'mae_as_arrows_next_image',
            [
               'label' => __( 'Next Image', 'magnific-addons' ),
               'type' => Controls_Manager::MEDIA,
               'default' => [
                  'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
               'condition' => [
                  'mae_as_arrows_type' => 'image',
               ],
            ]
         );
         // icons color
         $this->add_control(
            'mae_as_arrows_icons_color',
            [
               'label' => __( 'Icons Color', 'magnific-addons' ),
               'type' => Controls_Manager::COLOR,
               'selectors' => [
                  '{{WRAPPER}} .advanced-swiper-button-prev' => 'color: {{VALUE}}',
                  '{{WRAPPER}} .advanced-swiper-button-next' => 'color: {{VALUE}}',
                  '{{WRAPPER}} .advanced-swiper-button-prev svg' => 'fill: {{VALUE}}',
                  '{{WRAPPER}} .advanced-swiper-button-next svg' => 'fill: {{VALUE}}',                  
               ],
               'condition' => [
                  'mae_as_arrows_type' => 'icon',
               ],
               'default' => '#000',
            ]
         );
         // icons size
         $this->add_responsive_control(
            'mae_as_arrows_icons_size',
            [
               'label' => __( 'Size', 'magnific-addons' ),
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
               'tablet_default' => [
                  'unit' => 'px',
                  'size' => 24,
               ],
               'mobile_default' => [
                  'unit' => 'px',
                  'size' => 24,
               ],
               'selectors' => [
                  '{{WRAPPER}} .advanced-swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                  // '{{WRAPPER}} .advanced-swiper-button-prev i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                  // '{{WRAPPER}} .advanced-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-prev .image' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next .image' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );
         // icons bg color
         $this->add_control(
            'mae_as_arrows_icons_background-color',
            [
               'label' => __( 'Background Color', 'magnific-addons' ),
               'type' => Controls_Manager::COLOR,
               'selectors' => [
                  '{{WRAPPER}} .advanced-swiper-button-prev' => 'background-color: {{VALUE}}',
                  '{{WRAPPER}} .advanced-swiper-button-next' => 'background-color: {{VALUE}}',
               ],
               'default' => '',
               'separator' => 'before',
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );
         // icons padding
         $this->add_control(
            'mae_as_arrows_icons_spacing',
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
                  '{{WRAPPER}} .advanced-swiper-button-prev i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-prev svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-prev .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );
         // arrows vertical position
         $this->add_responsive_control(
            'mae_as_arrows_y_position',
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
                  '{{WRAPPER}} .advanced-swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );
         // arrows horizontal position
         $this->add_responsive_control(
            'mae_as_arrows_h_position',
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
                  '{{WRAPPER}} .advanced-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .advanced-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
               ],
               'conditions' => [
                  'relation' => 'or',
                  'terms' => [
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'icon'
                     ],
                     [
                        'name' => 'mae_as_arrows_type',
                        'operator' => '==',
                        'value' => 'image'
                     ]
                  ]
               ]
            ]
         );           

      $this->end_controls_section(); 





      $this->start_controls_section( // ----------------------------------------------------------------------------------------------
         'mae_section_pagination',
         [
            'label' => __( 'Pagination', 'magnific-addons' ),
            'condition' => [
               'mae_as_pagination' => '1',
            ],
         ]
      );
         // pagination type
         $this->add_control(
            'mae_as_pagination_type',
            [
               'label' => __( 'Transition', 'magnific-addons' ),
               'type' => Controls_Manager::SELECT,
               'default' => 'bullets',
               'options' => [
                  'bullets' => 'Bullets',
                  'fraction' => 'Fraction',
                  'progressbar' => 'Progressbar'
               ],
            ]
         );
         
         // bullets
         // bullets vertical position
         $this->add_responsive_control(
            'mae_as_bullets_y_position',
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
                  'unit' => 'px',
                  'size' => 0,
               ],
               'selectors' => [
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets' => 'bottom: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets' => 'bottom: {{SIZE}}{{UNIT}};',
               ],
               'condition' => [
                  'mae_as_pagination_type' => ['bullets', 'fraction']
               ]
            ]
         );
         // bullets horizontal position
         $this->add_responsive_control(
            'mae_as_bullets_h_position',
            [
               'label' => __( 'Horizontal Position', 'magnific-addons' ),
               'type' => Controls_Manager::SLIDER,
               'size_units' => [ 'px', '%' ],
               'range' => [
                  'px' => [
                     'min' => -1000,
                     'max' => 1000,
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
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets' => 'left: {{SIZE}}{{UNIT}};',
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets' => 'right: {{SIZE}}{{UNIT}};',
               ],
               'condition' => [
                  'mae_as_pagination_type' => ['bullets', 'fraction']
               ]
            ]
         );  
         // bullets size
         $this->add_responsive_control(
            'mae_as_bullets_size',
            [
               'label' => __( 'Size', 'magnific-addons' ),
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
                  'size' => 7,
               ],
               'selectors' => [
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets .swiper-pagination-bullet ' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
               ],
               'condition' => [
                  'mae_as_pagination_type' => 'bullets'
               ]
            ]
         );
         // bullets size
         $this->add_responsive_control(
            'mae_as_bullets_spacing',
            [
               'label' => __( 'Spacing', 'magnific-addons' ),
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
                  'size' => 5,
               ],
               'selectors' => [
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets .swiper-pagination-bullet ' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
               ],
               'condition' => [
                  'mae_as_pagination_type' => 'bullets'
               ]
            ]
         );
         // bullets size
         $this->add_control(
            'mae_as_bullets_color_active',
            [
               'label' => __( 'Color', 'magnific-addons' ),
               'type' => Controls_Manager::COLOR,
               'default' => "#000",
               'selectors' => [
                  '{{WRAPPER}} .mae_as_pagination .mae_as_bullets .swiper-pagination-bullet ' => 'background-color: {{VALUE}}',
               ],
               'condition' => [
                  'mae_as_pagination_type' => 'bullets'
               ]
            ]
         );


      $this->end_controls_section(); 
















	}

	public function get_script_depends() {
		return [ 'mae_widgets-script' ];
   }
   

	public function get_style_depends() {
		return [ 'mae_widgets-styles' ];
	}










   protected function render() {

      $widget_settings = $this->get_settings_for_display();

      $custom_css = '';

      $slider_settings = array(
         'enabled' => $widget_settings['mae_as_enabled'],
         'element' => $widget_settings['mae_as_target'],
         'speed' => $widget_settings['mae_as_speed'],
         'effect' => $widget_settings['mae_as_effect'],
         'autoplay' => $widget_settings['mae_as_autoplay'],
         'autoplay_delay' => $widget_settings['mae_as_autoplay_delay'],
         'loop' => $widget_settings['mae_as_loop'],
         'parallax' => $widget_settings['mae_as_parallax'],
         'pause_on_hover' => $widget_settings['mae_as_autoplay_pause_on_hover'],
      );

      // FADE SETTINGS
      $slider_settings['fade']['crossfade'] = $widget_settings['mae_as_fade_crossfade'] ? true : false;


      // COVERFLOW SETTINGS
      if($widget_settings['mae_as_effect'] == 'coverflow') {
         $slider_settings['coverflow'] = array(
            'slideShadows' => $widget_settings['mae_as_coverflow_shadows'] ?: false,
         );
      }


      // CENTERED
      $slider_settings['centeredSlides'] = $widget_settings['mae_as_centered'] ?: false;
      $slider_settings['centeredSlidesBounds'] = $widget_settings['mae_as_centered_bounds'] ?: false;



      
      // allways fire slider on frontend
      if ( !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
         $slider_settings['enabled'] = '1';
         $slider_settings['front'] = '1';
      } 


      // breakpoints for horizontal direction
      if ($widget_settings['mae_as_effect'] == 'slide' || $widget_settings['mae_as_effect'] == 'coverflow') {
         $breakpoints = Responsive::get_breakpoints();
         // error_log( print_r($breakpoints, true) );
         $slider_settings['breakpoints'] = array(
            'desktop' => array(
               'slidesPerView' => $widget_settings['mae_as_slidesPerView'] ?: '0',
               'spaceBetween' => $widget_settings['mae_as_space_between']['size'],
            ),
            'tablet' => array(
               'slidesPerView' => $widget_settings['mae_as_slidesPerView_tablet'] ?: $widget_settings['mae_as_slidesPerView'],
               'spaceBetween' => $widget_settings['mae_as_space_between_tablet']['size'] ?: $widget_settings['mae_as_space_between']['size'],

            ),
            'mobile' => array(
               'slidesPerView' => $widget_settings['mae_as_slidesPerView_mobile'] ?: ($widget_settings['mae_as_slidesPerView_tablet'] ?: $widget_settings['mae_as_slidesPerView']),
               'spaceBetween' => $widget_settings['mae_as_space_between_mobile']['size'] ?: ($widget_settings['mae_as_space_between_tablet']['size'] ?: $widget_settings['mae_as_space_between']['size']),
            ),
         );
      }
      



      
      // legacy DOM
      $slider_settings['optimized_dom'] = \Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' );


      // styles for frontend
      if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {

         $custom_css .= 
         $widget_settings['mae_as_target'] . ' {
            opacity: 0;
         }';

         $custom_css .= 
         $widget_settings['mae_as_target'] . ' .swiper-wrapper {
            display: flex !important;
            flex-wrap: nowrap !important;
            grid-column-gap: 0;
         }';

         $custom_css .= 
         $widget_settings['mae_as_target'] . ' .swiper-wrapper {
            flex-wrap: nowrap !important;
         }';

         $custom_css .= 
         $widget_settings['mae_as_target'] . ' .swiper-wrapper {
            flex-wrap: nowrap !important;
         }';

      } else {
         $custom_css .= 
         $widget_settings['mae_as_target'] . ' .swiper-wrapper {
            display: flex !important;
            flex-wrap: nowrap !important;
            grid-column-gap: 0;
         }';         
      }

   
      // NAVIGATION
      // arrows
      $slider_settings['navigation']['enabled'] = $widget_settings['mae_as_navigation'];
      if ($widget_settings['mae_as_navigation'] == '1') {

         // icons
         if ($widget_settings['mae_as_arrows_type'] == 'icon') {

               ob_start();
                  ?><div class="advanced-swiper-button-prev"><?php \Elementor\Icons_Manager::render_icon( $widget_settings['mae_as_arrows_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></div><?php
               $slider_settings['navigation']['prev_button'] = str_replace(array("\r\n", "\r", "\n", "\t"), "",ob_get_clean());

               ob_start();
                  ?><div class="advanced-swiper-button-next"><?php \Elementor\Icons_Manager::render_icon( $widget_settings['mae_as_arrows_next_icon'], [ 'aria-hidden' => 'true' ] ); ?></div><?php
               $slider_settings['navigation']['next_button'] = str_replace(array("\r\n", "\r", "\n", "\t"), "",ob_get_clean());

         }

         // images
         if ($widget_settings['mae_as_arrows_type'] == 'image') {

            $slider_settings['navigation']['prev_button'] = '<div class="advanced-swiper-button-prev"><div class="image"><img src="' . $widget_settings['mae_as_arrows_prev_image']['url'] . '"/></div></div>';
            $slider_settings['navigation']['next_button'] = '<div class="advanced-swiper-button-next"><div class="image"><img src="' . $widget_settings['mae_as_arrows_next_image']['url'] . '"/></div></div>';      

         }

      }



      // PAGINATION
      $slider_settings['pagination']['enabled'] = $widget_settings['mae_as_pagination'];
      $slider_settings['pagination']['type'] = $widget_settings['mae_as_pagination_type'];


      // SCROLLBAR
      $slider_settings['scrollbar']['enabled'] = $widget_settings['mae_as_scrollbar'];
    
      

      // custom swiper settings
      $custom_settings_string = str_replace(array("\r\n", "\r", "\n", "\t"), "", $widget_settings['mae_as_custom_settings']);
      $custom_settings_string = str_replace(' ', '', $custom_settings_string);
      $slider_settings['custom'] = $custom_settings_string;

      
      // widget placeholder
      if ( \Elementor\Plugin::$instance->editor->is_edit_mode()) { 
         echo 'Advanced Swiper for: ' . $widget_settings['mae_as_target'];
      }

      // $slider_settings = str_replace(array("\r\n", "\r", "\n", "\t"), "", $slider_settings);

      ?>
         <script>

            //console.log('PHP');

            var as_<?php echo $this->get_id(); ?>_settings = '<?php echo str_replace("\u0022","\\\\\"",json_encode($slider_settings,JSON_HEX_QUOT)); ?>';


         </script>


         <style>

            <?php echo $custom_css; ?> 

         </style>


      <?php


   }

   protected function _content_template() {

      echo 'Advanced Swiper for: {{settings.mae_as_target}}';

		?>

      <# 

         console.log('JS');

         var changed_control = Object.keys(view.model.attributes.settings.changed)[0]; 
         console.log(changed_control);


         // view.model.attributes.settings.attributes._title = settings.mae_as_target;

         //console.log(view.model.attributes.settings.controls);


         // if first run then create backup object with selectors
         if (typeof window['mae_asw_prototype_' + view.model.id] === 'undefined') {
            var temp = {};
            for ( var control in view.model.attributes.settings.controls ) {
               if (control.includes('mae_as_') && view.model.attributes.settings.controls[control].selectors) {
                     temp[control] = view.model.attributes.settings.controls[control].selectors;
               }
            }
            window['mae_asw_prototype_' + view.model.id] = temp;
         }

         // assign selector to model
         if (typeof window['mae_asw_updated_' + view.model.id] === 'undefined' || changed_control == 'mae_as_target') {
            console.log('replace');
            var temp = window['mae_asw_prototype_' + view.model.id];
            for ( var control in view.model.attributes.settings.controls ) {
               if (control.includes('mae_as_') && view.model.attributes.settings.controls[control].selectors) {
                  delete view.model.attributes.settings.controls[control].selectors;
                  var original_selectors_string = JSON.stringify(temp[control]);
                  var new_selectors = JSON.parse(original_selectors_string.replace(/{{WRAPPER}}/g, settings.mae_as_target));
                  view.model.attributes.settings.controls[control].selectors = new_selectors;
               }
               window['mae_asw_updated_' + view.model.id] = true;
            }
         }

         //console.log(view.model.attributes.settings.controls);
         //console.log(settings); 
         //console.log(view); 





         //console.log(view.model.attributes.htmlCache);


         var controls = [
            "mae_as_target",
            "mae_as_stack",
            "mae_as_fullwidth",
            "mae_as_enabled",
            "mae_as_effect",
            "mae_as_slidesPerView",
            "mae_as_slidesPerView_tablet",
            "mae_as_slidesPerView_mobile",
            "mae_as_space_between",
            "mae_as_space_between_tablet",
            "mae_as_space_between_mobile",
            "mae_as_speed",
            "mae_as_loop",
            "mae_as_autoplay",
            "mae_as_autoplay_delay",
            "mae_as_autoplay_pause_on_hover",
            "mae_as_parallax",
            "mae_as_navigation",
            "mae_as_arrows_type",
            "mae_as_arrows_prev_icon",
            "mae_as_arrows_prev_image",
            "mae_as_arrows_next_icon",
            "mae_as_arrows_next_image",
            "mae_as_pagination",
            "mae_as_pagination_type",
            "mae_as_scrollbar",
            "mae_as_fade_crossfade",
            "mae_as_coverflow_shadows",
            "mae_as_centered",
            "mae_as_centered_bounds"
         ];


         if(controls.includes(changed_control)) {
            view.model.attributes.settings.changed = {};
            view.model.renderRemoteServer();
         }



      #>

      <?php


   }

}


/**
 * 
 * add widget css to post css file
 * 
 */
$add_css = new MAE_Post_CSS('mae_posts_swiper', 'mae_as_target');


