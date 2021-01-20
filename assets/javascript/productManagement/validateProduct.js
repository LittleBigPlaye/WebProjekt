document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submit');

    //get input fields from form
    var productImages = document.getElementById('images');
    var productName = document.getElementById('productName');
    var catchPhrase = document.getElementById('catchPhrase');
    var productDescription = document.getElementById('productDescription');
    var productPrice = document.getElementById('productPrice');
    var vendor = document.getElementById('vendor');
    var category = document.getElementById('category');
    var productForm = document.getElementById('productForm');

    //check if submit button has been found
    if (btnSubmit) {
        btnSubmit.addEventListener('click', function(event) {
            var formIsValid = true;

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

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }

            return formIsValid;
        });
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