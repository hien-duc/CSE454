<?php get_header(); ?>

<div class="container">
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <div class="col-12 col-md-4">
                <div class="product-gallery">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <h1 class="product-title"><?php the_title(); ?></h1>
                
                <?php if (get_post_meta(get_the_ID(), '_product_price', true)) : ?>
                    <div class="product-price">
                        Giá: <span><?php echo get_post_meta(get_the_ID(), '_product_price', true); ?></span>
                    </div>
                <?php else : ?>
                    <div class="product-price">Giá: <span>Liên hệ</span></div>
                <?php endif; ?>
                
                <div class="product-meta">
                    <?php if (get_post_meta(get_the_ID(), '_product_warranty', true)) : ?>
                        <div class="warranty">
                            Bảo hành: <?php echo get_post_meta(get_the_ID(), '_product_warranty', true); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta(get_the_ID(), '_product_status', true)) : ?>
                        <div class="status">
                            Tình trạng: <?php echo get_post_meta(get_the_ID(), '_product_status', true); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="product-description">
                    <?php the_content(); ?>
                </div>
                
                <div class="product-contact">
                    <h3>Liên hệ mua hàng</h3>
                    <p><i class="fa fa-phone"></i> <a href="tel:0969609639">0969 609 639</a> - <a href="tel:0909291908">0909 291 908</a></p>
                    <p><i class="fa fa-map-marker"></i> 960 KP. 4, P. Thới Hòa, TX. Bến Cát, Bình Dương</p>
                </div>
            </div>
            
            <?php
            // Related products
            $categories = get_the_category();
            if ($categories) {
                $category_ids = array();
                foreach ($categories as $category) $category_ids[] = $category->term_id;
                
                $args = array(
                    'category__in' => $category_ids,
                    'post__not_in' => array(get_the_ID()),
                    'posts_per_page' => 4,
                    'ignore_sticky_posts' => 1
                );
                
                $related_query = new WP_Query($args);
                
                if ($related_query->have_posts()) : ?>
                    <div class="col-12">
                        <h3 class="related-title">Sản phẩm liên quan</h3>
                        <div class="row">
                            <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
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
                        </div>
                    </div>
                <?php endif;
                wp_reset_postdata();
            }
            ?>
            
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
