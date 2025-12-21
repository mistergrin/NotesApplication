const nicknameInput = document.querySelector('#nickname');
const firstNameInput = document.querySelector('#first_name');
const lastNameInput = document.querySelector('#last_name');
const form = document.querySelector('form');
const editBtn = document.querySelector('#editBtn');
const cancelBtn = document.querySelector('#cancelButton');
const profileInfo = document.querySelector('.profile-info')
const profileFormContainer = document.querySelector('#profileFormContainer');


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

function validate_first_last_name(text){
    if (!(text.trim() === "")){
        const regex = /^[a-zA-Z ]*$/;
        return regex.test(text);
    }
    else {
        return false;
    }
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

editBtn.addEventListener('click', function () {
    profileInfo.classList.add('hidden');
    profileFormContainer.classList.remove('hidden');
});

cancelBtn.addEventListener('click', function () {
    profileFormContainer.classList.add('hidden');
    profileInfo.classList.remove('hidden');
});


form.addEventListener('submit', function (e){
    e.preventDefault();
    const formData = new FormData(form);
    formData.append('action', 'edit');

    fetch('/~hryshiva/site/public/api/api_post.php', {
        method: "POST",
        body: formData,
    })
        .then(res => res.json())
        .then(data=>{

            const inputs = document.querySelectorAll('input');
            inputs.forEach((input) => set_Error(input));

            if (data.success){
                profileFormContainer.classList.add('hidden');
                profileInfo.classList.remove('hidden');

                document.querySelector('#newNickName').textContent = formData.get('nickname');
                document.querySelector('#newFirstName').textContent = formData.get('first_name');
                document.querySelector('#newLastName').textContent = formData.get('last_name');
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


