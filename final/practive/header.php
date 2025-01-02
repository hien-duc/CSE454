<header>
    <div class="middle-header">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <a href="http://10.10.114.153/ducthanhcomputer">
                        <div class="media logo-groups">
                            <img src="http://10.10.114.153/ducthanhcomputer/wp-content/themes/ducthanh/images/logo.png"
                                class="mr-3" alt="Vi tính - laptop - camera Đức Thành">
                            <div class="media-body">
                                <h5 class="mt-0">VI TÍNH - LAPTOP - CAMERA</h5>
                                <p>ĐỨC THÀNH</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-3">
                    <form action="?<php bloginfo('url')>?" method="GET">
                        <div class="input-group search-groups">
                            <input type="text" class="form-control" name="s" placeholder="Nhập từ khóa">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Tìm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-4 righ-logo-groups">
                    <div class="righ-logo">
                        <i class="fa fa-phone"></i> <a href="tel:0969609639"><b>0969.609.639</b></a> - Mr. Đức
                    </div>
                    <div>
                        <i class="fa fa-clock-o"></i> Mở cửa từ 8h - 19h các ngày trong tuần
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom-header">
        <div class="container">
            <div class="row">
                <!-- <div class="col-12 col-md-4">
                    <div class="title-menu-groups">
                        <i class="fas fa-align-justify mgr-5"></i> <span>DANH MỤC SẢN PHẨM</span>
                    </div>
                    <div class="menu-groups">
                                            </div> -->
                <!-- &nbsp; -->
                <!-- </div> -->
                <div class="d-none d-md-block col-md-8 offset-md-4">
                    <div class="left-menu">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'main-menu',
                                'menu_class' => 'left-menu',
                                'menu_id' => 'menu-top-menu',
                                'container' => '',
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>