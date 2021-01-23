document.addEventListener('DOMContentLoaded', function() {

    var request = null;

    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    }

    if (request) {
        //used to hide the fallback paging
        var paging = document.getElementById('pagesList');
        //used to show the load form of 
        var loadMoreForm = document.getElementById('loadMoreForm');

        var btnLoadMore = null;
        //the list that contains all product cards
        var productsList = document.getElementById('productsList');
        //an empty product card that can be used as prefab
        var productCardPrefab = document.getElementById('productCardPrefab');
        //reference to the current page number
        var nextPage = document.getElementById('nextPage');

        //hide the default paging
        if (paging) {
            paging.style.display = 'none';
        }

        //show the load more form
        if (loadMoreForm) {
            loadMoreForm.style.display = 'block';
            btnLoadMore = loadMoreForm.querySelector('input[type=submit]');
        }

        if (btnLoadMore) {
            btnLoadMore.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                sendRequest(loadMoreForm);
            });
        }

        //send request with current search parameters
        function sendRequest(form) {
            var formData = new FormData(document.getElementById('loadMoreForm'));
            //cancel previous request, if user was too fast
            request.abort();

            var getString = buildGetString(formData);
            request.open('get', getString, true);
            request.setRequestHeader('Accept', 'application/json');
            request.send();
        }

        //builds get string from form data
        function buildGetString(formData) {
            var getString = 'index.php?';
            for (var pair of formData.entries()) {
                getString += pair[0] + '=' + pair[1] + '&';
            }
            return getString;
        }

        request.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    if (this.responseText != '') {
                        //increase pointer to the next page
                        nextPage.value = (parseInt(nextPage.value) + 1)
                            //retrieve product infos from response
                        var productInfos = JSON.parse(this.responseText);
                        //build new cards for products
                        for (var i = 0; i < productInfos.length; i++) {
                            addProductCard(productInfos[i]);
                        }
                    } else {
                        //hide button, if no other products where found
                        btnLoadMore.style.display = 'none';
                    }

                } else {
                    alert(this.statusText);
                }
            }
        }

        //duplicates the procut card prefab and fills it with the given information
        function addProductCard(cardInfos) {
            //clone the card
            var newProductCard = productCardPrefab.firstElementChild.cloneNode(true);
            newProductCard.classList.add('hidden');

            //set information for the target product card
            newProductCard.querySelector('a').href = 'index.php?c=products&a=view&pid=' + cardInfos['id'];
            newProductCard.querySelector('.productImage').src = cardInfos['image'];
            newProductCard.querySelector('.title').innerHTML = cardInfos['name'];
            newProductCard.querySelector('.catchPhrase').innerHTML = cardInfos['catchPhrase'];
            newProductCard.querySelector('.price').innerHTML = cardInfos['price'] + ' €';

            //set visibility of addTo Card and is Hidden badge
            var addToCartBadge = newProductCard.querySelectorAll('.badge')[0];
            if (cardInfos['isHidden'] == true) {
                addToCartBadge.style.display = 'none';
                newProductCard.querySelector('.productPreview').classList.add('hidden');
            } else {
                newProductCard.querySelectorAll('.badge')[1].style.display = 'none';
            }

            //add the current card to the products list
            productsList.appendChild(newProductCard);
            productsList.lastChild.classList.remove('hidden');
        }
    }

});