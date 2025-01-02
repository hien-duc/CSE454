<?php get_header(); ?>

<main>
    <div class="container">
        <?php if (have_posts()): ?>
            <section class="products">
                <h1 class="product-title"><?php esc_html_e('Products', 'cse454'); ?></h1>
                <div class="row">
                    <?php
                    while (have_posts()):
                        the_post();
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <p class="card-text"><?php the_excerpt(); ?></p>
                                    <a href="<?php the_permalink(); ?>"
                                        class="btn btn-primary"><?php esc_html_e('Read More', 'cse454'); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php the_posts_pagination(); ?>
            </section>
        <?php else: ?>
            <p><?php esc_html_e('No posts found', 'cse454'); ?></p>
        <?php endif; ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

<?php get_footer(); ?>