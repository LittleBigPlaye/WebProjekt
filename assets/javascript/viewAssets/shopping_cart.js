/**
 * This script is used to add items to the cart without reloading the site
 */

document.addEventListener('DOMContentLoaded', function() {
    //get all cart buttons of the current page
    var btnCartAdders = document.getElementsByClassName('cartButton');
    var cartBadge = document.getElementById('cartBadge');
    var cartBadgeText = null;
    if (cartBadge.childNodes.length >= 1) {
        cartBadgeText = cartBadge.childNodes[0];
    }

    var request = null;

    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    }

    if (request) {
        //add a listener to all found buttons
        Array.prototype.forEach.call(btnCartAdders, function(btnAddToCart) {
            btnAddToCart.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                var parentForm = btnAddToCart.parentElement;
                sendRequest(parentForm, this.value);


            });
        });

        function sendRequest(form, productID) {
            //get current url
            var currentURL = window.location.href;

            //build target url for request
            if (currentURL.indexOf('?') > -1) {
                currentURL += '&ajax=1';
            } else {
                currentURL += '?ajax=1';
            }

            //cancel previous request, if user was too fast
            request.abort();

            request.open('Post', currentURL, true);
            request.setRequestHeader('Accept', 'application/html');
            var formData = new FormData(form);
            formData.append('addToCart', productID);

            request.send(formData);
        }

        request.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    // alert(this.responseText);
                    if (this.responseText > 0) {
                        cartBadge.classList.remove('hidden');

                        if (this.responseText <= 99) {
                            cartBadgeText.innerHTML = this.responseText;
                        } else {
                            cartBadgeText.innerHTML = '+99';
                        }

                    } else {
                        cartBadge.classList.add('hidden');
                    }


                } else {
                    alert(this.statusText);
                }
            }
        }
    }

});