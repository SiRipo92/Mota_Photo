 /*
    * This script handles various interactive functionalities for the webpage,
    * including mobile menu toggling, modal handling, image preloading, dynamic
    * thumbnail hover effects, and hero banner dynamic content. The main blocks
    * of code are divided as follows:
    * 
    * - Mobile Menu Toggle
    * - Contact Modal Handling
    *      - Open Modal Actions
    *      - Close Modal by Clicking Background
    *      - Close Modal with Close Button
    *      - Prevent Modal Closing When Clicking Inside Modal Container
    * - Image Preloading for Animation Smoothness
    * - Dynamic Thumbnail Hover Effects
    * - Hero Banner Dynamic Content Integration
    * - Photo Gallery Hover Display
    * 
*/

// On document ready
jQuery.noConflict();
jQuery(document).ready(function($) {

    ////////////////////////// BURGER BUTTON AND MOBILE MENU TOGGLE //////////////////////////

    // Mobile menu toggle
    jQuery('.burger-btn').off('click').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        let burgerBtn = $('.burger-btn');
        let mobileMenu = $('.mobile-menu');
        
        burgerBtn.toggleClass('open');
        mobileMenu.toggleClass('open');
    
        if (burgerBtn.hasClass('open') && mobileMenu.hasClass('open')) {
            burgerBtn.attr('aria-expanded', 'true');
            $('body').css('overflow', 'hidden');
          } else {
          // Open the menu
          burgerBtn.attr('aria-expanded', 'false');
          $('body').css('overflow', 'auto');
        }
    });

    ////////////////////////// CONTACT MODAL ACTIONS //////////////////////////

    // Open Contact modal
    $('#contactLink, .btn-cta').on('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        const referenceID = customData.referenceID; // Get reference ID passed from PHP
        if (referenceID) {
            $('label.form-reference').find('input').val(customData.referenceID).css('text-transform', 'uppercase');
        }
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

    ////////////////////////// DYNAMIC THUMBNAIL ANIMATION  //////////////////////////

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
        }, 800); // Adjust the timeout as needed
    });

    ////////////////////////// CUSTOM / DYNAMIC HERO BANNER //////////////////////////

    // Hero Banner Dynamic Content (Integrated from custom-banner.js)
    if (customBannerData.photos && customBannerData.photos.length > 0) {
        var randomIndex = Math.floor(Math.random() * customBannerData.photos.length);
        var randomPhotoUrl = customBannerData.photos[randomIndex].url;
        $('.hero-banner').css('background-image', 'url(' + randomPhotoUrl + ')');
    } else {
        console.log("No photo URLs found or the data structure is not as expected.");
    }

    ////////////////////////// PHOTO GALLERY HOVER DISPLAY //////////////////////////

    // Photo Gallery Hover Display
    const galleryPhotos = $('.gallery-photo');
    galleryPhotos.hover(function() {
        $(this).find('.photo-overlay').fadeIn();
    }, function() {
        $(this).find('.photo-overlay').fadeOut();
    });
});