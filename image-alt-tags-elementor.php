<?php

    /**
     * Plugin Name: Image Alt-tags for Elementor
     * Description: Add "alt-tag" property to Elementor Image widget
     * Version: 1.0
     * Plugin URI: https://github.com/JorensM/elementor-image-alt-tags
     * License: GPLv2
     */


function j_change_image_widget_content($widget_content, $widget){
    if($widget->get_name() === "image"){

        $j_settings = $widget->get_settings();
        $alt_tag = null;

        if(!empty($j_settings["image_alt_tag"])){
            $alt_tag = $j_settings["image_alt_tag"];
        }else{
            return $widget_content;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML($widget_content);
        $selector = new DOMXPath($doc);

        $result = $selector->query("//img[@alt]");

        $has_alt = false;

        $new_widget_content = false;

        if($result->count() > 0){

            $result->item(0)->setAttribute("alt", $alt_tag);

            $html_element = $selector->query("//body")->item(0)->childNodes->item(0);

            $new_widget_content = $doc->saveHTML($html_element);
            return $new_widget_content;
        }

        return $widget_content;
    }
}

function j_add_image_widget_settings($element, $section_id, $args){
    if($element->get_name() === "image" && $section_id === "section_image"){
        $element->add_control(
			'image_alt_tag',
			[
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label' => esc_html__( 'Alt tag', 'j_widgets' ),
                'dynamic' => [
                    'active' => true,
                ],
			]
		);
    }
}

add_filter( 'elementor/widget/render_content', 'j_change_image_widget_content', 10, 2 );
add_action( 'elementor/element/before_section_end', 'j_add_image_widget_settings', 10, 3 );