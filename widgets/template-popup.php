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


class Aew_Template_Popup_Widget extends Widget_Base {

	public function get_name() {
		return 'mae_template_popup';
	}

	public function get_title() {
		return __( 'Template Popup', 'magnific-addons' );
	}

	public function get_icon() {
		return 'eicon-lightbox';
	}

	public function get_categories() {
		return [ 'ae-category' ];
	}

	protected function switcher_styles() {
		ob_start(); ?>
			<style>
				.mae-type-switcher .elementor-choices label {
					width: auto;
					padding: 0 10px;
				}
				.mae-type-switcher .elementor-choices label:before {
					content: attr(original-title);
					/* margin-right: 4px; */
				}
			</style>
		<?php return ob_get_clean();
	}

	// public function get_style_depends() {
	// 	return [ 'advanced-elementor-widgets-style' ];
	// }

	public function get_document_types() {
		return \ElementorPro\Plugin::elementor()->documents->get_document_types( [
			'show_in_library' => true,
		] );
	}

	protected function _register_controls() {

		// MAIN SECTION
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Template', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
      );


			$this->add_control(
				'template_id',
				[
					'label' => __( 'Choose Template', 'magnific-addons' ),
					'type' => QueryControlModule::QUERY_CONTROL_ID,
					'label_block' => true,
					'autocomplete' => [
						'object' =>QueryControlModule::QUERY_OBJECT_LIBRARY_TEMPLATE,
						'query' => [
							'meta_query' => [
								[
									'key' => Document::TYPE_META_KEY,
									'value' => array_keys( $this->get_document_types() ),
									'compare' => 'IN',
								],
							],
						],
					],
				]
			);

			$this->add_control(
				'type',
				[
					'label' => __( 'Type', 'magnific-addons' ),
					// 'label_block' => true,
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'dropdown' => [
							'title' => __( 'Dropdown', 'magnific-addons' ),
							// 'icon' => 'fa fa-align-left',
						],
						'offcanvas' => [
							'title' => __( 'Off-canvas', 'magnific-addons' ),
							// 'icon' => 'fa fa-align-center',
						],
					],
					'default' => 'dropdown',
					'toggle' => false,
					'classes' => 'mae-type-switcher'
				]
			);
			$this->add_control(
				'switcher_styles',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => $this->switcher_styles(),
				]
			);

			$this->add_control(
				'css_load',
				[
					'label' => __( 'CSS Load', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '0',
					'options' => [
						'0' => __( 'External', 'magnific-addons' ),
						'1' => __( 'Inline', 'magnific-addons' ),
					],
				]
			);

      $this->end_controls_section(); 








		// TOGGLE SECTION
		$this->start_controls_section(
			'section_toggle',
			[
				'label' => __( 'Toggle', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'icon_type',
				[
					'label' => __( 'Icon Type', 'magnific-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'icon'    => [
							'title' => __( 'Icon', 'magnific-addons' ),
							'icon' => 'eicon-star',
						],
						'image' => [
							'title' => __( 'Image', 'magnific-addons' ),
							'icon' => 'eicon-image-bold',
						],
					],
					'default' => 'icon',
					'toggle' => false,
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
					'condition' => [
						'icon_type' => 'icon',
					]
				]
			);
			$this->add_control(
				'active_icon',
				[
					'label' => __( 'Active Icon', 'magnific-addons' ),
					'label_block' => false,
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-times',
						'library' => 'solid',
					],
					'skin' => 'inline',
					'condition' => [
						'icon_type' => 'icon',
					]
				]
			);
			$this->add_control(
				'image',
				[
					'label' => __( 'Icon', 'magnific-addons' ),
					'label_block' => false,
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'skin' => 'inline',
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'icon_type' => 'image',
					]
				]
			);
			$this->add_control(
				'active_image',
				[
					'label' => __( 'Active Icon', 'magnific-addons' ),
					'label_block' => false,
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'skin' => 'inline',
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'icon_type' => 'image',
					]
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
					'dynamic' => [
						'active' => true,
					],
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
			'section_dropdown',
			[
				'label' => __( 'Dropdown', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'	=> [
					'type' => 'dropdown'
				]
			]
		);
		
			$this->add_control(
				'content_width_type',
				[
					'label' => __( 'Width', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'auto',
					'options' => [
						'auto'  => __( 'Auto', 'magnific-addons' ),
						'full' => __( 'Page', 'magnific-addons' ),
						'section' => __( 'Section', 'magnific-addons' ),
						'column' => __( 'Column', 'magnific-addons' ),
						'selector' => __( 'Custom Selector', 'magnific-addons' ),
						'custom' => __( 'Custom', 'magnific-addons' ),
					],
					'frontend_available' => true,
				]
			);		
			$this->add_responsive_control(
				'content_width',
				[
					'label' => __( 'Custom Width', 'magnific-addons' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 2000,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 700,
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
				'content_width_selector',
				[
					'label' => __( 'Selector', 'magnific-addons' ),
					'label_block' => true,
					'show_label' => false,
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( '.selector-class', 'magnific-addons' ),
					'frontend_available' => true,

					'condition' => [
						'content_width_type' => ['selector']
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
					'condition' => [
						'content_width_type' => ['custom', 'auto']
					]
				]
			);		
			$this->add_control(
				'content_background_color',
				[
					'label' => __( 'Background Color', 'magnific-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .mae-toggle-content .elementor' => 'background-color: {{VALUE}}',
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
						'{{WRAPPER}} .mae-toggle-content .elementor' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .mae-toggle-content .elementor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'label' => __( 'Border', 'magnific-addons' ),
					'selector' => '{{WRAPPER}} .mae-toggle-content .elementor',
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
						'{{WRAPPER}} .mae-toggle-content .elementor' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'content_box_shadow',
					'label' => __( 'Box Shadow', 'magnific-addons' ),
					'selector' => '{{WRAPPER}} .mae-toggle-content .elementor',
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
						'{{WRAPPER}} .mae-toggle-content' => 'animation: {{content_animation_duration.VALUE}}ms {{VALUE}}Out;',
						'{{WRAPPER}} .mae-toggle-content.active' => 'animation: {{content_animation_duration.VALUE}}ms {{VALUE}}In;',
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
















		// OFFCANVAS SECTION
		$this->start_controls_section(
			'section_offcanvas',
			[
				'label' => __( 'Off-canvas', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'	=> [
					'type' => 'offcanvas'
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
		
		$title = $settings['title'];

		$this->add_inline_editing_attributes( 'title', 'none' );

		$wpml_treanslated_template_id = apply_filters( 'wpml_object_id', $settings['template_id'], get_post_type($settings['template_id']), true );

		?>

		<div class="mae-toggle-button" role="button">

			<span class="button-icon">

				<?php 
					if($settings['icon_type'] == 'icon') {
						\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true', 'class' => 'normal' ] );
						\Elementor\Icons_Manager::render_icon( $settings['active_icon'], [ 'aria-hidden' => 'true', 'class' => 'active' ] );
					}
					if($settings['icon_type'] == 'image') {
						echo '<img src="' . $settings['image']['url'] . '" class="normal">';
						echo '<img src="' . $settings['active_image']['url'] . '" class="active">';
					}
				
				?>
			</span>
			<span class="button-spacer"></span>
			<span class="button-title">
				<?php echo $title; ?>
			</span>

		</div>




		<div class="mae-toggle-content">
			<?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $wpml_treanslated_template_id, boolval($settings['css_load'])) ?>
		</div>






		<?php

		$front_settings = [
			'width_type' => $settings['content_width_type'],
			'is_editor' => \Elementor\Plugin::$instance->editor->is_edit_mode(),
		];

		?>



		<script>

		var pm_<?php echo $this->get_id(); ?>_settings = '<?php echo str_replace("\u0022","\\\\\"",json_encode($front_settings,JSON_HEX_QUOT)); ?>'; // cleanup JSON

		</script>

		<?php

	}
	
	public function render_plain_content() {}


}






