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


class Aew_Cart_Popup_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_cart_dropdown';
	}

	public function get_title() {
		return __( 'Cart Dropdown', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-lightbox';
	}

	public function get_categories() {
		return [ 'ae-category' ];
	}


	// public function get_style_depends() {
	// 	return [ 'advanced-elementor-widgets-style' ];
	// }

	protected function _register_controls() {


		// TOGGLE SECTION
		$this->start_controls_section(
			'section_toggle',
			[
				'label' => __( 'Button', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'icon',
				[
					'label' => __( 'Icon', 'magnific-addons' ),
					'label_block' => false,
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-bars',
						'library' => 'solid',
					],
					'skin' => 'inline',
				]
			);
			$this->add_responsive_control(
				'icon_align',
				[
					'label' => __( 'Icon Alignment', 'magnific-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
							'title' => __( 'Left', 'magnific-addons' ),
							'icon' => 'eicon-arrow-left',
						],
						'right' => [
							'title' => __( 'Right', 'magnific-addons' ),
							'icon' => 'eicon-arrow-right',
						],
						'top' => [
							'title' => __( 'Top', 'magnific-addons' ),
							'icon' => 'eicon-arrow-up',
						],
						'bottom' => [
							'title' => __( 'Bottom', 'elemadvanced-elementor-widgetsentor' ),
							'icon' => 'eicon-arrow-down',
						],
					],
					'prefix_class' => 'mae-icon-align%s-',
					'default' => 'left',
					'toggle' => false,
				]
			);			
			$this->add_responsive_control(
				'icon_size',
				[
					'label' => __( 'Icon Size', 'elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .button-icon' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'icon_indent',
				[
					'label' => __( 'Icon Spacing', 'magnific-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default' => [
						'top' => '0',
						'right' => '5',
						'bottom' => '0',
						'left' => '0',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .button-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .button-icon' => 'color: {{VALUE}}',
					],
				]
			);



			$this->add_control(
				'hr_title',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
			$this->add_control(
				'title_heading',
				[
					'label' => __( 'Title', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'magnific-addons' ),
					'label_block' => true,
					'show_label' => false,
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Click here', 'magnific-addons' ),
					'placeholder' => __( 'Click here', 'magnific-addons' ),
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'scheme' => [
						'type' => \Elementor\Core\Schemes\Color::get_type(),
						'value' => \Elementor\Core\Schemes\Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-button' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => __( 'Typography', 'magnific-addons' ),
					'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .mae-toggle-button',
				]
			);			




			$this->add_control(
				'hr_box',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
			$this->add_control(
				'box_heading',
				[
					'label' => __( 'Button', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);		
			$this->add_control(
				'toggle_background_color',
				[
					'label' => __( 'Background Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'scheme' => [
						'type' => \Elementor\Core\Schemes\Color::get_type(),
						'value' => \Elementor\Core\Schemes\Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-button' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
							'title' => __( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'prefix_class' => 'mae-button-align-',
					'default' => 'left',
				]
			);
			$this->add_control(
				'button_padding',
				[
					'label' => __( 'Padding', 'magnific-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default' => [
						'top' => '5',
						'right' => '10',
						'bottom' => '5',
						'left' => '10',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'label' => __( 'Border', 'magnific-addons' ),
					'fields_options' => [
						'border' => [
							'default' => 'solid',
						],
						'width' => [
							'default' => [
								'top' => '1',
								'right' => '1',
								'bottom' => '1',
								'left' => '1',
								'isLinked' => true,
							],
							'label' => 'Border Width',
						],
						'color' => [
							'default' => \Elementor\Core\Schemes\Color::COLOR_1,
							'label' => 'Border Color',
						],
					],
					'selector' => '{{WRAPPER}} .mae-toggle-button',
					'separator' => 'before',
					
				]
			);
			$this->add_control(
				'button_border_radius',
				[
					'label' => __( 'Border Radius', 'magnific-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default' => [
						'top' => '3',
						'right' => '3',
						'bottom' => '3',
						'left' => '3',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'button_box_shadow',
					'label' => __( 'Box Shadow', 'magnific-addons' ),
					'selector' => '{{WRAPPER}} .mae-toggle-button',
				]
			);



		$this->end_controls_section(); 













		// DROPDOWN SECTION
		$this->start_controls_section(
			'section_badge',
			[
				'label' => __( 'Badge', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'show_badge',
				[
					'label' => __( 'Show Badge', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'magnific-addons' ),
					'label_off' => __( 'Hide', 'magnific-addons' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control(
				'hide_empty_badge',
				[
					'label' => __( 'Hide Empty', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'magnific-addons' ),
					'label_off' => __( 'Hide', 'magnific-addons' ),
					'default' => 'yes',
					'return_value' => 'show',
					'prefix_class' => 'empty_',
					'condition' => [
						'show_badge' => 'yes',
					]
				]
			);

		$this->end_controls_section(); 











		// DROPDOWN SECTION
		$this->start_controls_section(
			'section_dropdown',
			[
				'label' => __( 'Dropdown', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
			$this->add_control(
				'content_width_type',
				[
					'label' => __( 'Width', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'custom',
					'options' => [
						'custom' => __( 'Custom', 'magnific-addons' ),
						'full' => __( 'Fullwidth', 'magnific-addons' ),
					],
					'frontend_available' => true,
				]
			);		
			$this->add_responsive_control(
				'content_width',
				[
					'label' => __( 'Custom Width', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 200,
							'max' => 700,
							'step' => 5,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 300,
					],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'content_width_type' => 'custom'
					]
				]
			);							
			$this->add_control(
				'content_align',
				[
					'label' => __( 'Content Alignment', 'magnific-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
							'title' => __( 'Left', 'magnific-addons' ),
							'icon' => 'eicon-arrow-left',
						],
						'right' => [
							'title' => __( 'Right', 'magnific-addons' ),
							'icon' => 'eicon-arrow-right',
						],
					],
					'prefix_class' => 'mae-content-align-',
					'default' => 'left',
					'toggle' => false,
				]
			);		
			$this->add_control(
				'content_background_color',
				[
					'label' => __( 'Background Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'content_margin',
				[
					'label' => __( 'Margin', 'magnific-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);			
			$this->add_responsive_control(
				'content_padding',
				[
					'label' => __( 'Padding', 'magnific-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'label' => __( 'Border', 'magnific-addons' ),
					'selector' => '{{WRAPPER}} .mae-toggle-content',
					'separator' => 'before',
					'fields_options' => [
						'width' => [
							'label' => 'Border Width',
						],
						'color' => [
							'label' => 'Border Color',
						],
					],
				]
			);
			$this->add_control(
				'content_border_radius',
				[
					'label' => __( 'Border Radius', 'magnific-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'content_box_shadow',
					'label' => __( 'Box Shadow', 'magnific-addons' ),
					'selector' => '{{WRAPPER}} .mae-toggle-content',
				]
			);



			$this->add_control(
				'content_animation_name',
				[
					'label' => __( 'Animation', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'msFadeUp',
					'options' => [
						'msFadeUp'  => __( 'Fade Up', 'magnific-addons' ),
						'msFadeDown' => __( 'Fade Down', 'magnific-addons' ),
						'msFade' => __( 'Fade', 'magnific-addons' ),
						'none' => __( 'None', 'magnific-addons' ),
					],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content' => 'animation: {{VALUE}}Out {{content_animation_duration.VALUE}}ms forwards;',
						'{{WRAPPER}} .mae-toggle-content.active' => 'animation: {{VALUE}}In {{content_animation_duration.VALUE}}ms forwards;',
					],
				]
			);	
			$this->add_control(
				'content_animation_duration',
				[
					'label' => __( 'Animation Speed', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 100,
					'max' => 2000,
					'step' => 20,
					'default' => 300,
				]
			);



      $this->end_controls_section(); 









      
	}

	public function get_script_depends() {
		return [ 'mae_widgets-script' ];
	}

   protected function render() {

		$settings = $this->get_settings_for_display();
		
		$title = $settings['title'];

		$count = WC()->cart->cart_contents_count;


		?>

		<div class="mae-toggle-button" role="button">

			<span class="button-icon">
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ) ?>
			</span>
			<span class="button-spacer"></span>
			<span class="button-title">
				<?php echo $title; ?>
			</span>
			
			<?php if($settings['show_badge'] == 'yes') { ?>
				<span class="cart-contents-count" data-counter="<?php echo esc_html($count); ?>">
					<?php echo esc_html($count); ?>
				</span> 
			<?php } ?>

		</div>




		<div class="mae-toggle-content">
		
			<div class="mini-cart">
				<?php woocommerce_mini_cart(); ?>
			</div>

		</div>






		<?php

		$front_settings = [
			'width_type' => $settings['content_width_type'],
		];

		?>



		<script>

		var cd_<?php echo $this->get_id(); ?>_settings = '<?php echo str_replace("\u0022","\\\\\"",json_encode($front_settings,JSON_HEX_QUOT)); ?>'; // cleanup JSON

		</script>

		<?php

   }


}






