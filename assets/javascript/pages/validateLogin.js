document.addEventListener('DOMContentLoaded', function() {
    var btnSubmit = document.getElementById('submit');

    //get input fields from form
    var email = document.getElementById('email');
    //var password = document.getElementById('user_password');

    if (btnSubmit)
    {
        btnSubmit.addEventListener('click', function(event)
        {
            var formIsValid = true;

            var emailregex = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/m;
            //check if email is set and valid
            if (!email || email.value.length <= 0 || (!email.value.match(emailregex)))
            {
                email.classList.add("errorHighlight");
                formIsValid = false;
            }
            if (!formIsValid)
            {
                event.preventDefault();
                event.stopPropagation();
            }
            return formisValid;
        });
    }
});