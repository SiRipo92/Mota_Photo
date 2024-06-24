<!-- Use AJAX to navigate to the next or previous photo page using the thumbnail image and its buttons-->

<?php
add_action('wp_ajax_navigate_photo', 'navigate_photo');
add_action('wp_ajax_nopriv_navigate_photo', 'navigate_photo');

function navigate_photo() {
    $direction = $_POST['direction'];
    $current_post_id = intval($_POST['current_post_id']);

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'date'
    );

    if ($direction === 'next') {
        $args['order'] = 'ASC';
        $args['date_query'] = array(
            array(
                'after' => get_the_date('Y-m-d H:i:s', $current_post_id),
                'inclusive' => false
            )
        );
    } else {
        $args['order'] = 'DESC';
        $args['date_query'] = array(
            array(
                'before' => get_the_date('Y-m-d H:i:s', $current_post_id),
                'inclusive' => false
            )
        );
    }

    $posts = get_posts($args);
    $post = !empty($posts) ? $posts[0] : null;

    if ($post) {
        $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'thumbnail');
        if ($thumbnail_url) {
            wp_send_json_success(array(
                'thumbnail_url' => $thumbnail_url,
                'post_title' => get_the_title($post->ID),
                'post_id' => $post->ID
            ));
        } else {
            wp_send_json_error(array('message' => 'No thumbnail available.'));
        }
    } else {
        wp_send_json_error(array('message' => 'No post available.'));
    }
    wp_die();
}
?>