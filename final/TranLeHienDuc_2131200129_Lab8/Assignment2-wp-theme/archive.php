<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    single_cat_title('Danh mục: ');
                } elseif (is_tag()) {
                    single_tag_title('Tag: ');
                } elseif (is_author()) {
                    the_post();
                    echo 'Tác giả: ' . get_the_author();
                    rewind_posts();
                }
                ?>
            </h1>
        </div>
    </div>
    
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="col-12 col-md-3">
                <div class="san-pham">
                    <a href="<?php the_permalink(); ?>">
                        <div class="san-pham-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                            <?php endif; ?>
                        </div>
                        <div class="san-pham-info">
                            <div class="san-pham-title"><?php the_title(); ?></div>
                            <?php if (get_post_meta(get_the_ID(), '_product_price', true)) : ?>
                                <div class="san-pham-price">
                                    Giá: <span><?php echo get_post_meta(get_the_ID(), '_product_price', true); ?></span>
                                </div>
                            <?php else : ?>
                                <div class="san-pham-price">Giá: <span>Liên hệ</span></div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
        
        <div class="col-12">
            <?php the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('Trước', 'ducthanhcomputer'),
                'next_text' => __('Sau', 'ducthanhcomputer'),
            )); ?>
        </div>
        
        <?php else : ?>
            <div class="col-12">
                <p><?php _e('Không tìm thấy bài viết.', 'ducthanhcomputer'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
