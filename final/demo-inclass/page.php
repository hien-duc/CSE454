<?php
get_header();
?>
<main>
    <div class="container">
        <?php
        while (have_posts()) {
            the_post();
            ?>

            <h1><?php the_title() ?></h1>
            <div class="content">
                <?php the_content() ?>
            </div>
        <?php } ?>
    </div>
</main>
<?php get_footer(); ?>