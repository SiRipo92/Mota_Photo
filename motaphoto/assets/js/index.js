// On document ready
jQuery(document).ready(function($) {

    // Manage mobile menu open/close
    $('.burger-btn').on('click', function() {
        $('.mobile-menu').toggleClass('open');
        $(this).toggleClass('btn-close');
        // Toggle aria-expanded attribute
        var expanded = $(this).attr('aria-expanded') === 'true' || false;
        $(this).attr('aria-expanded', !expanded);
    });

    // Open modal actions
    $('#contactLink, .btn-cta').on('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        const referenceID = customData.referenceID; // Get reference ID passed from PHP
        if (referenceID) {
            $('label.form-reference').find('input').val(customData.referenceID);        }
        $('#contact-modal').fadeIn(); // Use fadeIn for a smooth opening
    });

    // Close modal by clicking on the modal background
    $('#contact-modal').on('click', function(event) {
        if (event.target === this) {
            $(this).fadeOut(); // Use fadeOut for a smooth closing
        }
    });

    // Close modal with the close button
    $('.btn-close').on('click', function() {
        $('#contact-modal').fadeOut();
    });

    // Prevent closing when clicking inside the modal container
    $('.modal-container').on('click', function(event) {
        event.stopPropagation(); 
    });

    /////////
    /////// Hover event for the left and right arrows 
    ////////        single-photo.php page
    $('.prev-post').hover(function(){

        // On mouse enter, update the thumbnail src
        const prevThumbnailUrl = $(this).attr('data-thumbnail');
        $('.dynamic-thumbnail').attr('src', prevThumbnailUrl);
    }, function() {
        // On mouse leave, reset the thumbnail src
    }
    );

    $('.next-post').hover(function(){
        // On mouse enter, update the thumbnail src
        const nextThumbnailUrl = $(this).attr('data-thumbnail');
        $('.dynamic-thumbnail').attr('src', nextThumbnailUrl);
    }, function() {
        // On mouse leave, reset the thumbnail src

    });
})


