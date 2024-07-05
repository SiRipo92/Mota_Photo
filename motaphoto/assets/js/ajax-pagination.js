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
            var referenceId = $(this).closest('.gallery-photo').data('reference-id');
            openLightbox(referenceId);
        });

        // Close modal
        $('#lightbox-modal-close, #lightbox-modal-overlay').on('click', function(e) {
            e.preventDefault();
            $('#lightbox-modal').removeClass('open');
        });

        // Optional: Previous and Next functionality for lightbox
        $('#lightbox-modal-prev').on('click', function() {
            showPrevPhoto();
        });

        $('#lightbox-modal-next').on('click', function() {
            showNextPhoto();
        });
    }

    // Function to open lightbox modal
    function openLightbox(referenceId) {
        if (typeof photosData !== 'undefined' && photosData.data.length > 0) {
            totalPhotos = photosData.data.length;
        } else {
            console.error('Error: photosData is not properly defined or is empty');
            return;
        }

        var photoIndex = photosData.data.findIndex(photo => photo.reference_id == referenceId);
        if (photoIndex < 0 || photoIndex >= totalPhotos) {
            console.error('Error: Index is out of bounds or photo not found');
            return;
        }

        var photo = photosData.data[photoIndex];
        if (!photo || !photo.id) {
            console.error('Error: Photo data or ID is missing');
            return;
        }

        // Update modal content with photo data
        $('#lightbox-modal-image').attr('src', photo.featured_image || '');
        $('#lightbox-modal-caption .photo_reference').text(photo.reference_id || '');
        $('#lightbox-modal-caption .photo_category').text(photo.categories.join(', ') || '');
        $('#lightbox-modal').addClass('open');
        $('body').addClass('modal-open');

        // Make AJAX call to fetch detailed photo data
        fetchLightboxData(photo.id);

        currentPhotoIndex = photoIndex; // Update currentPhotoIndex after successful photo load
    }

    // Function to fetch lightbox data via AJAX
    function fetchLightboxData(photoId) {
        $.ajax({
            url: photosData.ajaxurl,
            type: 'POST',
            data: {
                action: 'fetch_lightbox_data',
                nonce: photosData.nonce,
                photo_id: photoId,
            },
            success: function(response) {
                if (response.success) {
                    var data = response.data;

                    // Update modal with additional data
                    $('#lightbox-modal-caption .photo_reference').text(data.referenceID || '');
                    $('#lightbox-modal-caption .photo_category').text(data.categories.join(', ') || '');
                    $('#lightbox-modal-image').attr('src', data.featured_image || '');
                } else {
                    console.error('Error fetching lightbox data:', response.data);
                }
            },
            error: function(error) {
                console.error('Error fetching lightbox data:', error);
            }
        });
    }

    // Function to show previous photo
    function showPrevPhoto() {
        if (totalPhotos === 0) return;
        currentPhotoIndex = (currentPhotoIndex - 1 + totalPhotos) % totalPhotos;
        openLightbox(photosData.data[currentPhotoIndex].reference_id);
    }

    // Function to show next photo
    function showNextPhoto() {
        if (totalPhotos === 0) return;
        currentPhotoIndex = (currentPhotoIndex + 1) % totalPhotos;
        openLightbox(photosData.data[currentPhotoIndex].reference_id);
    }

    // Initial call to initialize functions on page load
    initializePhotoFunctions();
});