jQuery(document).ready(function($) {
    function fetchFilteredPhotos() {
        var selectedCategory = $('.category-menu .selected').data('value');
        var selectedFormat = $('.format-menu .selected').data('value');
        var selectedSortingMethod = $('#sort_order .selected').data('value');

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
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    }

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

    // Event handler for clicking on dropdown button
    $('.dropbtn').on('click', function() {
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

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-content').slideUp().removeClass('open');
            $('.dropbtn').removeClass('active');
            $('.arrow').removeClass('rotate');
            $('.dropbtn').css('border-color', 'black'); // Reset border on all buttons
        }
    });


    // Hide dropdowns on page load
    $('.dropdown-content').hide();
    $('.arrow').removeClass('rotate');
});
