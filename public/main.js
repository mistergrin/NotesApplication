function createCard(note) {
    const div = document.createElement("div");
    const dateDiv = document.createElement("div");
    const textDiv = document.createElement("div");
    const button = document.createElement("button");

    div.classList.add("note-card");
    const text = note.text
    div.dataset.fullText = note.text;
    let shortText

    if (text.length > 150) {
        shortText = note.text.substring(0, 150) + "...";
    } else {
        shortText = text;
    }

    textDiv.className = "note-text";
    textDiv.textContent = shortText;
    textDiv.style.whiteSpace = "pre-line";
    div.appendChild(textDiv);

    if (note.image) {
        const img = document.createElement("img");
        img.className = "note-img";
        img.src = note.image;
        img.alt = "";
        div.appendChild(img);
    }

    dateDiv.className = "note-date";
    if (note.updated_at) {
        dateDiv.textContent = `Last edited at: ${note.updated_at}`;
    } else {
        dateDiv.textContent = `Created at: ${note.date}`;
    }
    div.appendChild(dateDiv);

    button.className = "read-more";
    button.dataset.id = note.id;
    button.textContent = "Read more";
    div.appendChild(button);

    return div;
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


function createPaginationButton(text, page, currentPage, container, callback, totalPages) {
    const btn = document.createElement("button");
    btn.classList.add("pagination-button");
    btn.textContent = text;

    let shouldDisable = false;
    if (page < 1) {
        shouldDisable = true;
    }
    else if (page > totalPages) {
        shouldDisable = true;
    }
    btn.disabled = shouldDisable;

    btn.addEventListener("click", () => callback(page));
    container.appendChild(btn);
}


function loadNotes(page = 1){
    fetch(`public/api/api_get.php?action=get_notes_by_user&page=${page}`)
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector(".notes-container");
            container.innerHTML = '';
            const pagination = document.querySelector(".pagination");
            pagination.innerHTML = '';

            if(data.notes.length > 0){
                data.notes.forEach(note => container.appendChild(createCard(note)));

                const pagination = document.querySelector(".pagination");
                pagination.innerHTML = '';

                createPaginationButton("Prev", data.page - 1, data.page, pagination, loadNotes, data.pages);
                for (let i = 1; i <= data.pages; i++) {
                    createPaginationButton(i, i, data.page, pagination, loadNotes, data.pages);
                }
                createPaginationButton("Next", data.page + 1, data.page, pagination, loadNotes, data.pages);

                }
            else {
                const message = document.createElement('div');
                message.className = 'no-notes-message';
                message.textContent = "You haven’t created any notes yet.";
                document.body.appendChild(message);
            }})
        .catch(err => {
        console.error("Error")});
}


document.addEventListener("DOMContentLoaded", ()=>
loadNotes())

document.addEventListener("click", function (e){
    if (e.target.classList.contains("read-more")){
        const modal = document.querySelector("#modal");
        const textModal = modal.querySelector(".modal-text");
        const modalImage = modal.querySelector(".modal-image");
        const date = modal.querySelector(".modal-date");
        const card = e.target.closest(".note-card");
        const imgElement = card.querySelector(".note-img");
        const cardDate = card.querySelector(".note-date").textContent;
        textModal.textContent = card.dataset.fullText;
        textModal.style.whiteSpace = "pre-line";

        modalImage.innerHTML = "";
        if (imgElement) {
            const modalImg = document.createElement("img");
            modalImg.src = imgElement.src;
            modalImg.className = "note-img";
            modalImg.alt = "";
            modalImage.appendChild(modalImg);
        }

        date.textContent = cardDate;
        modal.dataset.id = e.target.dataset.id;
        modal.style.display = "flex";
    }
})

document.addEventListener("click", function (e){
    const modal = document.querySelector("#modal");
    if (e.target.classList.contains("modal-close") || e.target === modal) {
        modal.style.display = "none";
        document.querySelector("#modal-edit-block").classList.add("hidden");
    }
})

document.addEventListener("click", function(e){
    if (e.target.classList.contains("modal-delete")){
        const modal = document.querySelector("#modal");
        const noteId = modal.dataset.id;

        const apiData = new FormData();
        apiData.append('action', 'delete_note');
        apiData.append('id', noteId);

        fetch("public/api/api_post.php", {
            method: "POST",
            body: apiData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success){
                    const card = document.querySelector(`button[data-id="${noteId}"]`).closest(".note-card");

                    loadNotes();
                    card.remove();
                    modal.style.display = "none";
                }
            })
            .catch(err => {
                console.error("Error")});
    }})

document.addEventListener("click", function (e) {
    if (e.target.classList.contains("modal-edit")) {
        const modal = document.querySelector("#modal");
        const editBlock = document.querySelector("#modal-edit-block");
        const editTextarea = editBlock.querySelector(".modal-edit-text");
        const modalText = modal.querySelector(".modal-text");
        const errorSpans = editBlock.querySelectorAll(".error-message");
        const errorRows = editBlock.querySelectorAll(".row.error");

        errorSpans.forEach(span=> span.textContent = '');
        errorRows.forEach(row => row.classList.remove('error'));
        editTextarea.value = modalText.textContent;
        editBlock.classList.remove("hidden");
    }
});

document.querySelector(".modal-edit-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const modal = document.querySelector("#modal");
    const noteId = modal.dataset.id;
    const card = document.querySelector(`button[data-id="${noteId}"]`).closest('.note-card');
    const textElement = card.querySelector('.note-text');
    const modalText = modal.querySelector(".modal-text");
    const modalImage = modal.querySelector(".modal-image");
    const dateDiv = card.querySelector(".note-date");
    const modalDate = modal.querySelector(".modal-date");

    const newText = form.querySelector('textarea').value;
    const formData = new FormData(form);
    formData.append('action', 'edit_note');
    formData.append('id', noteId);

    fetch('/public/api/api_post.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                card.dataset.fullText = newText;
                textElement.textContent = newText.length > 150 ? newText.substring(0, 150) + "..." : newText;
                textElement.style.whiteSpace = "pre-line";

                modalText.textContent = newText;
                modalText.style.whiteSpace = "pre-line";

                const formattedDate = `Last edited at: ${data.updated_at}`;
                dateDiv.textContent = formattedDate;
                modalDate.textContent = formattedDate;

                modalImage.innerHTML = "";
                if (data.new_image_path) {
                    let imgElement = card.querySelector('img.note-img');
                    if (!imgElement) {
                        imgElement = document.createElement("img");
                        imgElement.className = "note-img";
                        card.insertBefore(imgElement, textElement);
                    }
                    imgElement.src = data.new_image_path;
                    imgElement.alt = "";

                    const modalImg = document.createElement("img");
                    modalImg.src = data.new_image_path;
                    modalImg.className = "note-img";
                    modalImg.alt = "";
                    modalImage.appendChild(modalImg);
                }
                loadNotes();
                form.reset();
                document.querySelector("#modal-edit-block").classList.add("hidden");
            } else if (data.errors) {
                for (let field in data.errors) {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) set_Error(input, data.errors[field]);
                }
            }
        })
        .catch(err => console.error(err));
});