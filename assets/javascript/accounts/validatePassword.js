document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submit');

    var password = document.getElementById('password');
    var password2 = document.getElementById('password2');


    //check if submit button has been found
    if (btnSubmit) {
        btnSubmit.addEventListener('click', function(event)
        {
            var formIsValid = true;

            var regex= /^(?=.*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/m;
            if(!password || password.value.length < 8 || !password.value.match(regex))
            {
                password.classList.add("errorHighlight");
                formIsValid = false;
            }

            if(!password2 || password2.value.length < 8 || !password2.value.match(regex))
            {
                password2.classList.add("errorHighlight");
                formIsValid = false;
            }

            //check if password === password2
            if(password.value === password2.value)
            {
                password.classList.remove('errorHighlight');
                password2.classList.remove("errorHighlight");
            }
            else
            {
                password.classList.add('errorHighlight');
                password2.classList.add("errorHighlight");
                formIsValid = false;
            }

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }

            return formIsValid;
        });
    }
});