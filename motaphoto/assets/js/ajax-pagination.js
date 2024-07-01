jQuery(document).ready(function($) {
    let page = 1;

    $('#btn-load-more').on('click', function() {
        page++;
        loadMorePhotos(page);
    });

    function loadMorePhotos(page) {
        var selectedCategory = $('.category-menu .selected').data('value');
        var selectedFormat = $('.format-menu .selected').data('value');

        $.ajax({
            url: ajax_pagination_data.ajaxurl,
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: page,
                category: selectedCategory,
                format: selectedFormat,
                security: ajax_pagination_data.nonce
            },
            success: function(response) {
                $('#photo-gallery').append(response); // Append new photos
            }
        });
    }
});
