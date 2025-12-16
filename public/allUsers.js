document.addEventListener("DOMContentLoaded", function (){
    loadUsers();
})

function loadUsers(page = 1) {
    const tbody = document.getElementById('users-table');

    fetch(`/public/api/api_get.php?action=get_all_users&page=${page}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const pagination = document.querySelector(".pagination");
                tbody.innerHTML = '';

                data.users.forEach(user => {
                    const tr = document.createElement('tr');

                    function createTd(text) {
                        const td = document.createElement('td');
                        td.textContent = text;
                        return td;
                    }

                    const actionsTd = document.createElement('td');
                    tr.appendChild(createTd(user.nickname));
                    tr.appendChild(createTd(user.firstname));
                    tr.appendChild(createTd(user.lastname));
                    tr.appendChild(createTd(user.role));

                    if (user.role !== "ADMIN") {
                        const deleteButton = document.createElement('button');
                        const upgradeButton = document.createElement('button');

                        deleteButton.className = 'delete-button';
                        deleteButton.textContent = 'Delete';
                        deleteButton.addEventListener('click', () => deleteUser(user.id, tr));

                        upgradeButton.className = 'upgrade-button';
                        upgradeButton.textContent = 'Upgrade Role';
                        upgradeButton.addEventListener('click', () => upgradeUserRole(user.id, tr, actionsTd, user));

                        actionsTd.append(deleteButton, upgradeButton);
                    }

                    tr.appendChild(actionsTd);
                    tbody.appendChild(tr);
                });
                pagination.innerHTML = '';
                if (data.total > 0) {
                    renderPagination(data.page, data.pages, pagination);
                }
            }})
        .catch(console.error);
}

function createPaginationButton(text, page, container, callback, totalPages) {

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

function upgradeUserRole(id, row, actionsTd, user) {
    const formData = new FormData();
    formData.append('action', 'upgrade_role');
    formData.append('id', id);

    fetch('/public/api/api_post.php', {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                user.role = 'ADMIN';
                row.children[3].textContent = 'ADMIN';
                actionsTd.innerHTML = '';
            }
        })
        .catch(console.error);
}

function deleteUser(id, row) {
    const formData = new FormData();
    formData.append('action', 'delete_user');
    formData.append('id', id);

    fetch('/public/api/api_post.php', {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                row.remove();
                loadUsers();
            }
        })
        .catch(console.error);
}

function addDots(container) {
    const span = document.createElement("span");
    span.textContent = "...";
    span.className = "pagination-dots";
    container.appendChild(span);
}

function renderPagination(currentPage, totalPages, container) {
    container.innerHTML = '';

    const delta = 1;
    createPaginationButton("Prev", currentPage - 1, container, loadUsers, totalPages, currentPage);
    createPaginationButton(1, 1, container, loadUsers, totalPages, currentPage);

    if (currentPage - delta > 2) {
        addDots(container);
    }
    for (let i = Math.max(2, currentPage - delta); i <= Math.min(totalPages - 1, currentPage + delta); i++) {
        createPaginationButton(i, i, container, loadUsers, totalPages, currentPage);
    }

    if (currentPage + delta < totalPages - 1) {
        addDots(container);
    }

    if (totalPages > 1) {
        createPaginationButton(totalPages, totalPages, container, loadUsers, totalPages, currentPage);
    }
    createPaginationButton("Next", currentPage + 1, container, loadUsers, totalPages, currentPage);
}
