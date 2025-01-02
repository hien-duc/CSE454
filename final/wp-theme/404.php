<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12 text-center py-5">
            <h1>404</h1>
            <h2>Không tìm thấy trang</h2>
            <p>Trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Về trang chủ</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
