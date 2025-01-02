<?php
get_header();
?>
<main>
    <div class="container">
        <section class="products">
            <h1 class="product-title">Laptop</h1>
            <?php if (have_posts()) { ?>
                <div class="row">
                    <?php
                    while (have_posts()) {
                        the_post();
                        ?>
                        <div class="col-md-6">
                            <div class="card">
                                <?php the_post_thumbnail(); ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php the_title(); ?>
                                    </h5>
                                    <p class="card-text"><?php the_excerpt(); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php the_tiltle(); ?>More
                                        detail</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No product</p>
            <?php } ?>
        </section>

    </div>
</main>
<?php get_footer(); ?>