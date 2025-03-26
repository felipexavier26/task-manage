

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Task Manager</a>
            <div class="d-flex ms-auto">
                <a href="#" class="btn btn-danger" onclick="logoutConfirmation()">Sair</a>
            </div>
        </div>
    </nav>


    <div class="container mt-5 custom-container" style="max-width: 1550px; margin: 0 auto; ">
        <div lass="container mt-5 custom-container mb-5" style="max-width: 1550px; ">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-center">Tarefas</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="clearModal()">Adicionar</button>
            </div>
        </div>

        <table id="table" class="table table-bordered table-striped" >
            <thead style="background-color: #343a40; color: white;">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tasksTable">
            </tbody>
        </table>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar/Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Título da Tarefa</label>
                            <input type="text" class="form-control" id="taskTitle" required>
                        </div>

                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Descrição</label>
                            <textarea class="form-control" id="taskDescription" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Status</label>
                            <select class="form-control" id="taskStatus">
                                <option value="pendente">Pendente</option>
                                <option value="em andamento">Em Andamento</option>
                                <option value="concluída">Concluída</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveTask">Salvar Tarefa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluindo o script do DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>