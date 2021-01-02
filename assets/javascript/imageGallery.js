var currentSlide = 1;
setGalleryPosition(currentSlide);

function setGalleryPosition(targetSlide) {
    var i;
    var slides = document.getElementsByClassName('gallerySlide');
    var thumbnails = document.getElementsByClassName('galleryThumbnail');
    if (targetSlide >= slides.length) {
        targetSlide = 1;
    } else if (targetSlide < 0) {
        targetSlide = slides.length;
    }

    // hide all slides
    for (i = 0; i < thumbnails.length; i++) {
        slides[i].style.display = "none";
    }
    slides[targetSlide].style.display = "block";
}