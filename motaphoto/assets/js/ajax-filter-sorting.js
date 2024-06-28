document.addEventListener('DOMContentLoaded', function() {
    var categoryFilter = document.getElementById('category-filter');
    var dateSort = document.getElementById('date-sort');

    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            let selectedCategory = this.value;
            filterPhotos(selectedCategory);
        });
    }

    if (dateSort) {
        dateSort.addEventListener('change', function() {
            let selectedSort = this.value;
            sortPhotos(selectedSort);
        });
    }

    function filterPhotos(category) {
        jQuery.ajax({
            url: ajaxurl, // Provided by WordPress
            type: 'post',
            data: {
                action: 'filter_photos',
                category: category
            },
            success: function(response) {
                jQuery('#photo-gallery').html(response);
            }
        });
    }

    function sortPhotos(sortOrder) {
        jQuery.ajax({
            url: ajaxurl, // Provided by WordPress
            type: 'post',
            data: {
                action: 'sort_photos',
                order: sortOrder
            },
            success: function(response) {
                jQuery('#photo-gallery').html(response);
            }
        });
    }
});