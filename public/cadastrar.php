<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
            <div class="card-body p-4">
                <h2 class="text-center mb-4">Cadastro de Usuário</h2>

                <form id="cadastroForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nome de usuário:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar senha:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>

                    <div class="mt-3">
                        <a href="login.php" style="text-decoration: none;">Lembrou?</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>