jQuery(document).ready(function($) {
    // Check if there are photos available
    if (customBannerData.photos && customBannerData.photos.length > 0) {
        // Generate a random index based on the number of photos available
        var randomIndex = Math.floor(Math.random() * customBannerData.photos.length);
        // Use the URL of the randomly selected photo as the background
        var randomPhotoUrl = customBannerData.photos[randomIndex].url; // Access the URL of the random photo
        $('.hero-banner').css('background-image', 'url(' + randomPhotoUrl + ')');
    } else {
        console.log("No photo URLs found or the data structure is not as expected.");
    }
});