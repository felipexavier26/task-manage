<?php
header('Content-Type: application/json');

require_once 'database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (isset($inputData['operation'])) {
        $operation = $inputData['operation'];
    } else {
        $operation = '';
    }

    if ($operation == 'register') {
        if (isset($inputData['username']) && isset($inputData['password'])) {
            $username = $inputData['username'];
            $password = $inputData['password'];

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $response = [
                    'status' => 'error',
                    'message' => 'Nome de usuário já existe!'
                ];
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();

                $response = [
                    'status' => 'success',
                    'message' => 'Cadastro realizado com sucesso!'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Dados insuficientes. Informe o username e password.'
            ];
        }
    } elseif ($operation == 'login') {
        if (isset($inputData['username']) && isset($inputData['password'])) {
            $username = $inputData['username'];
            $password = $inputData['password'];

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $response = [
                    'status' => 'success',
                    'message' => 'Login realizado com sucesso!'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Credenciais inválidas.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Dados insuficientes. Informe o username e password.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Operação inválida.'
        ];
    }

    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método não suportado']);
}
?>
