# Mota Photo
**Overview**
Welcome to the "Mota Photo" custom WordPress theme! This theme is designed specifically for Nathalie Mota, a photographer, to showcase her work in a beautiful and dynamic way. The theme includes custom content types and fields to ensure that Nathalie can easily manage and display her photography.

**Features**
- Custom post-type - 'photos' with advanced custom fields to stock data about each photo during publication of posts, with custom taxonomies
- Custom Nav Walker Menu - extended in theme to generate custom Wordpress navigation menus
- Imported Google Fonts - 'Poppins' and 'Space Mono'
- Compressed image files - to reduce site's loading charge
- Custom Contact Popup Modal - it dynamically fills in the referenceID number of the photo when on the single-photo.php page.
- NodeJs/GulpSass for generating stylesheets effectively (and awesomely), compressing SASS into CSS in '/assets/css/custom.css' along with a source map. Sass files are compressed from theme directory's /sass folder.
- Dynamic Photo Gallery: The homepage features a photo gallery with 8 images that can be dynamically filtered by category and format, and also sorted by date (most recent posts to oldest posts / oldest posts to most recent posts). This gallery has a pagination that stocks and stores displayed photos using AJAX to display the remaining photos
- Individual Page Formats: index.php for the homepage and single-photo.php to display single photos

**Plugins**
- Advanced Custom Fields (ACF): Takes stock of each custom photo post type and takes in additional data for each post.
- Custom Post Type UI (CPT UI): Used to create custom post types (Photos) with custom taxonomies (category [has a heirarchy) and format (does not have a hierarchy).
- Query Monitor: For debugging purposes.
- WP Super Cache: to optimize site's loading
- Contact Form 7: generates a shortcode for the custom contact modal
- All-in-One WP Migration

**Theme Directory**
- Main directory: functions.php, header.php, footer.php, single-photo.php, sidebar.php, etc.
- Assets : /fonts, /css, /images
- Inc : menus.php, ajax-handlers.php, custom-banner.php
- Template-parts : modal-contact.php, photo-gallery-index.php, photo-gallery-single.php
- SASS : /base, /components, /layouts, /pages
  
