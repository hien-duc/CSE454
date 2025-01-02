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
        <?php
        while (have_posts()) {
            the_post();
        ?>
            <article id="post-55" class="post-55 post type-post status-publish format-standard has-post-thumbnail hentry category-tin-tuc">
                <h1 class="entry-title"><?php the_title() ?></h1>
                <div class="entry-content">
                    <p><?php the_content() ?></p>
                </div>
            </article>
        <?php }
        ?>
        <div class="related-article">
            <h2 class="block-title line-left mb-40">Bài viết cùng chuyên mục</h2>
            <div class="row">

            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>