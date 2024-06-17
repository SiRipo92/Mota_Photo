jQuery(document).ready(function($) {
    $('.burger-btn').on('click', function() {
        $('.mobile-menu').toggleClass('open');
        $(this).toggleClass('btn-close');
        // Toggle aria-expanded attribute
        var expanded = $(this).attr('aria-expanded') === 'true' || false;
        $(this).attr('aria-expanded', !expanded);
    });
});