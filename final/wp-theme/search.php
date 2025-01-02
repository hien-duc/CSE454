<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <header class="page-header">
                <h1 class="page-title">
                    <?php printf(esc_html__('Kết quả tìm kiếm: %s', 'ducthanhcomputer'), '<span>' . get_search_query() . '</span>'); ?>
                </h1>
            </header>
        </div>
    </div>

    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="col-12 col-md-4 mb-4">
                <article id="post-<?php the_ID(); ?>" <?php post_class('h-100'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            </div>
        <?php endwhile; ?>

        <div class="col-12">
            <?php the_posts_pagination(); ?>
        </div>

        <?php else : ?>
            <div class="col-12">
                <p><?php esc_html_e('Không tìm thấy kết quả phù hợp.', 'ducthanhcomputer'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
