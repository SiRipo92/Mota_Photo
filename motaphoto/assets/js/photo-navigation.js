// jQuery code to navigate between photos using AJAX
jQuery(document).ready(function($) {
    $('.slider-controls .next-photo').click(function() {
        var currentPostId = $('.photo-thumbnail').data('current-post-id');
        $.ajax({
            url: myScriptData.ajaxurl,
            type: 'post',
            data: {
                action: 'navigate_photo',
                direction: 'next',
                current_post_id: currentPostId
            },
            success: function(response) {
                if (response.success) {
                    $('.photo-thumbnail').attr('src', response.data.thumbnail_url);
                    $('.photo-thumbnail').data('current-post-id', response.data.post_id);

                    // Navigate to the new photo's permalink
                    var newPostUrl = response.data.post_permalink;
                    if (newPostUrl) {
                        window.location.href = newPostUrl;
                    }
                } else {
                    alert(response.data.message);
                }
            }
        });
    });

    $('.slider-controls .prev-photo').click(function() {
        var currentPostId = $('.photo-thumbnail').data('current-post-id');
        $.ajax({
            url: myScriptData.ajaxurl,
            type: 'post',
            data: {
                action: 'navigate_photo',
                direction: 'prev',
                current_post_id: currentPostId
            },
            success: function(response) {
                if (response.success) {
                    $('.photo-thumbnail').attr('src', response.data.thumbnail_url);
                    $('.photo-thumbnail').data('current-post-id', response.data.post_id);

                    // Navigate to the new photo's permalink
                    var newPostUrl = response.data.post_permalink;
                    if (newPostUrl) {
                        window.location.href = newPostUrl;
                    }
                } else {
                    alert(response.data.message);
                }
            }
        });
    });
});
