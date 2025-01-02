<?php
get_header();
?>
<main>
    <div class="container">
        <section class="news-group">
            <h1 class="news-title">New</h1>
            <?php if (have_posts()) { ?>

                <div class="row">
                    <?php
                    while (have_posts()) {
                        the_post();
                        ?>
                        <div class="col-md-6">
                            <div class="media">
                                <?php the_post_thumbnail(); ?>
                                <div class="media-body">
                                    <h5 class="mt-0"><?php the_title(); ?><a href="<?php the_permalink(); ?>"
                                            class="btn btn-primary"><?php the_title(); ?>
                                    </h5>
                                    <p class="card-text"><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p><?php esc_html_e('No posts found', 'cse454'); ?></p>
                <p>
                    No post found
                </p>
            <?php } ?>
    </div>
</main>
<?php get_footer(); ?>


<?php
get_header();
?>
<main>
    <div class="container">
        <section class="news-group">
            <?php if (have_posts()): ?>
                <h1 class="news-title">News</h1>
                <div class="row">
                    <?php
                    while (have_posts()):
                        the_post();
                        ?>
                        <div class="col-md-6">
                            <div class="media">
                                <?php the_post_thumbnail('medium', array('class' => 'mr-3')); ?>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>
                                    <p class="card-text"><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p><?php esc_html_e('No posts found', 'cse454'); ?></p>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php get_footer(); ?>