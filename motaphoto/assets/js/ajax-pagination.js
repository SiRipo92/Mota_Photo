jQuery(document).ready(function($) {
    let page = 1;

    $('#btn-load-more').on('click', function() {
        page++;
        loadMorePhotos(page);
    });

    function loadMorePhotos(page) {
        var selectedCategory = $('.category-menu .selected').data('value');
        var selectedFormat = $('.format-menu .selected').data('value');
        var selectedSortingMethod = $('#sort_order .selected').data('value');

        $.ajax({
            url: ajax_pagination_data.ajaxurl,
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: page,
                category: selectedCategory,
                format: selectedFormat,
                sorting: selectedSortingMethod,
                security: ajax_pagination_data.nonce
            },
            success: function(response) {
                $('#posts-container').append(response); // Append new photos
                // Call a function to initialize/reapply your JavaScript functionalities
                initializePhotoFunctions();
            },
            error: function(xhr, status, error) {
                console.error("Error loading more photos: " + error);
            }
        });
    }

    // Function to initialize/reapply JavaScript functionalities
    function initializePhotoFunctions() {
        // Initialize hover effect
        $('.gallery-photo').hover(function() {
            $(this).find('.photo-overlay').fadeIn();
        }, function() {
            $(this).find('.photo-overlay').fadeOut();
        });

        // Modal lightbox functionality
        $('.icon-fullscreen, .icon-eye').on('click', function(e) {
            e.preventDefault();
            var modalLightbox = $('#lightbox-modal');

            // Retrieve photo details
            var photoTitle = $(this).closest('.gallery-photo').find('.photo-title').text();
            var photoCategory = $(this).closest('.gallery-photo').find('.photo-category').text();

            // Set modal content
            $('#lightbox-modal-caption .photo_reference').text(photoTitle);
            $('#lightbox-modal-caption .photo_category').text(photoCategory);

            // Open modal
            modalLightbox.addClass('open');
        });

        // Close modal
        $('#lightbox-modal-close').on('click', function(e) {
            e.preventDefault();
            $('#lightbox-modal').removeClass('open');
        });

        // Optional: Previous and Next functionality for lightbox
        $('#lightbox-modal-prev').on('click', function() {
            // Implement previous photo functionality
        });

        $('#lightbox-modal-next').on('click', function() {
            // Implement next photo functionality
        });
    }

    // Initial call to initialize functions on page load
    initializePhotoFunctions();
});