jQuery(document).ready(function($) {
    let page = 1;
    
    $('#btn-load-more').on('click', function() {
        page++;
        loadMorePhotos(page);
    });

    function loadMorePhotos(page) {
        $.ajax({
            url: ajax_pagination_data.ajaxurl, // Use the localized ajaxurl
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: page
            },
            success: function(response) {
                $('#photo-gallery').append(response);
            }
        });
    }
});
