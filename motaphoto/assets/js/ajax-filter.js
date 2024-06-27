jQuery(function($) {
    $('.filter-button').click(function() {
        var filter = $(this).data('filter');
        $.ajax({
            url: ajaxFilter.ajaxurl, // Use the custom ajaxurl
            data: { action: 'filter_posts', category: filter },
            type: 'POST',
            success: function(response) {
                $('#posts-container').html(response);
            }
        });
    });
});