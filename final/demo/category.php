 <?php get_header(); ?>
<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php bloginfo('url'); ?>">Trang chu</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php single_cat_title(); ?></li>
        </ol>
    </div>
</nav>
<main id="content">
    <div class="container">
        <?php if(have_posts()) : ?>
            <div class="san-pham-group mt-25">
                <div class="title-background">
                    <h2><?php single_cat_title(); ?></h2>
                </div>
                <div class="row">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-6 col-sm-6 col-md-3">
                            <article class="group-product">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="group-info">
                                        <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
                                        <div class="info-hover"></div>
                                    </div>
                                    <div class="san-pham-title">
                                        <?php the_title(); ?>
                                    </div>
                                    <div class="san-pham-price">Gia: <span>170.000</span></div>
                                </a>
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
