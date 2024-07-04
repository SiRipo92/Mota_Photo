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
            $('label.form-reference').find('input').val(customData.referenceID).css('text-transform', 'uppercase');    }
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

    // Preload images to improve animation smoothness
    const preloadImage = (url) => {
        const img = new Image();
        img.src = url;
    };
    $('.prev-post, .next-post').each(function() {
        preloadImage($(this).attr('data-thumbnail'));
    });

    // Define a variable outside hover event to keep track of the timeout
    let fadeOutTimeout;

    // Improved hover event for the left and right arrows
    $('.prev-post, .next-post').hover(function() {
        // Clear any existing timeout to reset the fade-out timer
    clearTimeout(fadeOutTimeout);

    const thumbnailUrl = $(this).attr('data-thumbnail');
    const $dynamicThumbnail = $('.dynamic-thumbnail');
    if ($dynamicThumbnail.attr('src') !== thumbnailUrl) {
        $dynamicThumbnail.stop(true, true);
        if ($dynamicThumbnail.css('opacity') == 1) {
            $dynamicThumbnail.fadeTo('fast', 0, function() {
                $(this).attr('src', thumbnailUrl).fadeTo('fast', 1);
            });
        } else {
            $dynamicThumbnail.attr('src', thumbnailUrl).fadeTo('fast', 1);
        }
    }
}, function() {
    // Use setTimeout to delay the fade-out
    fadeOutTimeout = setTimeout(function() {
        $('.dynamic-thumbnail').stop(true, true).animate({
            opacity: 0
        }, {
            duration: 'slow', // This can be a number in milliseconds for finer control
            complete: function() {
                // Optional: hide or set display to 'none' after fade-out completes
                $(this).hide();
            }
        });
    }, 1000); // Adjust the timeout as needed
});


    // Hero Header Dynamic Content
    const heroBanner = $('.hero-banner');
    heroBanner.attr('content', `url(${customData.heroImage})`);

    // Photo Gallery Hover Display

    const galleryPhotos = $('.gallery-photo');
    galleryPhotos.hover(function() {
        $(this).find('.photo-overlay').fadeIn();
    }, function() {
        $(this).find('.photo-overlay').fadeOut();
    });
})


