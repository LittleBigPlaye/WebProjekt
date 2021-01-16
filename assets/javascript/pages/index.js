document.addEventListener('DOMContentLoaded', function() {
    var slideIndex = 1;
    showSlides(slideIndex);

    var btnPrevious = document.getElementById('previousSlide');
    var btnNext = document.getElementById('nextSlide');


    if (btnNext) {
        btnNext.style.display = 'block';
        btnNext.addEventListener('click', function() {
            plusSlides(1)
        });
    }

    if (btnPrevious) {
        btnPrevious.style.display = 'block';
        btnPrevious.addEventListener('click', function() {
            plusSlides(-1);
        });
    }

    /**
     * Used to add or subtract a number of the current slideIndex and jump to the new index
     * @param {*} slideDifference value to determine whether slideIndex should be increased or decreased
     */
    function plusSlides(slideDifference) {
        showSlides(slideIndex += slideDifference);
    }

    // used to show the target slide
    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName('spotlightElement');
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }

        if (slides) {
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slides[slideIndex - 1].style.display = 'block';
        }
    }
});