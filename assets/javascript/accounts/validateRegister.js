document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submit');

//get input fields from form
    var firstName = document.getElementById('firstName');
    var lastName = document.getElementById('lastName');
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var password2 = document.getElementById('password2');
    var birthDate = document.getElementById('birthdate');

    var street = document.getElementById('street');
    var streetNumber = document.getElementById('streetNumber');
    var zipCode = document.getElementById('zipCode');
    var city = document.getElementById('city');


    //check if submit button has been found
    if (btnSubmit) {
        btnSubmit.addEventListener('click', function(event)
        {
            var isValid = true;

            //check if firstName is set
            if (!firstName || firstName.value.length <= 0)
            {
                firstName.classList.add("errorHighlight");
                formIsValid = false;
            }
            else
                {
                firstName.classList.remove('errorHighlight');
            }

            //check if lastName is set
            if (!lastName || lastName.value.length <= 0)
            {
                lastName.classList.add("errorHighlight");
                formIsValid = false;
            } else
                {
                lastName.classList.remove('errorHighlight');
            }

            //check if email is set
            if (!email || email.value.length <= 0)
            {
                email.classList.add("errorHighlight");
                formIsValid = false;
            } else
                {
                email.classList.remove('errorHighlight');
            }

            //check if email is set
            if (!birthDate || birthDate.value.length <= 0)
            {
                birthDate.classList.add("errorHighlight");
                formIsValid = false;
            } else
                {
                birthDate.classList.remove('errorHighlight');
            }

        });
    }




});