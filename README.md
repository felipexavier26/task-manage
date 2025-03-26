# Task Manager

O **Task Manager** é uma aplicação web para gerenciar tarefas, onde o usuário pode realizar operações como criar, editar, listar e excluir tarefas. A aplicação utiliza uma API RESTful construída com **PHP puro** para gerenciar as tarefas e o login dos usuários. O frontend consome essa API utilizando **JavaScript**, com **AJAX** para comunicação assíncrona, e exibe as informações com uma interface **responsiva**, construída com **Bootstrap** e interações aprimoradas com **SweetAlert2** e **paginações**.

## Link do Projeto

- **Link para o repositório**: [Task Manager no GitHub](https://github.com/seu-usuario/task-manager)

## Tecnologias Utilizadas

- **PHP Puro**: Backend da aplicação para a criação das APIs.
- **MySQL**: Banco de dados para persistência de dados.
- **JavaScript (AJAX)**: Para consumir as APIs de forma assíncrona no frontend.
- **Bootstrap**: Framework CSS para criar uma interface responsiva.
- **SweetAlert2**: Biblioteca para exibição de modais personalizados, como alertas e confirmações.
- **Pagination**: Para gerenciar a listagem de tarefas, exibindo-as por página.

## Funcionalidades

### Backend (API)

#### API de Login
A API de login permite autenticar usuários no sistema.

- **POST /login**: Realiza o login do usuário, retornando um token de autenticação (JWT) para ser usado nas futuras requisições.
  
#### API de Tarefas
A API de tarefas é responsável por manipular as tarefas de maneira CRUD (Criar, Ler, Atualizar e Excluir).

- **POST /tasks**: Cria uma nova tarefa com os campos `title`, `description` e `status`.
- **GET /tasks**: Retorna uma lista de tarefas com paginação. Exibe as tarefas existentes.
- **PUT /tasks/:id**: Atualiza uma tarefa existente com os campos `title`, `description` e `status`.
- **DELETE /tasks/:id**: Exclui uma tarefa pelo seu ID.
- **GET /tasks/:id**: Exibe os detalhes de uma tarefa específica.

#### Estrutura de Dados de Tarefa
Cada tarefa contém os seguintes campos:

- **id**: Identificador único da tarefa.
- **title**: Título da tarefa.
- **description**: Descrição detalhada da tarefa.
- **status**: Status da tarefa, como "pendente", "em andamento" ou "concluída".
- **created_at**: Data de criação da tarefa.
- **updated_at**: Data de atualização da tarefa.

### Frontend

- **Listagem de Tarefas**: Exibe uma lista de tarefas em formato de tabela, com a possibilidade de navegar pelas páginas de tarefas.
- **Formulário de Criação/Atualização**: Permite ao usuário adicionar novas tarefas ou editar tarefas existentes.
- **Modais e Interações**: Usa **SweetAlert2** para mostrar notificações e modais, como alertas de sucesso ou erro nas operações de CRUD.
- **Exclusão de Tarefas**: Permite ao usuário excluir tarefas da lista.
- **Alteração de Status**: O usuário pode marcar as tarefas como "concluídas" ou "reabrir" as tarefas.
- **Paginação**: As tarefas são listadas com paginação, permitindo a navegação entre várias páginas de resultados.

### Interface

A interface foi construída com **Bootstrap** para ser responsiva, permitindo a utilização da aplicação em dispositivos móveis e desktops. As interações de CRUD e status das tarefas são feitas de maneira interativa com o uso de **AJAX**, sem a necessidade de recarregar a página.

## Passos para Execução

### Passo 1: Clonar o Repositório

Clone o repositório para sua máquina local:

    ```bash
git clone https://github.com/seu-usuario/task-manager.git
cd task-manager


## Exemplo de Retorno da API

Ao acessar a API na rota principal:


A resposta retornada será um JSON contendo as tarefas cadastradas no sistema:

```json
[
    {
        "id": 1,
        "title": "Criar briefing para novo projeto",
        "description": "Elaborar um briefing detalhado para o projeto do cliente X.",
        "status": "Em Andamento",
        "created_at": "2025-03-26 01:11:15",
        "updated_at": "2025-03-26 14:35:39"
    }
]
