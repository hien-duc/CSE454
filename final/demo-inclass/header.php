<!DOCTYPE html>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <!-- crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo get_theme_file_uri("style.css"); ?>">
    <title>Demo</title> -->
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_theme_file_uri('style.css')); ?>">
    <title><?php wp_title('|', true, 'right');
    bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>


<!-- <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head> -->


<body>


    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                                    <!-- <a href=""><img src="assets/logo.png" class="logo"></a> -->
                    <!-- <a href="<?php bloginfo('url') ?>">
                        <img src="<?php bloginfo('template_url') ?> /assets/logo.png" class="logo"> -->
                <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_url(get_theme_file_uri('assets/logo.png')); ?>" class="logo"
                                alt="<?php bloginfo('name'); ?>">
                    </a>
                </div>
            <div class="col-md-8">
                    <nav>
                        <!-- <ul class="main-menu">
                            <li><a href="">Home</a></li>
                            <li>
                                <a href="">About Us</a>
                                <ul class="sub-menu">
                                    <li><a href="">Introduction</a></li>
                                    <li><a href="">Contact Us</a></li>
                                </ul>
                            </li>
                            <li><a href="">Shop</a></li>
                            <li><a href="">News</a></li>
                        </ul> -->
                        <?php
                        wp_nav_menu(
                            array(
                            'theme_location' => 'main-menu',
                            'menu_class' => 'main-menu',
                                'container' => ''
                            )
                        );
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>