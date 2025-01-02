<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">This is a short introduction</div>
            <div class="col-md-4">
                <nav>
                    <!-- <ul class="footer-menu">
                        <li><a href="">Chính sách bảo hành</a></li>
                        <li><a href="">FAQs</a></li>
                        <li><a href="">Chỉnh sách đổi trả</a></li>
                    </ul> -->
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => "footer-menu",
                            'menu_class' => "footer-menu",
                            'container' => ''
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

</body>
</html>