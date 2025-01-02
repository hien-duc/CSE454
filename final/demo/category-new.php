
<?php get_header (); ?>
<main>
<div class="container">
<section class="news-group">
<h1 class="news-title">News</h1>
<?php if ( have_posts()) { ?> <div class="row">
<?php
?>
while (have_posts()) { the_post();
<div class="col-md-6">
<div class="media">
<!--<img
src="https://file.hstatic.net/200000017614/file/nhung-loai-họ a-dep-nhat-hoa-tigon_f8ebd14508b84b209479a98655a588ff.jpg" class="mr-3" alt="..."> -->
<?php the_post_thumbnail () ?> <div class="media-body">
<h5 class="mt-0"><a href="<?php the_permalink () ?>"><?php
the_title() ?></a></h5>
<p><?php the_excerpt() ?></p>
</div>
</div>
</div>
<?php } ?>
</div>
<?php } else { ?>
<p>No post.</p>
<?php } ?>
</section>
</div>
</main>
<?php get_footer(); ?>