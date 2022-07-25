<?php

add_action( 'rwmb_enqueue_scripts', function() {
        wp_enqueue_script( 'script-id', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), '', true );
});

add_action( 'rwmb_enqueue_scripts', function() {
        wp_enqueue_style( 'custom-meta-box-style', get_stylesheet_directory_uri(). '/resepti-style.css' );
     } );
    
add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri(). '/style.css' );
} );

add_action( 'init', function() {
        add_editor_style( 'resepti-style.css' );
} );