<?php
/**
 * Template part for modal contact pop-up.
 * 
 * @package MotaPhoto
 * @version 1.0
 * @author Sierra Ripoche
 * @since 1.0
 */
?>
<div id="contact-modal" class="modal">
    <div class="modal-container">
        <div class="modal-contact_btn-close">
            <button class="btn-close">
                    <span class="close-bar"></span>
                    <span class="close-bar"></span>
            </button>
        </div>
        <div class="modal-content">
            <div class="modal-content__header">
                <img id="contact-banner" src="<?php echo get_template_directory_uri() . '/assets/images/nav/contact-header-bg.png' ; ?>" alt="Contact form banner">
            </div>
            <div class="modal-content__form">
                <?php echo do_shortcode('[contact-form-7 id="68dcfdf" title="Modal contact"]'); ?>
            </div>
        </div>
    </div>
</div>