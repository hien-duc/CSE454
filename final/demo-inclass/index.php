<?php get_header(); ?>

<main>
    <div class="container">
        <?php dynamic_sidebar("main-section-index"); ?>

        <?php
        $args = array(
            "category_name" => "laptop-1",
            "posts_per_page" => 4
        );

        $results = new WP_Query($args);

        if ($results->have_posts()) {
            ?>
            <section class="products">
                <h1 class="product-title">Laptop</h1>
                <div class="row">
                    <?php
                    while ($results->have_posts()) {
                        $results->the_post();
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <?php the_post_thumbnail() ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <p class="card-text"><?php the_excerpt(); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">More detail</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
            <?php
        }
        ?>

        <section class="products">
            <h1 class="product-title">Laptop</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <img src="https://file.hstatic.net/200000017614/file/nhung-loai-hoa-dep-nhat-hoa-tigon_f8ebd14508b84b209479a98655a588ff.jpg"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="news-group">
            <h1 class="news-title">News</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="media">
                        <img src="https://file.hstatic.net/200000017614/file/nhung-loai-hoa-dep-nhat-hoa-tigon_f8ebd14508b84b209479a98655a588ff.jpg"
                            class="mr-3" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0">Media heading</h5>
                            <p>Will you do the same for me? It's time to face the music I'm no longer your muse. Heard
                                it's beautiful, be the judge and my girls gonna take a vote.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="media">
                        <img src="https://file.hstatic.net/200000017614/file/nhung-loai-hoa-dep-nhat-hoa-tigon_f8ebd14508b84b209479a98655a588ff.jpg"
                            class="mr-3" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0">Media heading</h5>
                            <p>Will you do the same for me? It's time to face the music I'm no longer your muse. Heard
                                it's beautiful, be the judge and my girls gonna take a vote.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>