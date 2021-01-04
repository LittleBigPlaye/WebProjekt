initializeImageGallery();

function initializeImageGallery() {
    var currentSlide = 0;
    setGalleryPosition(currentSlide);
}

function setGalleryPosition(targetSlide) {
    var i;
    var slides = document.getElementsByClassName('gallerySlide');

    var thumbnails = document.getElementsByClassName('galleryThumbnail');

    //check if desired slide is not inside the range of available slides
    if (targetSlide >= slides.length) {
        targetSlide = 0;
    } else if (targetSlide < 0) {
        targetSlide = slides.length;
    }

    // hide all slides
    for (i = 0; i < thumbnails.length; i++) {
        slides[i].style.display = "none";
    }
    slides[targetSlide].style.display = "block";
}