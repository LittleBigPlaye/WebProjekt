document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.getElementsByClassName('cartQuantitySubmit');
    // Hide all buttons, if javascript is enabled
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].style.display = 'none';
    }

    var quantitySelectors = document.getElementsByClassName('quantitySelector');

    Array.prototype.forEach.call(quantitySelectors, function(selector) {
        selector.addEventListener('change', function() {
            this.nextElementSibling.click();
        });
    });
});