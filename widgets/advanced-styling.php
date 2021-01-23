<?php
namespace MagnificAddons;

require_once( MAE_PATH . '/inc/helpers/post-css.php' );

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class Aew_Advanced_Styling_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mae_advanced_styling';
	}

	public function get_title() {
		return __( 'Advanced Styling', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-paint-brush';
	}

	public function get_categories() {
		return [ 'ae-category' ];
	}

	protected function _register_controls() {


		$this->start_controls_section( // MAIN ------------------------------------------
			'Main_section',
			[
				'label' => __( 'Selector', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


			$this->add_control(
				'element_id', [
					'label' => __( 'Class or ID', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
				]
			);

			// $this->add_control(
			// 	'item_important',
			// 	[
			// 		'label' => __( 'add !important', 'magnific-addons' ),
			// 		'type' => \Elementor\Controls_Manager::SWITCHER,
			// 		'label_on' => __( 'On', 'magnific-addons' ),
			// 		'label_off' => __( 'Off', 'magnific-addons' ),
			// 		'return_value' => 'true',
			// 		'default' => 'false',
			// 		'render_type' => 'template',
			// 		'selectors_dictionary' => [
			// 			'true' => '!important',
			// 			'false' => 'no',
			// 		],
			// 	]
			// );
			$this->add_control(
				'item_important',
				[
					'label' => __( 'add !important', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						' ' => [
							'title' => __( 'Off', 'plugin-domain' ),
							'icon' => 'eicon-ban',
						],
						'!important' => [
							'title' => __( 'On', 'plugin-domain' ),
							'icon' => 'eicon-check',
						],
					],
					'default' => ' ',
					'toggle' => false,
				]
			);
		$this->end_controls_section();




		$this->start_controls_section( // TYPOGRAPHY ------------------------------------------
			'typography_section',
			[
				'label' => __( 'Text', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			// typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'mae_ast_typography',
					'label' => __( 'Typography', 'magnific-addons' ),
					'scheme' => Scheme_Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}}',
				]
			);
			// color
			$this->add_control(
				'mae_ast_color',
				[
					'label' => __( 'Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}' => 'color: {{VALUE}}{{item_important.VALUE}}',
						'{{WRAPPER}}:after' => 'content:"{{item_important.VALUE}}"',
					],
				]
			);
			// text shadow
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'mae_ast_text_shadow',
					'label' => __( 'Text Shadow', 'magnific-addons' ),
					'selector' => '{{WRAPPER}}',
				]
			);
			// text align
			$this->add_responsive_control(
				'mae_ast_text_align',
				[
					'label' => __( 'Text Align', 'magnific-addons' ),
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
						'justify' => [
							'title' => __( 'Justified', 'magnific-addons' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}}{{item_important.VALUE}};',
					],
				]
			);
			// text vertacal align
			$this->add_responsive_control(
				'mae_ast_vertical_align',
				[
					'label' => __( 'Vertical Align', 'magnific-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'top' => [
							'top' => __( 'Left', 'magnific-addons' ),
							'icon' => 'eicon-v-align-top',
						],
						'middle' => [
							'middle' => __( 'Center', 'magnific-addons' ),
							'icon' => 'eicon-v-align-middle',
						],
						'bottom' => [
							'bottom' => __( 'Right', 'magnific-addons' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'vertical-align: {{VALUE}}{{item_important.VALUE}};',
					],
					'separator' => 'before',
				]
			);
			// white space
			$this->add_control(
				'mae_ast_word_wrap',
				[
					'label' => __( 'Word Wrap', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'normal',
					'options' => [
						'normal'  => __( 'Normal', 'magnific-addons' ),
						'break-word' => __( 'Break-word', 'magnific-addons' ),
						'initial' => __( 'Initial', 'magnific-addons' ),
						'inherit' => __( 'Inherit', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}' => 'word-wrap: {{VALUE}}{{item_important.VALUE}};',
					],
				]
			);
			// word wrap
			$this->add_control(
				'mae_ast_white_space',
				[
					'label' => __( 'White Space', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'normal',
					'options' => [
						'normal'  => __( 'Normal', 'magnific-addons' ),
						'nowrap' => __( 'Nowrap', 'magnific-addons' ),
						'pre' => __( 'Pre', 'magnific-addons' ),
						'inherit' => __( 'Inherit', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}' => 'white-space: {{VALUE}}{{item_important.VALUE}};',
					],
				]
			);
			// text indent
			$this->add_responsive_control(
				'mae_ast_text_indent',
				[
					'label' => __( 'Text Indent', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						'em' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}}' => 'text-indent: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
		$this->end_controls_section();





		$this->start_controls_section( // POSITION ------------------------------------------
			'positioning_section',
			[
				'label' => __( 'Positioning', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			// display
			$this->add_control(
				'mae_ast_display',
				[
					'label' => __( 'Display', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Default', 'magnific-addons' ),
						'block'  => __( 'Block', 'magnific-addons' ),
						'inline-block' => __( 'Inline-block', 'magnific-addons' ),
						'inline'  => __( 'Inline', 'magnific-addons' ),
						'flex'  => __( 'Flex', 'magnific-addons' ),
						'grid' => __( 'Grid', 'magnific-addons' ),
						'none' => __( 'None', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}' => 'display: {{VALUE}}{{item_important.VALUE}};',
					],
				]
			);		
			// position
			$this->add_control(
				'mae_ast_position',
				[
					'label' => __( 'Position', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Default', 'magnific-addons' ),
						'relative'  => __( 'Relative', 'magnific-addons' ),
						'absolute' => __( 'Absolute', 'magnific-addons' ),
						'fixed'  => __( 'Fixed', 'magnific-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}' => 'position: {{VALUE}}{{item_important.VALUE}};',
					],
				]
			);	
			// margin
			$this->add_responsive_control(
				'mae_ast_margin',
				[
					'label' => __( 'Margin', 'plugin-domain' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'vw', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}{{item_important.VALUE}};',
					],
					'separator' => 'before',
				]
			);
			// top
			$this->add_responsive_control(
				'mae_ast_position_top',
				[
					'label' => __( 'Top', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
					'separator' => 'before',
				]
			);
			// bottom
			$this->add_responsive_control(
				'mae_ast_position_bottom',
				[
					'label' => __( 'Bottom', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => 'bottom: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
			// left
			$this->add_responsive_control(
				'mae_ast_position_left',
				[
					'label' => __( 'Left', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
			// right
			$this->add_responsive_control(
				'mae_ast_position_right',
				[
					'label' => __( 'Right', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => 'right: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
		
		$this->end_controls_section();
		




		$this->start_controls_section( // SIZE ------------------------------------------
			'size_section',
			[
				'label' => __( 'Size', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			// padding
			$this->add_responsive_control(
				'mae_ast_padding',
				[
					'label' => __( 'Padding', 'plugin-domain' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'vw', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
			// width
			$this->add_responsive_control(
				'mae_ast_width',
				[
					'label' => __( 'Width', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'vw' => [
							'min' => 0,
							'max' => 100,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
						'em' => [
							'min' => 0,
							'max' => 100,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
					'separator' => 'before',
				]
			);
			// max-width
			$this->add_responsive_control(
				'mae_ast_max_width',
				[
					'label' => __( 'Max Width', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'vw' => [
							'min' => 0,
							'max' => 100,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
						'em' => [
							'min' => 0,
							'max' => 100,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],	
					],
					'selectors' => [
						'{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
			// height
			$this->add_responsive_control(
				'mae_ast_height',
				[
					'label' => __( 'Height', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'vw' => [
							'min' => 0,
							'max' => 100,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
						'em' => [
							'min' => 0,
							'max' => 100,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],	
					],
					'selectors' => [
						'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
					'separator' => 'before',
				]
			);
			// max-height
			$this->add_responsive_control(
				'mae_ast_max_height',
				[
					'label' => __( 'Max Height', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'vw' => [
							'min' => 0,
							'max' => 100,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
						'em' => [
							'min' => 0,
							'max' => 100,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],	
					],
					'selectors' => [
						'{{WRAPPER}}' => 'max-height: {{SIZE}}{{UNIT}}{{item_important.VALUE}};',
					],
				]
			);
		$this->end_controls_section();
		




		$this->start_controls_section( // BACKGROUND ------------------------------------------
			'background_section',
			[
				'label' => __( 'Background', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			// background
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'mae_ast_background',
					'label' => __( 'Background', 'plugin-domain' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}}',
				]
			);

		$this->end_controls_section();





		$this->start_controls_section( // BORDER AND SHADOW ------------------------------------------
			'border_shadow_section',
			[
				'label' => __( 'Border And Shodow', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			// border
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'mae_ast_border',
					'label' => __( 'Border', 'plugin-domain' ),
					'selector' => '{{WRAPPER}}',
				]
			);		
			// box-shadow
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'mae_ast_box_shadow',
					'label' => __( 'Box Shadow', 'plugin-domain' ),
					'selector' => '{{WRAPPER}}',
				]
			);
		$this->end_controls_section();
		




		$this->start_controls_section( // FLEX ------------------------------------------
			'flex_section',
			[
				'label' => __( 'Flex', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->end_controls_section();
		




		$this->start_controls_section( // GRID ------------------------------------------
			'grid_section',
			[
				'label' => __( 'Grid', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->end_controls_section();		




		$this->start_controls_section( // TRANSFORM ------------------------------------------
			'transform_section',
			[
				'label' => __( 'Transform', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			// translate x
			$this->add_responsive_control(
				'mae_ast_translate_x',
				[
					'label' => __( 'Translate X', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
						],
				]
			);	
			// translate Y
			$this->add_responsive_control(
				'mae_ast_translate_y',
				[
					'label' => __( 'Translate Y', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
				  	],
				]
			);
			// translate z
			$this->add_responsive_control(
				'mae_ast_translate_z',
				[
					'label' => __( 'Translate Z', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vw', 'vh', 'em', '%' ],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],						
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
				  	],
				]
			);
			// rotate x
			$this->add_responsive_control(
				'mae_ast_rotate_x',
				[
					'label' => __( 'Rotate X', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
						'size' => 0,
					],
					'range' => [
						'deg' => [
							'min' => -360,
							'max' => 360,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
					],
					'separator' => 'before',
				]
			);	
			// rotate y
			$this->add_responsive_control(
				'mae_ast_rotate_y',
				[
					'label' => __( 'Rotate Y', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
						'size' => 0,
					],
					'range' => [
						'deg' => [
							'min' => -360,
							'max' => 360,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
				  	],
				]
			);
			// rotate z
			$this->add_responsive_control(
				'mae_ast_rotate_z',
				[
					'label' => __( 'Rotate Z', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
						'size' => 0,
					],
					'range' => [
						'deg' => [
							'min' => -360,
							'max' => 360,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
				  	],
				]
			);
			// scale
			$this->add_responsive_control(
				'mae_ast_scale',
				[
					'label' => __( 'Scale', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default' => [
						'unit' => 'px',
						'size' => 1,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 5,
							'step' => 0.1,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
					],
					'separator' => 'before',
				]
			);	
			// skew x
			$this->add_responsive_control(
				'mae_ast_skew_x',
				[
					'label' => __( 'Skew X', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
						'size' => 0,
					],
					'range' => [
						'deg' => [
							'min' => -360,
							'max' => 360,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
					],
					'separator' => 'before',
				]
			);
			// skew y
			$this->add_responsive_control(
				'mae_ast_skew_y',
				[
					'label' => __( 'Skew Y', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
						'size' => 0,
					],
					'range' => [
						'deg' => [
							'min' => -360,
							'max' => 360,
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '',
				  	],
				]
			);

			// perspective
			$this->add_responsive_control(
				'mae_ast_perspective',
				[
					'label' => __( '3D Perspective', 'plugin-domain' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],					
					],
					'selectors' => [
						'(desktop){{WRAPPER}}' => 'transform: perspective({{SIZE}}{{UNIT}}) rotateX({{mae_ast_rotate_x.SIZE}}{{mae_ast_rotate_x.UNIT}}) rotateY({{mae_ast_rotate_y.SIZE}}{{mae_ast_rotate_y.UNIT}}) rotateZ({{mae_ast_rotate_z.SIZE}}{{mae_ast_rotate_z.UNIT}}) translateX({{mae_ast_translate_x.SIZE}}{{mae_ast_translate_x.UNIT}}) translateY({{mae_ast_translate_y.SIZE}}{{mae_ast_translate_y.UNIT}}) translateZ({{mae_ast_translate_z.SIZE}}{{mae_ast_translate_z.UNIT}}) scale({{mae_ast_scale.SIZE}}) skew({{mae_ast_skew_x.SIZE}}deg, {{mae_ast_skew_y.SIZE}}deg){{item_important.VALUE}};',
						'(tablet){{WRAPPER}}' => 'transform: translateX({{mae_ast_translate_x_tablet.SIZE}}{{mae_ast_translate_x_tablet.UNIT}}) translateY({{mae_ast_translate_y_tablet.SIZE}}{{mae_ast_translate_y_tablet.UNIT}}) translateZ({{mae_ast_translate_z_tablet.SIZE}}{{mae_ast_translate_z_tablet.UNIT}}){{item_important.VALUE}};',
						'(mobile){{WRAPPER}}' => 'transform: translateX({{mae_ast_translate_x_mobile.SIZE}}{{mae_ast_translate_x_mobile.UNIT}}) translateY({{mae_ast_translate_y_mobile.SIZE}}{{mae_ast_translate_y_mobile.UNIT}}) translateZ({{mae_ast_translate_z_mobile.SIZE}}{{mae_ast_translate_z_mobile.UNIT}}){{item_important.VALUE}};',
					],
					'separator' => 'before',
				]
			);	
			// transform-origin
			$this->add_control(
				'mae_ast_transform_origin', [
					'label' => __( 'Transform Origin', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'label_block' => false,
					'default' => 'center center',
					'selectors' => [
						'{{WRAPPER}}' => 'transform-origin: {{VALUE}}{{item_important.VALUE}}',
					],
					'separator' => 'before',
				]
			);		
			// backface-visibility
			$this->add_control(
				'mae_ast_backface_visibility',
				[
					'label' => __( 'Backface Visibility', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'magnific-addons' ),
					'label_off' => __( 'Off', 'magnific-addons' ),
					'return_value' => 'hidden',
					'default' => 'visible',
					'selectors' => [
						'{{WRAPPER}}' => 'backface-visibility: {{VALUE}}{{item_important.VALUE}}',
					],
				]
			);	
			// $this->add_control(
			// 	'mae_ast__description',
			// 	[
			// 		'raw' => '<button class="elementor-button mae_transform_reset" style="padding: 4px 10px;">RESET</button>',
			// 		'type' => Controls_Manager::RAW_HTML,
			// 		'render_type' => 'ui',
			// 	]
			// );
		$this->end_controls_section();





		$this->start_controls_section( // MISC ------------------------------------------
			'misc_section',
			[
				'label' => __( 'Misc', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->end_controls_section();		





		$this->start_controls_section( // CUSTOM ------------------------------------------
			'custom_section',
			[
				'label' => __( 'Custom', 'magnific-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->end_controls_section();

	}

   

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

		
      if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
         echo '<div class="elementor-editor-preview elementor-widget-empty">Advanced Styling: ' . $settings['element_id'] . '</div>';
      }
	}

	protected function _content_template() {
		echo '<div class="elementor-editor-preview elementor-widget-empty">Advanced Styling:{{settings.element_id}}</div>';
		?><# 

			

			// view.model.attributes.settings.attributes._title = settings.element_id;

			// console.log(elementor.config.data);


			// if first run then create backup object with selectors
			if (typeof window['mae_ast_prototype_' + view.model.id] === 'undefined') {
				var temp = {};
				for ( var control in view.model.attributes.settings.controls ) {
					if (control.includes('mae_ast_') && view.model.attributes.settings.controls[control].selectors) {
							temp[control] = view.model.attributes.settings.controls[control].selectors;
					}
				}
				window['mae_ast_prototype_' + view.model.id] = temp;
			}

			// assign selector to model
			var temp = window['mae_ast_prototype_' + view.model.id];
			for ( var control in view.model.attributes.settings.controls ) {
				if (control.includes('mae_ast_') && view.model.attributes.settings.controls[control].selectors) {
					delete view.model.attributes.settings.controls[control].selectors;
					var original_selectors_string = JSON.stringify(temp[control]);
					var new_selectors = JSON.parse(original_selectors_string.replace(/{{WRAPPER}}/g, settings.element_id));
					view.model.attributes.settings.controls[control].selectors = new_selectors;
				}
			}

			//console.log(view.model.attributes.settings.controls);

		#><?php

	}
	
}


/**
 * 
 * add widget css to post css file
 * 
 */
$add_css = new MAE_Post_CSS('mae_advanced_styling', 'element_id');

