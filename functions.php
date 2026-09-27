<?php
/**
 * Sri Balaji Books Custom Theme Functions
 *
 * @package SriBalajiTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Setup theme features.
 */
function sribalaji_theme_setup() {
    // Add dynamic document title support
    add_theme_support( 'title-tag' );

    // Enable featured images
    add_theme_support( 'post-thumbnails' );

    // Enable WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'sribalaji-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'sribalaji_theme_setup' );

/**
 * Enqueue theme stylesheets.
 */
function sribalaji_theme_scripts() {
    wp_enqueue_style( 'sribalaji-main-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'sribalaji_theme_scripts' );
