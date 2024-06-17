// Toggle open and close mobile menu
jQuery(document).ready(function($) {
    $('.burger').on('click', function() {
        $('.mobile-menu').toggleClass('open');
        $('.mobile-menu-container').toggleClass('open');
        $(this).toggleClass('close-button');
    });
});