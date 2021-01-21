document.addEventListener('DOMContentLoaded', function() {
    var btnUp = document.getElementById('upButton');

    if (btnUp) {
        //hide the button
        btnUp.style.display = 'none';
        btnUp.style.visibility = 'hidden';
        btnUp.style.opacity = '0';
        //change display back to normal
        btnUp.style.display = 'block';

        window.addEventListener('scroll', function(event) {
            if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 1) {
                btnUp.style.visibility = 'visible';
                btnUp.style.opacity = 1;
            } else {
                // btnUp.style.visibility = 'hidden';
                btnUp.style.opacity = 0;
                btnUp.style.visibility = 'hidden';
            }
        });

        btnUp.addEventListener('click', function(event) {
            //enable smooth scrolling
            document.documentElement.style.scrollBehavior = 'smooth';

            //scroll to document top (safari)
            document.body.scrollTop = 0;

            //scrollt to document top (other browsers)
            document.documentElement.scrollTop = 0;

            // To prevent usage of html anchor, if javascript is enabled
            event.preventDefault();
            event.stopPropagation();
        });
    }
});