/**
 * This script is used to controll the image gallery on the product view page
 * @author Robin Beck
 */
document.addEventListener('DOMContentLoaded', function() {
    initializeImageGallery();

    function initializeImageGallery() {
        var currentSlide = 0;
        setGalleryPosition(currentSlide);
    }

    //get all thumbnails from site
    var thumbnails = document.getElementsByClassName('galleryThumbnail');

    //add action listeners to the thumbnails
    Array.prototype.forEach.call(thumbnails, function(thumbnail, index) {
        thumbnail.addEventListener('click', function() {
            setGalleryPosition(index);
        });
    });

    function setGalleryPosition(targetSlide) {
        var slides = document.getElementsByClassName('gallerySlide');

        //check if desired slide is not inside the range of available slides
        if (targetSlide >= slides.length) {
            targetSlide = 0;
        } else if (targetSlide < 0) {
            targetSlide = slides.length;
        }

        // hide all slides
        for (var i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        //only show targetSlide
        slides[targetSlide].style.display = "block";
    }
});