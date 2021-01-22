document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submit');

//get input fields from form
    var firstName = document.getElementById('firstName');
    var lastName = document.getElementById('lastName');
    var birthDate = document.getElementById('birthDate');


    //check if submit button has been found
    if (btnSubmit) {
        btnSubmit.addEventListener('click', function(event)
        {
            var formIsValid = true;

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

            //check if birthDate is set
            if (!birthDate || birthDate.value.length <= 0)
            {
                birthDate.classList.add("errorHighlight");
                formIsValid = false;
            } else
            {
                birthDate.classList.remove('errorHighlight');
            }

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }

            return formIsValid;
        });
    }
});