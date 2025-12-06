function createCard(note) {
    const div = document.createElement("div");

    div.classList.add("note-card");
    const text = note.text
    div.dataset.fullText = note.text;
    let shortText

    if (text.length > 150) {
        shortText = note.text.substring(0, 150) + "...";
    } else {
        shortText = text;
    }

    div.innerHTML = ` <div class="note-text">${shortText.replace(/\n/g, "<br>")}</div>
    ${note.image ? `<img src="${note.image}" class="note-img">` : ""}
    <div class="note-date">${note.date}</div>
    <button class="read-more" data-id="${note.id}">Read more</button>`;

    return div
}


document.addEventListener("DOMContentLoaded", function (){
    fetch("/public/api/api_get.php?action=get_notes_by_user")
        .then(res=> res.json())
        .then(data=>{
            if (data.success){
                const container = document.querySelector(".notes-container");
                data.notes.forEach(note=>{
                    container.appendChild(createCard(note));
                })
            }
        })
        .catch()
})

document.addEventListener("click", function (e){
    if (e.target.classList.contains("read-more")){
        const modal = document.querySelector("#modal");
        const textModal = modal.querySelector(".modal-text");
        const modalImage = modal.querySelector(".modal-image");
        const date = modal.querySelector(".modal-date");
        const card = e.target.closest(".note-card");
        const imgElement = card.querySelector(".note-img");
        const cardDate = card.querySelector(".note-date").textContent;
        textModal.innerHTML = card.dataset.fullText.replace(/\n/g, "<br>");

        let imgSrc
        if (imgElement) {
            imgSrc = imgElement.src;
        } else {
            imgSrc = null;
        }

        if (imgSrc) {
            modalImage.innerHTML = `<img src="${imgSrc}">`;
        } else {
            modalImage.innerHTML = "";
        }
        date.innerHTML = cardDate;
        modal.style.display = "flex";
    }
})

document.addEventListener("click", function (e){
    const modal = document.querySelector("#modal");
    if (e.target.classList.contains("modal-close") || e.target === modal) {
        modal.style.display = "none";
    }
})