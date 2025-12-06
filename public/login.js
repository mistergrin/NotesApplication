const form = document.querySelector('form');
const nicknameInput = document.querySelector('#nickname');
const passwordInput = document.querySelector('#password');


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

function is_empty_nickname_password(text){
    return text.trim() === "";
}


nicknameInput.addEventListener('blur', function (){
    if (is_empty_nickname_password(nicknameInput.value)){
        set_Error(nicknameInput, "Nickname can not be empty");
    }
    else {
        set_Error(nicknameInput);
    }
});

passwordInput.addEventListener('blur', function (){
    if (is_empty_nickname_password(passwordInput.value)){
        set_Error(passwordInput, "Password can not be empty");
    }
    else {
        set_Error(passwordInput);
    }
});

form.addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(form);
    formData.append('action', 'login')

    fetch('/public/api/api_post.php',{
        method: "POST",
        body: formData

    })
        .then(res => res.json())
        .then(data=>{

            const inputs = document.querySelectorAll('input');
            inputs.forEach((input) => set_Error(input));

            if (data.success){
                window.location = data.redirect;
            }
            else {
                for (let field in data.errors){
                    const input = document.getElementById(field)
                    set_Error(input, data.errors[field]);
                }
            }
        })
        .catch(err => {console.log("error")
        });
})

