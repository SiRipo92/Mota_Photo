jQuery(document).ready(function($) {
    var currentPhotoIndex = 0;
    var totalPhotos = 0;

    // Function to open lightbox modal
    function openLightbox(index) {
        if (typeof photosData !== 'undefined' && photosData.data.length > 0) {
            totalPhotos = photosData.data.length;
        } else {
            console.error('Error: photosData is not properly defined or is empty');
            return;
        }

        if (index < 0 || index >= totalPhotos) {
            console.error('Error: Index is out of bounds');
            return;
        }

        var photo = photosData.data[index];
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

    // Event handler for opening lightbox on icon click
    $('.icon-fullscreen, .icon-eye').on('click', function(e) {
        e.preventDefault();
        var index = $(this).closest('.gallery-photo').index();
        currentPhotoIndex = index;
        openLightbox(currentPhotoIndex);
    });

    // Event handler for previous and next buttons
    $('#lightbox-modal-prev').on('click', function(e) {
        e.stopPropagation();
        showPrevPhoto();
    });

    $('#lightbox-modal-next').on('click', function(e) {
        e.stopPropagation();
        showNextPhoto();
    });

    // Event handler for closing lightbox
    $('#lightbox-modal-close, #lightbox-modal-overlay').on('click', function(e) {
        closeLightbox();
    });

    // Function to close the lightbox
    function closeLightbox() {
        $('#lightbox-modal').removeClass('open');
        $('body').removeClass('modal-open');
    }

    // Function to show previous photo
    function showPrevPhoto() {
        if (totalPhotos === 0) return;
        currentPhotoIndex = (currentPhotoIndex - 1 + totalPhotos) % totalPhotos;
        openLightbox(currentPhotoIndex);
    }

    // Function to show next photo
    function showNextPhoto() {
        if (totalPhotos === 0) return;
        currentPhotoIndex = (currentPhotoIndex + 1) % totalPhotos;
        openLightbox(currentPhotoIndex);
    }
});