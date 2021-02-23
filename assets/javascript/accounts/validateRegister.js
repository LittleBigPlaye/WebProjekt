document.addEventListener('DOMContentLoaded', function () {
    var btnSubmit = document.getElementById('submitForm');

    //get input fields from form
    var firstName = document.getElementById('firstName');
    var secondName = document.getElementById('secondName');
    var lastName = document.getElementById('lastName');
    var email = document.getElementById('email');
    var birthDate = document.getElementById('birthdate');
    var password = document.getElementById('password');
    var password2 = document.getElementById('password2');
    var street = document.getElementById('street');
    var streetNumber = document.getElementById('streetNumber');
    var zipCode = document.getElementById('zipCode');
    var city = document.getElementById('city');

    var registerForm = document.getElementById('registerForm');


    var request = null;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    }

    //check if submit button has been found
    if (btnSubmit) {
        var formIsValid;
        btnSubmit.addEventListener('click', function (event) {
            formIsValid = true;

            //check if firstName is set
            if (!firstName || firstName.value.length <= 0 || firstName.value.length > 50) {
                firstName.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                firstName.classList.remove('errorHighlight');
            }

            //check if secondName is valid
            if (secondName.value.length > 50) {
                secondName.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                secondName.classList.remove('errorHighlight');
            }


            //check if lastName is set
            if (!lastName || lastName.value.length <= 0 || lastName.value.length > 50) {
                lastName.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                lastName.classList.remove('errorHighlight');
            }

            //check if email is set
            if (!email || email.value.length <= 0 || email.value.length > 320) {
                email.classList.add("errorHighlight");
                email.nextElementSibling.innerHTML = 'Bitte geben Sie ihre E-Mail an!';
                formIsValid = false;
            } else {
                email.classList.remove('errorHighlight');
            }

            //check if birthDate is set
            if (!birthDate || birthDate.value.length <= 0) {
                birthDate.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                birthDate.classList.remove('errorHighlight');
            }

            var regex = /^(?=.*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/m;
            if (!password || !password.value.match(regex)) {
                password.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                password.classList.remove('errorHighlight');
                //check if password === password2
                if (password.value === password2.value) {
                    password2.classList.remove("errorHighlight");
                } else {
                    password2.classList.add("errorHighlight");
                    formIsValid = false;
                }
            }

            //check if street is set
            if (!street || street.value.length <= 0 || street.value.length > 255) {
                street.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                street.classList.remove('errorHighlight');
            }

            //check if streetNumber is set
            if (!streetNumber || streetNumber.value.length <= 0 || streetNumber.value.length > 10) {
                streetNumber.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                streetNumber.classList.remove('errorHighlight');
            }

            //check if zipCode is set
            if (!zipCode || zipCode.value.length != 5) {
                zipCode.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                zipCode.classList.remove('errorHighlight');
            }

            //check if city is set
            if (!city || city.value.length <= 0 || city.value.length > 60) {
                city.classList.add("errorHighlight");
                formIsValid = false;
            } else {
                city.classList.remove('errorHighlight');
            }


            if (!formIsValid || request) {
                event.preventDefault();
                event.stopPropagation();
            }

            if (request && !email.classList.contains('errorHighlight')) {
                sendEmailRequest();
            }

            function sendEmailRequest() {
                var formData = new FormData(btnSubmit.parentElement);
                formData.append('ajax', '1');
                formData.append('submitForm', '1');

                request.abort();

                request.open('post', '', true);
                request.setRequestHeader('Accept', 'application/html');
                request.send(formData);
            }

            return formIsValid;
        });

        if (request) {
            request.onreadystatechange = function () {
                if (this.readyState == XMLHttpRequest.DONE) {
                    if (this.status == 200) {
                        //server returns non empty string, if product name is not new
                        if (this.responseText.length != 0) {
                            formIsValid = false;
                            email.classList.add('errorHighlight');
                            email.nextElementSibling.innerHTML = 'Diese Email existiert bereits ';
                        } else {
                            if (formIsValid) {
                                //create hidden input to "emulate" the submit
                                var input = document.createElement("input");
                                input.setAttribute("type", "hidden");
                                input.setAttribute("name", "submitForm");
                                input.setAttribute("value", "submitForm");
                                registerForm.appendChild(input);
                                //submit form if product is new
                                registerForm.submit();
                            }
                        }
                    } else {
                        alert(this.statusText);
                    }
                }
            }
        }
    }
});