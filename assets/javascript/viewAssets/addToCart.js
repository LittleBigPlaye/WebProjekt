/**
 * This script is used to add items to the shopping cart via ajax
 * @author Robin Beck
 */
var cartRequest = null;
var btnCartAdders = null;
var cartBadgeText = null;

document.addEventListener('DOMContentLoaded', function () {
    //get all cart buttons of the current page
    btnCartAdders = document.getElementsByClassName('cartButton');
    cartBadge = document.getElementById('cartBadge');
    cartBadgeText = document.getElementById('cartBadgeText');




    if (window.XMLHttpRequest) {
        cartRequest = new XMLHttpRequest();
    }

    if (cartRequest) {
        //add a listener to all found buttons
        Array.prototype.forEach.call(btnCartAdders, function (btnAddToCart) {
            btnAddToCart.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                var parentForm = btnAddToCart.parentElement;
                sendCartRequest(parentForm, this.value);
            });
        });



        cartRequest.onreadystatechange = function () {
            if (this.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    //check if there are items in the cart
                    if (this.responseText > 0) {
                        //show the cart badge
                        cartBadge.classList.remove('hidden');

                        //set badge text to cart count, otherwise to +99
                        if (parseInt(this.responseText) <= 99) {
                            cartBadgeText.innerHTML = this.responseText;
                        } else {
                            cartBadgeText.innerHTML = '+99';
                        }


                    } else {
                        cartBadge.classList.add('hidden');
                    }

                } else {
                    alert('Da hat etwas nicht funktioniert!\nBitte versuchen Sie es erneut oder Laden Sie die Seite neu, sollte der Fehler weiterhin bestehen.');
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

        //cancel previous request, if user was too fast
        cartRequest.abort();

        cartRequest.open('Post', currentURL, true);
        cartRequest.setRequestHeader('Accept', 'application/html');
        var formData = new FormData(form);
        formData.append('ajax', '1');
        formData.append('addToCart', productID);

        cartRequest.send(formData);
    }
}