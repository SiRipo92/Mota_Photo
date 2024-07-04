<?php
/**
 * Template part for displaying a modal lightbox for photos.
 *
 * @package MotaPhoto
 * @version 1.0
 */
?>

<div class="lightbox-modal" id="lightbox-modal">
    <div class="lightbox-modal__container">
        <div class="lightbox-modal__header">
            <button class="lightbox-modal__close" id="lightbox-modal-close">
                <img src="<?php echo get_template_directory_uri(). '/assets/images/lightbox/close.png'; ?>" alt="Closing button">
            </button>
        </div>
        <div class="lightbox-modal__display">
            <span class="lightbox-modal__button prev-btn" id="lightbox-modal-prev">
                <img src="<?php echo get_template_directory_uri(). '/assets/images/lightbox/prev-arrow.png'; ?>" alt="Previous">
            </span>
            <img class="lightbox-modal__image" id="lightbox-modal-image" src="" alt="Lightbox Image">
            <span class="lightbox-modal__button next-btn" id="lightbox-modal-next">
                <img src="<?php echo get_template_directory_uri(). '/assets/images/lightbox/next-arrow.png'; ?>" alt="Next">
            </span>
        </div>
        <div class="lightbox-modal__caption" id="lightbox-modal-caption">
            <span class="photo_reference"></span>
            <span class="photo_category"></span>
        </div>
    </div>
</div>