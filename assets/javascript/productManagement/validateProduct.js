document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submitForm');

    //get input fields from form
    var productImages = document.getElementById('images');
    var productName = document.getElementById('productName');
    var catchPhrase = document.getElementById('catchPhrase');
    var productDescription = document.getElementById('productDescription');
    var productPrice = document.getElementById('productPrice');
    var vendor = document.getElementById('vendor');
    var category = document.getElementById('category');
    var productForm = document.getElementById('productForm');


    var request = null;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    }

    //check if submit button has been found
    if (btnSubmit) {
        var formIsValid = true;

        btnSubmit.addEventListener('click', function(event) {

            formIsValid = true;

            //check if the user uploaded any images
            if (productImages) {
                //check if the user selected at least one image (if current form is for new products)
                if (productForm.classList.contains('new') && productImages.files.length < 1) {
                    productImages.classList.add('errorHighlight');
                    formIsValid = false;
                } else {
                    productImages.classList.remove('errorHighlight');
                }

                //check if each uploaded images has correct type and file size
                for (var i = 0; i < productImages.files.length; i++) {
                    console.log(productImages.files[i]['size']);
                    if (!isValidImage(productImages.files[i])) {
                        productImages.classList.add('errorHighlight');
                        formIsValid = false;
                    }
                }
            }

            //check if product name is set
            if (!productName || productName.value.length <= 0 || productName.value.length > 120) {
                productName.classList.add('errorHighlight');
                productName.nextElementSibling.innerHTML = 'Bitte geben Sie einen Produktnamen an! (max. 120 Zeichen)';
                formIsValid = false;
            } else {
                productName.classList.remove('errorHighlight');
            }

            //check if catchphrase length is okay
            if (!catchPhrase || catchPhrase.value.length > 150) {
                catchPhrase.classList.add('errorHighlight');
                formIsValid = false;
            } else {
                catchPhrase.classList.remove('errorHighlight');
            }

            //check if productDescription is set
            if (!productDescription || productDescription.value.length <= 0 || productDescription.value.length > 5000) {
                productDescription.classList.add('errorHighlight');
                formIsValid = false;
            } else {
                productDescription.classList.remove('errorHighlight');
            }

            //check if product price is valid
            if (productPrice) {
                var priceRegex = /^\d+(\.\d{1,2})?$/;
                if (!productPrice.value.match(priceRegex)) {
                    productPrice.classList.add('errorHighlight');
                    formIsValid = false;
                } else {
                    productPrice.classList.remove('errorHighlight');
                }
            }

            //check if vendor choice is valid
            if (!vendor || vendor.value < 0) {
                vendor.classList.add('errorHighlight');
                formIsValid = false;
            } else {
                vendor.classList.remove('errorHighlight');
            }

            //check if category choice is valid
            if (!category || category.value < 0) {
                category.classList.add('errorHighlight');
                formIsValid = false;
            } else {
                category.classList.remove('errorHighlight');
            }

            if (!formIsValid || request) {
                event.preventDefault();
                event.stopPropagation();
            }

            if (request && !productName.classList.contains('errorHighlight')) {
                sendNameRequest();
            }

            function sendNameRequest() {
                var formData = new FormData(btnSubmit.parentElement);
                formData.append('ajax', '1');
                formData.append('submitForm', '1');

                //abort previous requests
                request.abort();

                request.open('post', '', true);
                request.setRequestHeader('Accept', 'application/html');
                request.send(formData);
            }

            return formIsValid;
        });

        if (request) {
            request.onreadystatechange = function() {
                if (this.readyState == XMLHttpRequest.DONE) {
                    if (this.status == 200) {
                        //server returns non empty string, if product name is not new
                        if (this.responseText.length != 0) {
                            formIsValid = false;
                            productName.classList.add('errorHighlight');
                            productName.nextElementSibling.innerHTML = 'Es existiert bereits ein Produkt mit dem von Ihnen gewählten Namen';
                        } else {
                            if (formIsValid) {
                                //create hidden input to "emulate" the submit
                                var input = document.createElement("input");
                                input.setAttribute("type", "hidden");
                                input.setAttribute("name", "submitForm");
                                input.setAttribute("value", "submitForm");
                                productForm.appendChild(input);
                                //submit form if product is new
                                productForm.submit();
                            }
                        }
                    } else {
                        alert(this.statusText);
                    }
                }
            }
        }
    }

    /**
     * checks if the given file is an image and has a specific max file size
     * @param {*} file 
     */
    function isValidImage(file) {
        var supportedFiles = ['image/jpg', 'image/jpeg', 'image/png'];
        var maxUploadSize = 3000000;
        console.log(file['size'] < maxUploadSize);
        return file && supportedFiles.includes(file['type']) && (file['size'] < maxUploadSize);
    }
});