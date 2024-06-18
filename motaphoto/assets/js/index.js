// /js/scripts.js
jQuery(document).ready(function($) {
    // Manage mobile menu open/close
    $('.burger-btn').on('click', function() {
        $('.mobile-menu').toggleClass('open');
        $(this).toggleClass('btn-close');
        // Toggle aria-expanded attribute
        var expanded = $(this).attr('aria-expanded') === 'true' || false;
        $(this).attr('aria-expanded', !expanded);
    });

    // Manage contact-link modal open/close
    $('#contactLink').on('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        $('#contact-modal').fadeIn();
    });

    $('.btn-close, .modal').on('click', function() {
        $('#contact-modal').fadeOut();
    });

    $('.modal-container').on('click', function(event) {
        event.stopPropagation();
    });
});
