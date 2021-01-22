document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submit');

    var street = document.getElementById('street');
    var streetNumber = document.getElementById('streetNumber');
    var zipCode = document.getElementById('zipCode');
    var city = document.getElementById('city');

    //check if submit button has been found
    if (btnSubmit) {
        btnSubmit.addEventListener('click', function(event)
        {
            var formIsValid = true;
            //check if street is set
            if (!street || street.value.length <= 0)
            {
                street.classList.add("errorHighlight");
                formIsValid = false;
            } else
            {
                street.classList.remove('errorHighlight');
            }

            //check if streetNumber is set
            if (!streetNumber || streetNumber.value.length <= 0)
            {
                streetNumber.classList.add("errorHighlight");
                formIsValid = false;
            } else
            {
                streetNumber.classList.remove('errorHighlight');
            }

            //check if zipCode is set
            if (!zipCode || zipCode.value.length != 5)
            {
                zipCode.classList.add("errorHighlight");
                formIsValid = false;
            } else
            {
                zipCode.classList.remove('errorHighlight');
            }

            //check if city is set
            if (!city || city.value.length <= 0)
            {
                city.classList.add("errorHighlight");
                formIsValid = false;
            } else
            {
                city.classList.remove('errorHighlight');
            }

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }

    return formIsValid;
});
}

});