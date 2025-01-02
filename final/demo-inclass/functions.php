<?php
add_theme_support('post-thumbnails');

register_nav_menus(array(
    'primary' => __('Primary Menu'),
    'secondary' => __('Secondary Menu'),
));

// Register sidebar for widget 
function register_my_sidebar()
{
    register_sidebar(
        array(
            'name' => 'Main Section - Index',
            'id' => 'main-section-index',
            'description' => 'Widgets in this area will be shown on index page.',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        )
    );
}
add_action('widgets_init', 'register_my_sidebar');


class Product_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'product-widget',
            'Product Widget',
            array(
                'description' => 'This is a product widget.'
            )
        );
    }

    public function widget($args, $instance)
    {
        $arg = array(
            "category_name" => $instance['cat-id'],
            "posts_per_page" => 4
        );

        $results = new WP_Query($arg);
        //if ($results->have_posts()) {
        ?>
        <section class="products">
            <h1 class="product-title"><?php echo $instance['cat-id'] ?></h1>
            <div class="row">
                <?php while ($results->have_posts()) {
                    $results->the_post();
                    ?>
                    <div class="col-md-3">
                        <div class="card">
                            <?php the_post_thumbnail() ?>
                            <div class="card-body">
                                <h5 class="card-title"> <?php the_title() ?></h5>
                                <p class="card-text"><?php the_excerpt() ?></p> <a href="<?php the_permalink() ?>"
                                    class="btn btn-primary">More detail</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php //}
    }

    public function form($instance)
    {
        $catID = !empty($instance['cat-id']) ? $instance['cat-id'] : "";
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat-id')); ?>">Type Your category slug:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('cat-id')); ?>"
                name="<?php echo esc_attr($this->get_field_name('cat-id')); ?>" type="text"
                value="<?php echo esc_attr($catID); ?>">
        </p>
        <?php
    }


    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['cat-id'] = (!empty($new_instance['cat-id'])) ? sanitize_text_field($new_instance['cat-id']) : '';
        return $instance;
    }
}

add_action('widgets_init', function () {
    register_widget('Product_Widget');
});