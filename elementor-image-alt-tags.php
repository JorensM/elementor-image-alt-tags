<?php

    /**
     * Plugin Name: Elementor Image Alt-tags
     */


function j_change_image_widget_content($widget_content, $widget){
    if($widget->get_name() === "image"){
        echo "<pre>";
        echo $widget_content;
        echo "</pre>";
    }
}