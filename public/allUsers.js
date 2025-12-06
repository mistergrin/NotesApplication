document.addEventListener('DOMContentLoaded', function () {

    tbody = document.getElementById('users-table');

    fetch('/public/api/api_get.php?action=get_all_users')
        .then(res=>res.json())
        .then(data=>{
            if (data.success){
                data.users.forEach(user =>{
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.nickname}</td>
                        <td>${user.firstname}</td>
                        <td>${user.lastname}</td>
                        <td>${user.role}</td>
                        <td></td> `;
                    tbody.appendChild(tr);

                    if (user.role !== "ADMIN"){
                        const buttonsTd = tr.querySelector('td:last-child');
                        buttonsTd.innerHTML = `
                            <button class="delete-button">Delete</button>
                            <button class="upgrade-button">Upgrade Role</button>`;
                    }

                    const deleteButton = tr.querySelector('.delete-button');
                    if (deleteButton){
                    deleteButton.addEventListener('click', function (){
                        const userId = user.id;
                        const formData = new FormData();
                        formData.append('action', 'delete_user');
                        formData.append('id', userId);

                        fetch('/public/api/api_post.php',{
                            method: "POST",
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data=>{
                                if (data.success){
                                    tr.remove();
                                }
                                else {
                                    alert(data.errors);
                                }
                            })
                            .catch(err=>{
                                console.error(err);
                            });

                    })}
                    const upgradeButton = tr.querySelector('.upgrade-button');
                    if (upgradeButton){
                        upgradeButton.addEventListener('click', function () {
                            const userId = user.id;
                            const formData = new FormData();
                            formData.append('action', 'upgrade_role');
                            formData.append('id', userId);

                            fetch('/public/api/api_post.php', {
                                method: "POST",
                                body: formData
                            })
                                .then(res=> res.json())
                                .then(data=>{
                                    if (data.success){
                                        user.role = 'ADMIN';
                                        tr.querySelector('td:nth-child(5)').textContent = user.role;
                                        const buttonsTd = tr.querySelector('td:nth-child(6)');
                                        buttonsTd.innerHTML = '';
                                    }
                                    else {
                                        alert(data.errors);
                                    }
                                })
                                .catch(err=>{
                                    console.error((err));
                                })
                        })
                    }
                });
            }
        })
        .catch(err=>{
            console.error(err);
        });
});
