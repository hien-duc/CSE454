</main><!-- #content -->

<footer class="site-footer bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="footer-title">THÔNG TIN LIÊN HỆ</div>
                <div class="contact-info">
                    <?php
                    if (is_active_sidebar('footer-1')) {
                        dynamic_sidebar('footer-1');
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="footer-title">BẢN ĐỒ</div>
                <div class="map-link">
                    <?php
                    if (is_active_sidebar('footer-2')) {
                        dynamic_sidebar('footer-2');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html><?php
