jQuery(document).ready(function($) {
    var categoryMenu = $('.category-menu');
    var formatMenu = $('.format-menu');
    // Assuming there's a sorting menu in your HTML
    var sortingMenu = $('#sort_order');

    function fetchFilteredPhotos() {
        var selectedCategory = categoryMenu.val();
        var selectedFormat = formatMenu.val();
        var selectedSortingMethod = sortingMenu.val();

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
                $('#posts-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    }

    categoryMenu.change(fetchFilteredPhotos);
    formatMenu.change(fetchFilteredPhotos);
    // Also trigger the fetch when the sorting method changes
    sortingMenu.change(fetchFilteredPhotos);
});