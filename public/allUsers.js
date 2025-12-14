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
                    createPaginationButton("Prev", data.page - 1, pagination, loadUsers, data.pages);
                    for (let i = 1; i <= data.pages; i++) {
                        createPaginationButton(i, i, pagination, loadUsers, data.pages);
                    }
                    createPaginationButton("Next", data.page + 1, pagination, loadUsers, data.pages);
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

