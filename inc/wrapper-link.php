<?php
namespace MagnificAddons;

use \Elementor\Controls_Manager;
use \Elementor\Element_Base;

defined('ABSPATH') || die();

class Aee_Wrapper_Link {

	private static $instance;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
    }
    
    public function __construct() {
        add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'add_controls_section' ), 10 );
        add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'add_controls_section' ), 10 );
        add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'add_controls_section' ), 10 );

        add_action( 'elementor/frontend/before_render', array( $this, 'before_section_render' ), 10 );
    }

    public function add_controls_section( Element_Base $element) {
        $tabs = Controls_Manager::TAB_CONTENT;

        if ( 'section' === $element->get_name() || 'column' === $element->get_name() ) {
            $tabs = Controls_Manager::TAB_LAYOUT;
        }

        $element->start_controls_section(
            '_section_mae_wrapper_link',
            [
                'label' => __( 'MAE Wrapper Link', 'magnific-addons' ),
                'tab'   => $tabs,
            ]
        );

        $element->add_control(
            'mae_element_link',
            [
                'label'       => __( 'Link', 'magnific-addons' ),
				'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => 'https://site.com',
            ]
        );

        $element->end_controls_section();
    }

    public function before_section_render( Element_Base $element ) {
        $settings = $element->get_settings_for_display();
        $mae_link  = $settings['mae_element_link'];
        if ( $mae_link && !empty( $mae_link['url'] ) ) {
            $element->add_render_attribute(
                '_wrapper',
                [
                    'data-mae-element-link' => json_encode( $mae_link ),
                    'style' => 'cursor: pointer'
                ]
            );
        }
    }
}

