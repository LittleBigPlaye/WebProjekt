document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.getElementsByClassName('cartQuantitySubmit');
    var request = null;

    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    }

    if (request) {
        // Hide all buttons, if javascript is enabled
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].style.display = 'none';
        }

        var quantitySelectors = document.getElementsByClassName('quantitySelector');

        Array.prototype.forEach.call(quantitySelectors, function(selector) {
            selector.addEventListener('change', function() {
                var currentForm = this.parentElement;
                sendRequest(currentForm);
            });
        });

        request.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    var jsonArray = this.responseText;
                    var targetArray = JSON.parse(jsonArray);

                    //change display of total price
                    var totalPrice = document.getElementById('totalPrice');
                    totalPrice.innerHTML = targetArray['totalPrice'] + ' €';

                    //change display of total number of articles
                    var numberOfProducts = document.getElementById('numberOfProducts');
                    numberOfProducts.innerHTML = targetArray['numberOfProducts'];

                    //remove table entry, if quantity is zero
                    if (targetArray['targetQuantity'] <= 0) {
                        var targetRow = document.getElementById('product' + targetArray['productID']);
                        targetRow.parentElement.removeChild(targetRow);
                    }
                }
            }
        }
    }

    function sendRequest(form) {
        var formData = new FormData(form);
        formData.append('updateCart', '1');
        var currentURL = window.location.href;

        if (currentURL.indexOf('?') > -1) {
            currentURL += '&ajax=1';
        } else {
            currentURL += '?ajax=1';
        }

        //cancel previous requests
        request.abort();

        request.open('Post', currentURL, true);
        request.setRequestHeader('Accept', 'application/json');
        request.send(formData);
    }
});