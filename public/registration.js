const form = document.querySelector('.form');
const firstNameInput = document.querySelector('#first_name');
const lastNameInput = document.querySelector('#last_name');
const passwordInput = document.querySelector('#password');
const passwordConfirmInput = document.querySelector('#password_confirm');

function validate_first_last_name(text){
    if (!(text.trim() === "")){
        const regex = /^[a-zA-Z ]*$/;
        return regex.test(text);
    }
    else {
        return false;
    }
}

function validate_password(password){
    if (password.trim() === ""){
        return false;
    }
    return password.length >= 5;
}

function set_Error(inputNode, message=''){
    const row = inputNode.parentNode;
    const span = row.querySelector('.error-message');

    if (message){
        row.classList.add('error');
        span.textContent = message;
    }
    else {
        row.classList.remove('error');
        span.textContent = '';
    }
}

function validate_password_confirm(password1, password2){
    return password1 === password2;
}

firstNameInput.addEventListener('blur', function (){
    if (!validate_first_last_name(firstNameInput.value)){
        set_Error(firstNameInput, 'First name can only contain letters and white spaces ');
    } else {
        set_Error(firstNameInput);
    }
});

lastNameInput.addEventListener('blur', function (){
    if (!validate_first_last_name(lastNameInput.value)){
        set_Error(lastNameInput, 'Last name can only contain letters and white spaces');
    } else {
        set_Error(lastNameInput);
    }
});

passwordInput.addEventListener('blur', function (){
    if (!validate_password(passwordInput.value)){
        set_Error(passwordInput, 'Password cannot be less than 5 characters');
    } else {
        set_Error(passwordInput);
    }
});

passwordConfirmInput.addEventListener('blur', function (){
    if (!validate_password_confirm(passwordInput.value, passwordConfirmInput.value)){
        set_Error(passwordConfirmInput, 'Passwords do not match');
    } else {
        set_Error(passwordInput);
    }
});


form.addEventListener('submit', function (e){
    e.preventDefault();

    if (!validate_password_confirm(passwordInput.value, passwordConfirmInput.value)) {
        set_Error(passwordConfirmInput, 'Passwords do not match');
        return;
    }

    const formData = new FormData(form);
    formData.append('action', 'register');

    fetch('/public/api/api_post.php',
        {
            method: "POST",
            body: formData
        })

        .then(res => res.json())
        .then(data=>{
            const inputs = document.querySelectorAll('input');
            inputs.forEach((input) => set_Error(input))

            if (data.success){
                window.location = data.redirect;
            }
            else {
                for (let field in data.errors){
                    const input = document.getElementById(field)
                    set_Error(input, data.errors[field]);
                }
            }
        } )
        .catch(err => {
            console.error("Error");

        });
})

