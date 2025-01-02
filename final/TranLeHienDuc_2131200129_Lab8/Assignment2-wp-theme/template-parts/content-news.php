<?php
/**
 * Template part for displaying news posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('news-item'); ?>>
    <div class="row">
        <div class="col-12 col-md-4">
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="news-thumbnail">
                    <?php the_post_thumbnail('medium_large', array('class' => 'img-fluid')); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-8">
            <header class="entry-header">
                <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

                <div class="entry-meta">
                    <span class="posted-on">
                        <?php echo get_the_date(); ?>
                    </span>
                    <?php if (has_category()) : ?>
                        <span class="categories">
                            <?php the_category(', '); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div>

            <footer class="entry-footer">
                <a href="<?php the_permalink(); ?>" class="read-more">Xem thêm <i class="fa fa-angle-right"></i></a>
            </footer>
        </div>
    </div>
</article>
