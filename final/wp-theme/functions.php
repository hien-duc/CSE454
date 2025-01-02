<?php
if (!defined('ABSPATH')) exit;

// Include custom nav walker
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

function ducthanhcomputer_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'ducthanhcomputer'),
        'footer' => esc_html__('Footer Menu', 'ducthanhcomputer'),
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'ducthanhcomputer_setup');

function ducthanhcomputer_scripts() {
    // Enqueue Bootstrap
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    
    // Theme stylesheet
    wp_enqueue_style('ducthanhcomputer-style', get_stylesheet_uri());
    wp_enqueue_style('ducthanhcomputer-custom', get_template_directory_uri() . '/assets/css/custom.css');

    // Bootstrap JS
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '', true);
    
    // Custom scripts
    wp_enqueue_script('ducthanhcomputer-scripts', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'ducthanhcomputer_scripts');

// Register Custom Post Type for Products
function ducthanhcomputer_register_post_types() {
    register_post_type('product', array(
        'labels' => array(
            'name' => __('Sản phẩm', 'ducthanhcomputer'),
            'singular_name' => __('Sản phẩm', 'ducthanhcomputer'),
            'add_new' => __('Thêm mới', 'ducthanhcomputer'),
            'add_new_item' => __('Thêm sản phẩm mới', 'ducthanhcomputer'),
            'edit_item' => __('Sửa sản phẩm', 'ducthanhcomputer'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-cart',
        'rewrite' => array('slug' => 'san-pham'),
    ));
}
add_action('init', 'ducthanhcomputer_register_post_types');

// Register Custom Taxonomies
function ducthanhcomputer_register_taxonomies() {
    register_taxonomy('product_category', 'product', array(
        'labels' => array(
            'name' => __('Danh mục sản phẩm', 'ducthanhcomputer'),
            'singular_name' => __('Danh mục', 'ducthanhcomputer'),
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'danh-muc-san-pham'),
    ));
}
add_action('init', 'ducthanhcomputer_register_taxonomies');

// Register widget areas
function ducthanhcomputer_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer 1', 'ducthanhcomputer'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in footer.', 'ducthanhcomputer'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 2', 'ducthanhcomputer'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in footer.', 'ducthanhcomputer'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'ducthanhcomputer_widgets_init');
