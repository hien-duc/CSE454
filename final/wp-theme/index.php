<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;

                the_posts_navigation();
            else :
                ?>
                <p><?php esc_html_e('No posts found.', 'ducthanhcomputer'); ?></p>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
