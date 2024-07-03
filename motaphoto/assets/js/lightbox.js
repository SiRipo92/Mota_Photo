jQuery(document).ready(function($) {
    var currentPhotoIndex = 0;
    var totalPhotos = 0;

    function openLightbox(index) {
        if (index < 0 || index >= totalPhotos) {
            console.error('Index out of bounds');
            return;
        }

        var photo = photosData.data[index];
        if (!photo || !photo.acf) {
            console.error('Photo data or ACF field is missing');
            return;
        }

        $('#lightbox-modal-image').attr('src', photo.imgSrc);
        $('#lightbox-modal-caption .photo_reference').text(photo.acf.Reference || '');
        $('#lightbox-modal-caption .photo_category').text(photo.categories.map(function(cat) { return cat.name; }).join(', ') || '');
        $('#lightbox-modal').fadeIn();
    }

    function closeLightbox() {
        $('#lightbox-modal').fadeOut();
    }

    function showPrevPhoto() {
        currentPhotoIndex = (currentPhotoIndex - 1 + totalPhotos) % totalPhotos;
        openLightbox(currentPhotoIndex);
    }

    function showNextPhoto() {
        currentPhotoIndex = (currentPhotoIndex + 1) % totalPhotos;
        openLightbox(currentPhotoIndex);
    }

    // Event handler for opening lightbox on icon click
    $('.icon-fullscreen, .icon-eye').on('click', function(e) {
        e.preventDefault(); // Prevent default action (e.g., navigating to a new page)

        // Find the index of the clicked photo
        var index = $(this).closest('.gallery-photo').index();
        currentPhotoIndex = index;
        openLightbox(currentPhotoIndex);
    });

    // Event handler for closing lightbox
    $('#lightbox-modal-close').on('click', function() {
        closeLightbox();
    });

    // Event handler for clicking outside lightbox to close it
    $('#lightbox-modal').on('click', function(e) {
        if ($(e.target).is('#lightbox-modal')) {
            closeLightbox();
        }
    });

    // Event handlers for previous and next buttons
    $('#lightbox-modal-prev').on('click', function(e) {
        e.stopPropagation();
        showPrevPhoto();
    });

    $('#lightbox-modal-next').on('click', function(e) {
        e.stopPropagation();
        showNextPhoto();
    });

    // Ensure photosData is defined and has data
    if (typeof photosData !== 'undefined' && photosData.data.length > 0) {
        totalPhotos = photosData.data.length;
    } else {
        console.error('photosData is not properly defined or is empty');
    }

    // Debugging: Log totalPhotos and currentPhotoIndex
    console.log('Total Photos:', totalPhotos);
    console.log('Current Photo Index:', currentPhotoIndex);
});