const form = document.querySelector('form');
const text = document.querySelector('textarea');
const image = document.querySelector('#image');



const allowed_types = ['jpeg', 'png', 'gif', 'jpg'];
const maxLength = 3000;

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

function validate_text(text) {
    if (text.trim() === "") {
        return "empty";
    }
    if (text.length > maxLength) {
        return "too_long";
    }
    return true;
}


function validate_image(input){

    const image = input.files[0];
    const type = image.type.split('/')[1];

    return allowed_types.includes(type);
}

text.addEventListener('blur', function () {
    const result = validate_text(text.value);

    if (result === "empty") {
        set_Error(text, "Text cannot be empty");
    }
    else if (result === "too_long") {
        set_Error(text, "Too big text. Maximum are 3000 symbols");
    }
    else {
        set_Error(text);
    }
});

image.addEventListener('change', function (){
        if (!validate_image(this)){
        set_Error(image, "This image type is incorrect. Allowed types: JPEG, PNG, GIF, JPG ");
    }
    else {
        set_Error(image);
    }
})

form.addEventListener('submit', function(e){
    e.preventDefault();
    
    const btn = document.querySelector(".create-note");
    btn.disabled = true;

    const formData = new FormData(form);
    formData.append('action', 'create_note');

    fetch("/~hryshiva/site/public/api/api_post.php", {
        method: "POST",
        body: formData
    })
        .then(res=> res.json())
        .then(data=>{
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => set_Error(input))
            if (data.success){
                window.location = data.redirect
            }
            else {
                btn.disabled = false;
                for (let field in data.errors){
                    const input = document.getElementById(field)
                    set_Error(input, data.errors[field]);
                }
            }
        } )
        .catch(err => {
            console.error("Error");
            btn.disabled = false;
        });
})