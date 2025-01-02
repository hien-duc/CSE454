<?php get_header(); ?>
<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php bloginfo('url') ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php the_title() ?></li>
        </ol>
    </div>
</nav>
<main id="content">
    <div class="container">
        <article id="post-339" class="post-339 post type-post status-publish format-standard has-post-thumbnail hentry category-gears category-san-pham-ban-chay">
            <div class="row">




                <?php
                while (have_posts()) {
                    the_post();
                ?>
                    <div class="col-12 col-sm-12 col-md-4">
                        <div id="custCarousel" class="carousel slide" data-ride="carousel" align="center">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <?php the_post_thumbnail("full", ['class' => 'd-block w-100']); ?> </div>
                            </div>
                            <a class="carousel-control-prev" href="#custCarousel" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a>
                            <a class="carousel-control-next" href="#custCarousel" data-slide="next"> <span class="carousel-control-next-icon"></span> </a>
                            <ol class="carousel-indicators list-inline">
                                <li class="list-inline-item active">
                                    <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#custCarousel">
                                    <?php the_post_thumbnail("full", ['class' => 'img-fluid']); ?>                                    </a>
                                </li>
                            </ol>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-8">
                        <h1 class="entry-title"><?php the_title() ?></h1>
                        <div class="entry-price">Giá: <span><?php the_field("product_price", get_the_ID()) ?></span></div>
                        <div class="entry-content">
                            <p><?php the_content() ?></p>
                        </div>
                        <div class="promotion-groups">
                            <div class="promotion-title">Khuyến mãi</div>
                            <div class="promotion-detail">Bảo hành 24 tháng</div>
                        </div>

                    </div>
                <?php }
                ?>
            </div>
            <div class="detail-product">
                <h2 class="product-sub-title"><span>MÔ TẢ SẢN PHẨM</span></h2>
            </div>
        </article>

        <div class="related-article">
            


        </div>
    </div>
</main>

<?php get_footer(); ?>