<?php
    if (in_category("news")) {
       include get_template_directory() . "/single-news.php";
    } else {
        include get_template_directory() . "/single-product.php";
    }

?>