jQuery(document).ready(function($) {

    // Pagination
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
            type: 'POST',
            data: {
                action: 'fetch_photos',
                page: page,
                category: selectedCategory,
                format: selectedFormat,
                sorting: selectedSortingMethod,
                security: ajax_pagination_data.fetch_photos_nonce // Use fetch_photos_nonce for fetch_photos action
            },
            success: function(response) {
                if (response.success) {
                    $('#posts-container .gallery-photos__container').append(response.data.html);
                } else {
                    console.log('Error loading more photos');
                }
            },
            error: function() {
                console.log('Error loading more photos');
            }
        });
    }
    // Apply filters and sorting
    function fetchFilteredPhotos() {
        var selectedCategory = $('.category-menu .selected').data('value');
        var selectedFormat = $('.format-menu .selected').data('value');
        var selectedSortingMethod = $('#sort_order .selected').data('value');

        // Reset pagination
        page = 1;

        $.ajax({
            url: ajax_filter_sorting_data.ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_photos', 
                category: selectedCategory,
                format: selectedFormat,
                sorting: selectedSortingMethod,
                security: ajax_filter_sorting_data.filter_photos_nonce // Use filter_photos_nonce for filter_photos action
            },
            success: function(response) {
                $('#photo-gallery').html(response.data.html); 
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    }

    $('.dropdown-content ul li').on('click', function() {
        var $this = $(this);
        var $dropdown = $this.closest('.dropdown');

        $dropdown.find('.selected').removeClass('selected');
        $this.addClass('selected');

        var button = $dropdown.find('.dropbtn');
        var arrow = button.find('.arrow').clone();
        button.html($this.text()).append(arrow);

        fetchFilteredPhotos();
        page = 1;

        $this.closest('.dropdown-content').slideUp().removeClass('open');
        $dropdown.find('.dropbtn').removeClass('active');
        $dropdown.find('.arrow').removeClass('rotate');
        $dropdown.find('.dropbtn').css('border-color', 'black');
    });

    $('.dropbtn').on('click', function() {
        var $dropdown = $(this).closest('.dropdown');
        var $dropdownContent = $dropdown.find('.dropdown-content');

        $(this).toggleClass('active');
        $(this).find('.arrow').toggleClass('rotate');

        $dropdownContent.slideToggle().toggleClass('open');

        if ($dropdownContent.hasClass('open')) {
            $(this).css('border-color', '#215AFF');
        } else {
            $(this).css('border-color', 'black');
        }
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-content').slideUp().removeClass('open');
            $('.dropbtn').removeClass('active');
            $('.arrow').removeClass('rotate');
            $('.dropbtn').css('border-color', 'black');
        }
    });

    $('.dropdown-content').hide();
    $('.arrow').removeClass('rotate');
});