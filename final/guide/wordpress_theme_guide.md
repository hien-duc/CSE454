# WordPress Theme Development Guide

## Overview
This guide will help you create a WordPress theme with specific requirements including header/footer separation, post thumbnails, navigation menus, and custom sections.

## Requirements Checklist
- [ ] Separate Header and Footer
- [ ] Enable Post Thumbnails
- [ ] Register Navigation Menus
- [ ] Service Section
- [ ] News Section
- [ ] News Category Page
- [ ] Search Page for News

## Step-by-Step Instructions

### 1. Header and Footer Separation (10 points)

#### In header.php:
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <!-- Your header content -->
        <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
    </header>
```

#### In footer.php:
```php
    <footer>
        <?php wp_nav_menu(array('theme_location' => 'footer-menu')); ?>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
```

#### Usage in template files:
```php
<?php 
get_header();
// Your content here
get_footer();
?>
```

### 2. Enable Post Thumbnails (5 points)

Add to functions.php:
```php
function theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');
```

### 3. Register Navigation Menus (15 points)

Add to functions.php:
```php
function register_theme_menus() {
    register_nav_menus(array(
        'main-menu' => 'Main Menu',
        'footer-menu' => 'Footer Menu'
    ));
}
add_action('init', 'register_theme_menus');
```

### 4. Service Section (5 points)

Create a section in index.php:
```php
<section class="services">
    <?php 
    $args = array(
        'post_type' => 'post',
        'category_name' => 'services',
        'posts_per_page' => -1
    );
    $services_query = new WP_Query($args);
    
    if($services_query->have_posts()) :
        while($services_query->have_posts()) : $services_query->the_post();
    ?>
        <article>
            <?php if(has_post_thumbnail()): ?>
                <?php the_post_thumbnail(); ?>
            <?php endif; ?>
            <h2><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
        </article>
    <?php 
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</section>
```

### 5. News Section (15 points)

Add to index.php:
```php
<section class="news">
    <?php 
    $args = array(
        'post_type' => 'post',
        'category_name' => 'news',
        'posts_per_page' => 6
    );
    $news_query = new WP_Query($args);
    
    if($news_query->have_posts()) :
        while($news_query->have_posts()) : $news_query->the_post();
    ?>
        <article>
            <?php if(has_post_thumbnail()): ?>
                <?php the_post_thumbnail(); ?>
            <?php endif; ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="meta">
                <?php echo get_the_date(); ?> | <?php the_author(); ?>
            </div>
            <?php the_excerpt(); ?>
        </article>
    <?php 
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</section>
```

### 6. News Category Page (10 points)

Create/modify category.php:
```php
<?php get_header(); ?>

<div class="category-news">
    <h1><?php single_cat_title(); ?></h1>
    
    <?php if(have_posts()) : ?>
        <div class="news-grid">
            <?php while(have_posts()) : the_post(); ?>
                <article>
                    <?php if(has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail(); ?>
                        </a>
                    <?php endif; ?>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        </div>
        
        <?php the_posts_pagination(); ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
```

### 7. Search Page for News Category (10 points)

Create search.php:
```php
<?php get_header(); ?>

<div class="search-results">
    <h1>Search Results for: <?php echo get_search_query(); ?></h1>
    
    <?php
    $args = array(
        'post_type' => 'post',
        'category_name' => 'news',
        's' => get_search_query()
    );
    $search_query = new WP_Query($args);
    
    if($search_query->have_posts()) :
        while($search_query->have_posts()) : $search_query->the_post();
    ?>
        <article>
            <?php if(has_post_thumbnail()): ?>
                <?php the_post_thumbnail(); ?>
            <?php endif; ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
        </article>
    <?php 
        endwhile;
        wp_reset_postdata();
    else:
        echo '<p>No news items found matching your search.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
```

## Additional Notes

1. **Theme Structure**
   - Keep all files properly organized
   - Use meaningful names for functions and variables
   - Comment your code for better readability

2. **CSS Styling**
   - Add appropriate CSS classes for styling
   - Make sure the design is responsive
   - Test on different screen sizes

3. **Testing Checklist**
   - [ ] Test all navigation menus
   - [ ] Verify post thumbnails display correctly
   - [ ] Check service section layout
   - [ ] Ensure news section shows latest posts
   - [ ] Test category page pagination
   - [ ] Verify search functionality for news items

4. **Common Issues**
   - Remember to flush permalinks after making changes
   - Clear cache when testing changes
   - Check for PHP errors in debug mode
