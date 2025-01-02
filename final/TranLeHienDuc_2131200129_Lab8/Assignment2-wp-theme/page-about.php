<?php
/**
 * Template Name: About Page
 */

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image">
                            <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'ducthanhcomputer'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-md-6">
            <div class="about-section">
                <h3><i class="fa fa-building"></i> Về chúng tôi</h3>
                <p>Vi tính Đức Thành chuyên cung cấp các sản phẩm máy tính, laptop, linh kiện và phụ kiện máy tính với chất lượng tốt nhất và giá cả hợp lý.</p>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="contact-section">
                <h3><i class="fa fa-phone"></i> Thông tin liên hệ</h3>
                <ul class="contact-info">
                    <li><i class="fa fa-map-marker"></i> 960 KP. 4, P. Thới Hòa, TX. Bến Cát, Bình Dương</li>
                    <li><i class="fa fa-phone"></i> 0969 609 639 - 0909 291 908</li>
                    <li><i class="fa fa-envelope"></i> vitinhducthanhbcbd@gmail.com</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
