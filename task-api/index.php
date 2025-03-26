<?php

header('Content-Type: application/json');

require_once 'database.php'; 

$requestMethod = $_SERVER['REQUEST_METHOD'];
$taskId = isset($_GET['id']) ? $_GET['id'] : null;

function createTask($pdo)
{
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    $description = $data->description;
    $status = $data->status;

    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Tarefa criada com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao criar tarefa.']);
    }
}

function getTasks($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM tasks");
    $stmt->execute();

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
}

function getTaskById($pdo, $taskId)
{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $taskId);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        echo json_encode($task); 
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tarefa não encontrada.']);
    }
}

function updateTask($pdo, $taskId)
{
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    $description = $data->description;
    $status = $data->status;

    $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
    $stmt->bindParam(':id', $taskId);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Tarefa atualizada com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar tarefa.']);
    }
}

function deleteTask($pdo, $taskId)
{
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $taskId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Tarefa excluída com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir tarefa.']);
    }
}

if ($requestMethod == 'POST' && !$taskId) {
    createTask($pdo);
} elseif ($requestMethod == 'GET' && $taskId) {
    getTaskById($pdo, $taskId);
} elseif ($requestMethod == 'GET' && !$taskId) {
    getTasks($pdo);
} elseif ($requestMethod == 'PUT' && $taskId) {
    updateTask($pdo, $taskId);
} elseif ($requestMethod == 'DELETE' && $taskId) {
    deleteTask($pdo, $taskId);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método ou URL inválido.']);
}
