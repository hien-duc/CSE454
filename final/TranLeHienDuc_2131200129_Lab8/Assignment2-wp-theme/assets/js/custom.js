jQuery(document).ready(function($) {
    // Mobile menu toggle
    $('.mobile-menu-toggle').on('click', function(e) {
        e.preventDefault();
        $('.mobile-menu').toggleClass('active');
        $('body').toggleClass('mobile-menu-open');
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.mobile-menu, .mobile-menu-toggle').length) {
            $('.mobile-menu').removeClass('active');
            $('body').removeClass('mobile-menu-open');
        }
    });

    // Product image gallery
    $('.product-gallery-thumb').on('click', function() {
        var imgSrc = $(this).data('image');
        $('.product-gallery-main img').attr('src', imgSrc);
    });

    // Smooth scroll to top
    $('.scroll-to-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 800);
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Add to cart animation
    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();
        var cart = $('.cart-icon');
        var imgtodrag = $(this).closest('.san-pham').find('img').eq(0);
        
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                .css({
                    'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
                })
                .appendTo($('body'))
                .animate({
                    'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
                }, 1000, 'easeInOutExpo');

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach();
            });
        }
    });
});
