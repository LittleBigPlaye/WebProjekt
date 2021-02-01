document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.getElementsByClassName('cartQuantitySubmit');
    var request = null;
    var cartBadgeText = document.getElementById('cartBadgeText');

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
                    var priceSum = document.getElementById('priceSum');
                    var totalPrice = document.getElementById('totalPrice');
                    priceSum.innerHTML = targetArray['totalPrice'];
                    totalPrice.innerHTML = targetArray['totalPrice'];


                    //change display of total number of articles
                    var numberOfProducts = document.getElementById('numberOfProducts');
                    if (parseInt(targetArray['numberOfProducts']) <= 0) {
                        cartBadgeText.parentElement.classList.add('hidden');
                        //remove table and "cart Total"
                        var cartTotal = document.querySelector('.cartTotal');
                        var productTable = document.querySelector('.table');
                        cartTotal.parentElement.removeChild(cartTotal);
                        productTable.parentElement.removeChild(productTable);
                        //add no item message
                        var noItemMessage = document.createElement('P');
                        noItemMessage.innerHTML = 'Es befinden sich keine Artikel in ihrem Warenkorb';
                        noItemMessage.setAttribute('id', 'emptySearchText');
                        noItemMessage.classList.add('emptySearch');
                        document.querySelector('.shoppingCart').append(noItemMessage);
                    } else {
                        cartBadgeText.parentElement.classList.remove('hidden');
                        numberOfProducts.innerHTML = targetArray['numberOfProducts'];
                        if (parseInt(targetArray['numberOfProducts']) <= 99) {
                            cartBadgeText.innerHTML = targetArray['numberOfProducts'];
                        } else {
                            cartBadgeText.innerHTML = '+99';
                        }
                    }


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
        formData.append('ajax', '1');
        var currentURL = window.location.href;

        //cancel previous requests
        request.abort();

        request.open('Post', currentURL, true);
        request.setRequestHeader('Accept', 'application/json');
        request.send(formData);
    }
});