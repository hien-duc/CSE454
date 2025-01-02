<?php
get_header();
?>
<main class="home-page">
    <section class="container slogan-section">
        <div class="row slogan-grid">
            <?php 
            $slogans = [
                [
                    'icon' => get_template_directory_uri() . '/images/gia-ca-canh-tranh.png',
                    'title' => 'Giá cả cạnh tranh',
                    'alt' => 'Biểu tượng giá cả cạnh tranh'
                ],
                [
                    'icon' => get_template_directory_uri() . '/images/san-pham-chinh-hang.png',
                    'title' => 'Sản phẩm chính hãng',
                    'alt' => 'Biểu tượng sản phẩm chính hãng'
                ],
                [
                    'icon' => get_template_directory_uri() . '/images/hang-hoa-da-dang.png',
                    'title' => 'Hàng hóa đa dạng',
                    'alt' => 'Biểu tượng hàng hóa đa dạng'
                ],
                [
                    'icon' => get_template_directory_uri() . '/images/dich-vu-toi-uu.png',
                    'title' => 'Dịch vụ tối ưu',
                    'alt' => 'Biểu tượng dịch vụ tối ưu'
                ]
            ];
            
            foreach ($slogans as $slogan): ?>
            <div class="col-12 col-sm-6 col-md-3">
                <article class="slogan" aria-label="<?php echo esc_attr($slogan['title']); ?>">
                    <div class="media">
                        <img src="<?php echo esc_url($slogan['icon']); ?>" 
                             class="align-self-center mr-3" 
                             alt="<?php echo esc_attr($slogan['alt']); ?>">
                        <div class="media-body">
                            <h5 class="slogan-title"><?php echo esc_html($slogan['title']); ?></h5>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container">
        <div class="san-pham-group mt-25">
            <div class="title-background">
                <h2>Laptop</h2>
            </div>

            <div class="row">
                <?php
                $args = array(
                    "category_name" => "Laptop",
                    "posts_per_page" => 4,
                );
                $results = new WP_QUERY($args);
                ?>
                <?php
                while ($results->have_posts()) {
                    $results->the_post();
                    ?>
                    <div class="col-6 col-sm-6 col-md-3">
                        <article class="group-product">
                            <a href="<?php the_permalink() ?>">
                                <div class="group-info">
                                    <?php the_post_thumbnail("full", ['class' => 'img-fluid']); ?>
                                    <div class="info-hover"></div>
                                </div>
                                <div class="san-pham-title"><?php the_title() ?></div>
                                <div class="san-pham-price">Giá: <span>170.000</span></div>
                            </a>
                        </article>
                    </div>
                <?php }
                ?>
            </div>

        </div>
        <div class="loi-cam-on">
            Vi tính <b>ĐỨC THÀNH</b> xin cảm ơn Quý khách đã tin tưởng và sử dụng sản phẩm của chúng tôi
        </div>

        <!-- Laptop -->


        <!-- Màn hình -->

        <!-- Gears -->

        <!-- Bàn ghế Gaming -->

        <!-- Camera -->

    </section>

    <section class="news container">
        <header>
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('tin-tuc'))); ?>">
                <h3 class="news-title"><span>TIN TỨC</span></h3>
            </a>
        </header>
        
        <?php
        $news_query = new WP_Query([
            'category_name' => 'tin-tuc',
            'posts_per_page' => 3
        ]);
        
        if ($news_query->have_posts()): ?>
        <div class="row news-grid">
            <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
            <div class="col-md-4">
                <article class="news-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()): ?>
                        <figure>
                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid', 'alt' => get_the_title()]); ?>
                        </figure>
                        <?php endif; ?>
                        <h4><?php the_title(); ?></h4>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                    </a>
                </article>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>
    </section>
</main>
<?php get_footer(); ?>