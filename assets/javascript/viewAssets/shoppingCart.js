/**
 * This script is used to add items to the cart without reloading the site
 */
var cartRequest = null;
var btnCartAdders = null;
var cartBadgeText = null;

document.addEventListener('DOMContentLoaded', function() {
    //get all cart buttons of the current page
    btnCartAdders = document.getElementsByClassName('cartButton');
    cartBadge = document.getElementById('cartBadge');

    if (cartBadge.childNodes.length >= 1) {
        cartBadgeText = cartBadge.childNodes[0];
    }



    if (window.XMLHttpRequest) {
        cartRequest = new XMLHttpRequest();
    }

    if (cartRequest) {
        //add a listener to all found buttons
        Array.prototype.forEach.call(btnCartAdders, function(btnAddToCart) {
            btnAddToCart.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                var parentForm = btnAddToCart.parentElement;
                sendCartRequest(parentForm, this.value);
            });
        });



        cartRequest.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    //check if there are items in the cart
                    if (this.responseText > 0) {
                        //show the cart badge
                        cartBadge.classList.remove('hidden');

                        //set badge text to cart count, otherwise to +99
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

//declared outsite to access it from listProducts.js
function sendCartRequest(form, productID) {
    if (cartRequest) {
        //get current url
        var currentURL = window.location.href;

        //build target url for request
        if (currentURL.indexOf('?') > -1) {
            currentURL += '&ajax=1';
        } else {
            currentURL += '?ajax=1';
        }

        //cancel previous request, if user was too fast
        cartRequest.abort();

        cartRequest.open('Post', currentURL, true);
        cartRequest.setRequestHeader('Accept', 'application/html');
        var formData = new FormData(form);
        formData.append('addToCart', productID);

        cartRequest.send(formData);
    }
}