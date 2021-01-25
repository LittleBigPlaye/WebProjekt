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
        var productList = document.getElementById('productsList');
        //an empty product card that can be used as prefab
        var productCardPrefab = document.getElementById('productCardPrefab');
        //reference to the current page number
        var nextPage = 2;

        var filterForm = document.getElementById('filterForm');

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
                sendRequest(filterForm);
            });
        }


        //clear all products cards and fetch new cards when filtering
        var btnFilter = null;
        if (filterForm) {
            btnFilter = filterForm.querySelector('input[type=submit]');
            if (btnFilter) {
                btnFilter.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    clearProductList();
                    sendRequest(filterForm);
                    btnLoadMore.style.display = 'block';
                });
            }
        }

        //clear all products and fetch found cards when searching
        var btnSearch = document.getElementById('searchSubmit');
        var searchInput = document.getElementById('search');
        if (btnSearch && searchInput) {
            btnSearch.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                clearProductList();
                //replace all characters that are not alphanumeric
                var searchString = searchInput.value.replace(/[^A-Za-z0-9äöüß ]/, '');
                console.log(searchString);
                //shorten the search String to a maximum of 200 characters
                if (searchString.length > 200) {
                    searchString.value = searchString.value.substr(0, 200);
                }

                //apply searchString to hidden search in filterForm
                var hiddenSearch = document.getElementById('hiddenSearch');
                hiddenSearch.value = searchString;
                sendRequest(filterForm);
                btnLoadMore.style.display = 'block';
            });
        }

        function clearProductList() {
            while (productList.firstChild) {
                productList.removeChild(productList.firstChild);
            }
            //reset nextPage variable
            nextPage = 1;
            //remove "no products found" string, if available
            var emptySearchText = document.getElementById(emptySearchText);
            if (emptySearchText) {
                emptySearchText.parentElement.remove(emptySearchText);
            }

        }

        //send request with current search parameters
        function sendRequest(form) {
            var formData = new FormData(form);

            //used to replace the browser url
            //used before adding the page value, to prevent the user from getting the plain json output
            var targetURL = buildGetString(formData);

            formData.append('page', nextPage);

            //cancel previous request, if user was too fast
            request.abort();

            var getString = buildGetString(formData);

            if (window.history.replaceState) {
                window.history.replaceState(null, '', targetURL);
            }

            request.open('Post', getString, true);
            request.setRequestHeader('Accept', 'application/json');

            //send ajax = 1 to prevent users from accessing the returned json via get
            var formData = new FormData();
            formData.append('ajax', '1');
            request.send(formData);
        }

        //builds get string from form data
        function buildGetString(formData) {
            var getString = 'index.php?';
            for (var pair of formData.entries()) {
                //prevent adding empty hidden parameters to get string
                if (pair[1] != '') {
                    getString += pair[0] + '=' + pair[1] + '&';
                }
            }
            //remove last & from the string
            getString = getString.substring(0, getString.length - 1);
            //encode string for url
            getString = encodeURI(getString);
            return getString;
        }

        //wait for responses from server
        request.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE) {
                if (this.status == 200) {
                    if (this.responseText != '') {
                        //increase pointer to the next page
                        nextPage++;
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
                    //hide button, of no products where found
                    btnLoadMore.style.display = 'none';
                    //add no products found text
                    var emptySearchText = document.createElement('P');
                    emptySearchText.innerHTML = 'Es wurden keine Artikel gefunden, die mit Ihrer Suche übereinstimmen';
                    emptySearchText.setAttribute('id', 'emptySearchText');
                    emptySearchText.classList.add('emptySearch');
                    productList.parentElement.appendChild(emptySearchText);
                }
            }
        }

        //duplicates the procut card prefab and fills it with the given information
        function addProductCard(cardInfos) {
            //clone the card
            var newProductCard = productCardPrefab.firstElementChild.cloneNode(true);

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

            //retrieve add to cart button
            var addToCartButton = newProductCard.querySelector('.cartButton');
            if (addToCartButton) {
                addToCartButton.value = cardInfos['id'];
                addToCartButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    var parentForm = addToCartButton.parentElement;
                    //function is declared in shoppingCart.js
                    sendCartRequest(parentForm, this.value);
                })
            }

            //add the current card to the products list
            productList.appendChild(newProductCard);
        }
    }

});