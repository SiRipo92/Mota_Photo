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

    // Improved hover event for the left and right arrows
    $('.prev-post, .next-post').hover(function() {
        const thumbnailUrl = $(this).attr('data-thumbnail');
        const $dynamicThumbnail = $('.dynamic-thumbnail');
        // Only proceed if the new thumbnail is different from the current one
        if ($dynamicThumbnail.attr('src') !== thumbnailUrl) {
            // Ensure any ongoing animation is stopped before starting new ones
            $dynamicThumbnail.stop(true, true);
            // If the thumbnail is already visible (opacity 1), directly change the src
            if ($dynamicThumbnail.css('opacity') == 1) {
                $dynamicThumbnail.fadeTo('fast', 0, function() {
                    $(this).attr('src', thumbnailUrl).fadeTo('fast', 1);
                });
            } else {
                // If the thumbnail is not fully visible, change the src then fade in
                $dynamicThumbnail.attr('src', thumbnailUrl).fadeTo('fast', 1);
            }
        }
    }, function() {
        // On mouse leave, smoothly fade out the thumbnail with a slight delay
        $('.dynamic-thumbnail').stop(true, true).delay(100).fadeTo('slow', 0.2); // Adjust opacity to desired level
    });


    // Hero Header Dynamic Content
    const heroBanner = $('.hero-banner');
    heroBanner.attr('content', `url(${customData.heroImage})`);
})


