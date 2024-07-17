/*
 * This script initializes various functionalities for Mota Photo's photo gallery webpage,
 * including photo loading, filtering, and lightbox features. The main blocks
 * of code are divided as follows:
 * 
 * - Global Variable Initialization
 * - Initial Function Call
 * - AJAX Photo Loading
 *      - Button Click Handler to Load More Photos
 *      - Function to Load More Photos via AJAX
 * - AJAX Photo Filtering
 *      - Function to Fetch Filtered Photos and Reset Filters
 * - Event Handlers for Menu Filters
 *      - Hide Dropdowns on Page Load
 *      - Event Handler for Clicking on Dropdown Button
 *      - Event Handler for Clicking an Item in Dropdown
 * - Lightbox Functions
 *      - Function to Open Lightbox Modal
 *      - Function to Fetch Lightbox Data via AJAX
 *      - Functions to Show Previous/Next Photos
 *      - Event Handlers for Lightbox Actions
 * - Reinitialization of JavaScript Functionalities
 *     - Function to Initialize/Reapply JavaScript Functionalities (Lightbox) on newly loaded photos
 * 
 */ 
jQuery.noConflict();
jQuery(document).ready(function($) {
    // Set Global Variables
    let currentPhotoIndex = 0;
    let totalPhotos = 0;

    // Initial call to initialize functions on page load
    initializePhotoFunctions();

    ////////////////////// AJAX PHOTO LOADING /////

    // Initialize page variable
    let page = 1;

    // Function to load more photos on button click
    $('#btn-load-more').on('click', function() {
        page++;
        loadMorePhotos(page);
    });

    // Function to load more photos via AJAX
    function loadMorePhotos(page) {
        var selectedCategory = $('.category-menu .selected').data('value');
        var selectedFormat = $('.format-menu .selected').data('value');
        var selectedSortingMethod = $('#sort_order .selected').data('value');

        $.ajax({
            method: 'POST',
            url: ajax_pagination_data.ajaxurl,
            data: {
                action: 'load_more_photos',
                page: page,
                category: selectedCategory,
                format: selectedFormat,
                sorting: selectedSortingMethod,
                security: ajax_pagination_data.nonce
            },
            success: function(response) {
                $('#posts-container').append(response); 
                initializePhotoFunctions(); // Reinitialize photo functions including lightbox
            },
            error: function(xhr, status, error) {
                console.error("Error loading more photos: " + error);
            }
        });
    }

    ////////////////////// AJAX PHOTO FILTERING /////

    // Function to fetch filtered photos and reset filters
    function fetchFilteredPhotos() {
        var selectedCategory = $('.category-menu .selected').hasClass('hidden-label') ? 'all' : $('.category-menu .selected').data('value');
        var selectedFormat = $('.format-menu .selected').hasClass('hidden-label') ? 'all' : $('.format-menu .selected').data('value');
        var selectedSortingMethod = $('#sort_order .selected').hasClass('hidden-label') ? 'all' : $('#sort_order .selected').data('value');

        // Reset pagination
        page = 1;

        // AJAX request to server
        $.ajax({
            url: ajax_filter_sorting_data.ajaxurl,
            type: 'POST',
            data: {
                action: 'fetch_photos',
                category: selectedCategory,
                format: selectedFormat,
                sorting: selectedSortingMethod,
                security: ajax_filter_sorting_data.nonce
            },
            success: function(response) {
                $('.gallery-photos__container').html(response); // Replace existing content with first page

                // After replacing content, initialize hover and modal functions
                initializePhotoFunctions();
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    }

   ///////////// EVENT HANDLERS FOR MENU FILTERS /////////////
    // Hide dropdowns on page load
    $('.dropdown-content').hide();
    $('.arrow').removeClass('rotate');

    // Event handler for clicking on dropdown button
    $('.dropbtn').on('click', function(e) {
        var $dropdown = $(this).closest('.dropdown');
        var $dropdownContent = $dropdown.find('.dropdown-content');

        // Toggle active class on button and rotate class on arrow
        $(this).toggleClass('active');
        $(this).find('.arrow').toggleClass('rotate');

        // Toggle dropdown content visibility and .open class
        $dropdownContent.slideToggle().toggleClass('open');

        // Check if dropdown is being opened
        if ($dropdownContent.hasClass('open')) {
            // Show border on active button when dropdown is open
            $(this).css('border-color', '#215AFF');
        } else {
            // Remove border when dropdown is closed
            $(this).css('border-color', 'black');
        }
    });

    // Event handler for when an item in dropdown is clicked
    $('.dropdown-content ul li').on('click', function() {
        var $this = $(this);
        var $dropdown = $this.closest('.dropdown');

        // Remove 'selected' class from previous selection
        $dropdown.find('.selected').removeClass('selected');

        // Add 'selected' class to the clicked item
        $this.addClass('selected');

        // Update button text and append arrow icon
        var button = $dropdown.find('.dropbtn');
        var arrow = button.find('.arrow').clone();
        button.html($this.text()).append(arrow);

        // Fetch filtered photos based on selected filters
        fetchFilteredPhotos();

        // Reset the pagination when filters change
        page = 1;

        // Slide up the dropdown content
        $this.closest('.dropdown-content').slideUp().removeClass('open');

        // Remove 'active' class from button and 'rotate' class from arrow
        $dropdown.find('.dropbtn').removeClass('active');
        $dropdown.find('.arrow').removeClass('rotate');

        // Reset border to normal black
        $dropdown.find('.dropbtn').css('border-color', 'black');
    });

    ////////////////////// LIGHTBOX FUNCTIONS //////////////////////
    
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

    // Event handler for opening lightbox on icon click
    $('.icon-fullscreen').on('click', function(e) {
        e.preventDefault();
        var referenceId = $(this).closest('.gallery-photo').data('reference-id');
        openLightbox(referenceId);
    });

    // Event handler for closing lightbox
    $('#lightbox-modal-close, #lightbox-modal-overlay').on('click', function(e) {
        e.preventDefault();
        $('#lightbox-modal').removeClass('open');
        $('body').removeClass('modal-open');
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

    ////////////////////// END LIGHTBOX FUNCTIONS //////////////////////

    // Function to initialize/reapply JavaScript functionalities
    function initializePhotoFunctions() {
        // Initialize hover effect
        $('.gallery-photo').hover(function() {
            // Stop any ongoing fade-in animations and fade out any other overlays quickly
            $('.photo-overlay').not($(this).find('.photo-overlay')).stop(true, true).fadeOut('fast');
            // Stop any ongoing fade-in animation on the current overlay and then fade it in
            $(this).find('.photo-overlay').stop(true, true).fadeIn('fast');
        }, function() {
            // When no longer hovering, stop any ongoing animation and fade out the overlay
            $(this).find('.photo-overlay').stop(true, true).fadeOut('fast');
        });
    }
});
