//Cadastro de Usuário
$('#cadastroForm').submit(function (e) {
    e.preventDefault();

    var username = $('#username').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm_password').val();

    if (password !== confirmPassword) {
        Swal.fire({
            title: 'Erro!',
            text: 'As senhas não coincidem!',
            icon: 'error',
            confirmButtonText: 'Tentar Novamente'
        });
        return;
    }

    $.ajax({
        url: 'http://localhost/task-manager/task-api/login.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            operation: 'register',
            username: username,
            password: password
        }),
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: 'Sucesso!',
                    text: response.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = 'login.php';
                });
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'Tentar Novamente'
                });
            }
        },
        error: function () {
            Swal.fire({
                title: 'Erro!',
                text: 'Erro ao cadastrar usuário. Tente novamente.',
                icon: 'error',
                confirmButtonText: 'Tentar Novamente'
            });
        }
    });
});

//Login de Usuário
$('#loginForm').submit(function (e) {
    e.preventDefault();

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
        url: 'http://localhost/task-manager/task-api/login.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            operation: 'login',
            username: username,
            password: password
        }),
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: 'Login bem-sucedido!',
                    text: 'Você será redirecionado para a página inicial.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = 'index.php';
                });
            } else {
                Swal.fire({
                    title: 'Erro de Login',
                    text: 'Credenciais inválidas! Por favor, tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'Tentar Novamente'
                });
            }
        },
        error: function () {
            Swal.fire({
                title: 'Erro!',
                text: 'Ocorreu um erro ao tentar realizar o login.',
                icon: 'error',
                confirmButtonText: 'Tentar Novamente'
            });
        }
    });
});

//Dados página inicial
let editingTaskId = null;

document.getElementById('saveTask').addEventListener('click', function () {
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;
    const status = document.getElementById('taskStatus').value;

    if (title && description && status) {
        const url = editingTaskId ? 
            `http://localhost/task-manager/task-api/?id=${editingTaskId}` : 
            'http://localhost/task-manager/task-api/';

        const method = editingTaskId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                title: title,
                description: description,
                status: status
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Sucesso!', `Tarefa ${editingTaskId ? 'atualizada' : 'adicionada'} com sucesso!`, 'success')
                        .then(() => {
                            loadTasks();  
                            var myModal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                            myModal.hide();
                            clearModal();
                            location.reload(); 
                        });
                } else {
                    Swal.fire('Erro!', `Erro ao ${editingTaskId ? 'atualizar' : 'adicionar'} a tarefa!`, 'error');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar tarefa:', error);
                Swal.fire('Erro!', 'Erro ao salvar a tarefa!', 'error');
            });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Por favor, preencha todos os campos!'
        });
    }
});

function loadTasks() {
    fetch('http://localhost/task-manager/task-api/')
        .then(response => response.json())
        .then(data => {
            const tasksTable = document.getElementById('tasksTable');
            tasksTable.innerHTML = '';
            console.log(data);

            data.forEach(task => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.title}</td>
                    <td>${task.description}</td>
                    <td>${task.status}</td>
                    <td>${new Date(task.created_at).toLocaleDateString('pt-BR')}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editTask(${task.id})">Editar</button>
                        <button class="btn btn-danger" onclick="deleteTask(${task.id})">Excluir</button>
                    </td>
                `;
                tasksTable.appendChild(row);
            });

            if ($.fn.dataTable.isDataTable('#table')) {
                $('#table').DataTable().clear().destroy();
            }

            $('#table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                },
            });
        })
        .catch(error => {
            console.error('Erro ao carregar as tarefas:', error);
            Swal.fire('Erro!', 'Erro ao carregar as tarefas.', 'error');
        });
}

function editTask(taskId) {
    fetch(`http://localhost/task-manager/task-api/?id=${taskId}`)
        .then(response => response.json())
        .then(task => {
            if (task && task.id) {
                document.getElementById('taskTitle').value = task.title || '';
                document.getElementById('taskDescription').value = task.description || '';

                const statusSelect = document.getElementById('taskStatus');
                const normalizedStatus = task.status ? task.status.trim().toLowerCase() : 'pendente';

                let found = false;
                for (let option of statusSelect.options) {
                    if (option.value.toLowerCase() === normalizedStatus) {
                        statusSelect.value = option.value;
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    statusSelect.value = 'pendente';
                }
                editingTaskId = task.id;
                const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            } else {
                console.error('Tarefa não encontrada ou dados inválidos:', task);
                Swal.fire('Erro!', 'Tarefa não encontrada!', 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao obter tarefa:', error);
            Swal.fire('Erro!', 'Erro ao carregar as informações da tarefa!', 'error');
        });
}

function deleteTask(taskId) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`http://localhost/task-manager/task-api/?id=${taskId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Excluída!', 'A tarefa foi excluída com sucesso.', 'success');
                        loadTasks();
                    } else {
                        Swal.fire('Erro!', 'Houve um erro ao excluir a tarefa.', 'error');
                    }
                })
                .catch(error => console.error('Erro ao excluir a tarefa:', error));
        }
    });
}

function clearModal() {
    document.getElementById('taskForm').reset();
    editingTaskId = null;
}

window.onload = loadTasks;

function logoutConfirmation() {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você deseja sair da sua conta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, sair!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'login.php'; 
        }
    });
}
