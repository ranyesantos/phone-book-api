
# 📄 Visão Geral
**Nome**: Phonebook API

**Descrição**: A aplicação se trata de uma API que representa um sistema de agenda de contatos com as funcionalidades padrões incluindo a função de lixeira.

**Obs**: Foi desenvolvido também o front-end da aplicação, que pode ser encontrado [aqui](https://github.com/ranyesantos/phone-book-front-end).


# 📋 Pré-requisitos

1. **PHP** Versão: >= 8.1
2. **Composer**


# ▶️ Como rodar
1. **Clonar o Repositório do GitHub**
   
   Abra o terminal e execute:

    ```sh
    git clone https://github.com/ranyesantos/phone-book-api.git
    ```

    
2. **Selecionar Diretório**

    para selecionar o diretório do projeto, execute:
    ```sh
    cd phone-book-api
    ```

3. **Instalar Dependências**

    No diretório do projeto, execute:
    ```sh
    composer install
    ```
    
4. **Configurar Variáveis de Ambiente**

    Copie o arquivo `.env.example` para `.env` com o comando:
    ```sh
    cp .env.example .env
    ```

    Edite o arquivo .env com suas configurações de banco de dados e outras variáveis de ambiente necessárias. Por exemplo:
    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=phonebook_db
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```


4. **Gerar a Chave da Aplicação**

    Execute o comando para gerar a chave da aplicação:
    ```sh
    php artisan key:generate
    ```

5. **Execute Migrations e Seeders**

    Execute as migrations para criar as tabelas no banco de dados
    ```sh
    php artisan migrate
    ```

    (Opcional) Após executar as migrations, popule o banco de dados com o comando:
    ```sh
    php artisan db:seed
    ```

6. **Iniciar o Servidor de Desenvolvimento**

    Para iniciar o servidor embutido do Laravel, execute o comando:
    ```sh
    php artisan serve
    ```


<br>

# 🗄️ Tabelas do banco de dados

### Contact
| Campo             | Tipo      | Descrição                                    |
|-------------------|-----------|----------------------------------------------|
| `id`              | int       | Identificador único do contato               |
| `name`            | string    | Nome completo do contato                     |
| `phone`           | string    | Número de telefone do contato                |
| `email`           | string    | Endereço de e-mail do contato (opcional)     |
| `profile_picture` | string    | URL ou caminho da foto de perfil (opcional)  |
| `deleted_at`      | timestamp | Data de exclusão do contato (soft delete)    |
| `created_at`      | timestamp | Data e hora de criação do contato            |
| `updated_at`      | timestamp | Data e hora da última atualização do contato |

### User

| Campo                     | Tipo      | Descrição                                                |
|---------------------------|-----------|----------------------------------------------------------|
| `id`                      | int       | Identificador único do usuário                           |
| `name`                    | string    | Nome completo do usuário                                 |
| `email`                   | string    | Endereço de e-mail do usuário (único)                   |
| `email_verified_at`       | timestamp | Data em que o e-mail do usuário foi verificado (opcional) |
| `password`                | string    | Senha do usuário                                         |
| `remember_token`          | string    | Token usado para "lembrar" o usuário em sessões (opcional) |
| `created_at`              | timestamp | Data e hora de criação do usuário                        |
| `updated_at`              | timestamp | Data e hora da última atualização do usuário             |


<br>

# 📍 Endpoints

### Autenticação

| **Rota**                        | **Descrição**                                           |
|---------------------------------|-------------------------------------------------------|
| <kbd>POST /register</kbd>       | Registra um novo usuário - [detalhes da requisição/resposta](#post-auth-register) |
| <kbd>POST /login</kbd>          | Realiza o login de um usuário - [detalhes da requisição/respostas](#post-auth-login) |
| <kbd>POST /logout</kbd>         | Realiza o logout de um usuário - [detalhes da resposta](#post-auth-logout) |

<br>

### Contatos (requer autenticação)
| **Rota**                | **Descrição**                                            
|----------------------|-----------------------------------------------------
| <kbd>GET /contacts   | Retorna a listagem com todos os contatos - [detalhes da resposta](#get-contacts-index)|
| <kbd>GET /contacts/{contact}</kbd>     | Retorna os detalhes de um contato específico - [detalhes da resposta](#get-contacts-show)|
| <kbd>POST /contacts/</kbd>     | Criação de um novo contato - [detalhes da requisição/resposta](#post-contacts-store)|
| <kbd>POST /contacts/{contact}</kbd>     | Edição de um contato existente - [detalhes da requisição/resposta](#post-contacts-update)|
| <kbd>delete /contacts/{contact}</kbd>     | Exclusão de um contato (com Soft-delete) - [detalhes da requisição/resposta](#delete-contacts-destroy)|

<br>

### Lixeira (requer autenticação)

| **Rota**                          | **Descrição**                                             |
|-----------------------------------|---------------------------------------------------------|
| <kbd>GET /trash-bin</kbd>         | Retorna a listagem de todos os contatos na lixeira - [detalhes da resposta](#get-trash-bin-index) |
| <kbd>GET /trash-bin/{contact}</kbd> | Retorna os detalhes de um contato específico na lixeira - [detalhes da resposta](#get-trash-bin-show) |
| <kbd>PUT /trash-bin/{contact}</kbd> | Restaura um contato da lixeira - [detalhes da requisição/resposta](#put-trash-bin-restore) |
| <kbd>DELETE /trash-bin/{contact}</kbd> | Deleta o contato permanentemente - [detalhes da requisição/resposta](#delete-trash-bin-destroy) |


<br>


# 🔄 Respostas e/ou Requisições


<h3 id="post-auth-register">POST /register - Realizar o cadastro</h3>

**REQUISIÇÃO**
```json
{
    "name": "Lucas Martins Pereira",
    "email": "lucas745@example.com",
    "password": "2024#Sec0030"
}
```
**RESPOSTA**
```json
{
    "status": true,
    "message": "usuário cadastrado com sucesso"
}
```

<br>

---

<br>

<h3 id="post-auth-login">POST /login - Realizar o login</h3>

**REQUISIÇÃO**
```json
{
    "email": "lucas745@example.com",
    "password": "2024#Sec0030"
}
```
<br>

**Resposta de Sucesso (201)**

**Status code**: `201 Created`

```json
{
    "status": true,
    "token": "10|7rhzfr9SXMf0SMX3JgxaMJZXJvhB5kM5YTW66O156821604e",
    "user": {
        "id": 7,
        "name": "Lucas Martins Pereira",
        "email": "lucas745@example.com",
        "email_verified_at": null,
        "created_at": "2024-10-23T18:40:49.000000Z",
        "updated_at": "2024-10-23T18:40:49.000000Z"
    }
}
```

<br>

**Resposta de Falha de Autenticação (401)**


**Status code**: `401 Unauthorized`

```json
{
    "status": false,
    "message": "credenciais incorretas"
}
```



<br>

---

<br>

<h3 id="post-auth-logout">POST /logout - Realizar o logout</h3>


**RESPOSTA**

```json
{
    "status": true,
    "message": "o usuário foi deslogado"
}
```

<br>

---

<br>

<h3 id="get-contacts-index">GET /contacts - Listar todos os contatos</h3>

**RESPOSTA**
```json
{
    "status": true,
    "contacts": [
        {
            "id": 160,
            "name": "Alice Queirós Rico Filho",
            "phone": "83983396829",
            "email": "rezende.nayara@example.org",
            "profile_picture": null,
            "deleted_at": null,
            "created_at": "2024-10-10T13:00:05.000000Z",
            "updated_at": "2024-10-10T13:00:05.000000Z"
        },
        {
            "id": 164,
            "name": "Allison Maria Carmona",
            "phone": "61956777989",
            "email": "valeria55@example.com",
            "profile_picture": "profile_pictures/G3hJNrR1eY5EPhQsfRUvj8A2FccUxZneW31Ah5gu.jpg",
            "deleted_at": null,
            "created_at": "2024-10-10T13:00:05.000000Z",
            "updated_at": "2024-10-10T13:00:05.000000Z"
        },
        ...
    ]
}
```

<br>

---

<br>

<h3 id="get-contacts-show">GET /contacts/{contact} - Exibir detalhes de um contato</h3>

**RESPOSTA**
```json
{
    "status": true,
    "contact": {
        "id": 160,
        "name": "Alice Queirós Rico Filho",
        "phone": "83983396829",
        "email": "rezende.nayara@example.org",
        "profile_picture": null,
        "deleted_at": null,
        "created_at": "2024-10-10T13:00:05.000000Z",
        "updated_at": "2024-10-10T13:00:05.000000Z"
    }
}
```

<br>

---

<br>

<h3 id="post-contacts-store">POST /contacts - Adicionar um novo contato</h3>

**REQUISIÇÃO**
```json
{
    "name": "João Igor Campos",
    "phone": "82945356800",
    "email": "tburgos@example.net"
}
```
**RESPOSTA**
```json
{
    "contact": {
        "name": "João Igor Campos",
        "phone": "82945356800",
        "email": "tburgos@example.net",
        "profile_picture": null,
        "updated_at": "2024-10-23T17:55:55.000000Z",
        "created_at": "2024-10-23T17:55:55.000000Z",
        "id": 167
    },
    "message": "Contato adicionado com sucesso"
}
```

<br>

---

<br>

<h3 id="post-contacts-update">POST /contacts/{contact} - Editar os dados de um contato</h3>

**REQUISIÇÃO**
```json
{
    "name": "Alice Q. Rico Filho",
    "phone": "83983396829",
    "email": "rezende.nayara@example.org"
}
```
**RESPOSTA**
```json
{
    "message": "Contato atualizado com sucesso",
    "contact": {
        "id": 160,
        "name": "Alice Q. Rico Filho",
        "phone": "83983396829",
        "email": "rezende.nayara@example.org",
        "profile_picture": null,
        "deleted_at": null,
        "created_at": "2024-10-10T13:00:05.000000Z",
        "updated_at": "2024-10-23T18:15:40.000000Z"
    }
}
```
<br>

---

<br>

<h3 id="delete-contacts-destroy">DELETE /contacts/{contact} - Deletar um contato (Soft-delete)</h3>

**RESPOSTA**
```json
{
    "status": true,
    "message": "Contato apagado com sucesso"
}
```

<br>

---

<br>

<h3 id="get-trash-bin-index">GET /trash-bin - Listar todos os contatos na lixeira</h3>

**RESPOSTA**
```json
{
    "status": true,
    "contacts": [
        {
            "id": 115,
            "name": "Alana Brito Duarte Neto",
            "phone": "21960326836",
            "email": "mia80@example.com",
            "profile_picture": null,
            "deleted_at": "2024-10-10T13:10:18.000000Z",
            "created_at": "2024-10-10T13:00:05.000000Z",
            "updated_at": "2024-10-10T13:10:18.000000Z"
        },
        {
            "id": 160,
            "name": "Alice Q. Rico Filho",
            "phone": "83983396829",
            "email": "rezende.nayara@example.org",
            "profile_picture": null,
            "deleted_at": "2024-10-23T18:23:01.000000Z",
            "created_at": "2024-10-10T13:00:05.000000Z",
            "updated_at": "2024-10-23T18:23:01.000000Z"
        },
        ...
    ]
}
```

<br>

---

<br>

<h3 id="get-trash-bin-show">GET /trash-bin/{contact} - Ver detalhes do contato na lixeira</h3>

**RESPOSTA**
```json
{
    "status": true,
    "contact": {
        "id": 160,
        "name": "Alice Q. Rico Filho",
        "phone": "83983396829",
        "email": "rezende.nayara@example.org",
        "profile_picture": null,
        "deleted_at": "2024-10-23T19:29:08.000000Z",
        "created_at": "2024-10-10T13:00:05.000000Z",
        "updated_at": "2024-10-23T19:29:08.000000Z"
    }
}
```

<br>

---

<br>


<h3 id="put-trash-bin-restore">PUT /trash-bin/{contact} - Restaurar contato</h3>

<br>

**Resposta de Sucesso (200)**

**Status code**: `200 OK`

```json
{
    "status": true,
    "message": "Contato restaurado com sucesso",
    "contact": {
        "id": 115,
        "name": "Alana Brito Duarte Neto",
        "phone": "21960326836",
        "email": "mia80@example.com",
        "profile_picture": null,
        "deleted_at": null,
        "created_at": "2024-10-10T13:00:05.000000Z",
        "updated_at": "2024-10-23T19:20:19.000000Z"
    }
}
```

<br>

**Resposta de contato não encontrado (404)**

**Status code**: `404 Not Found`

```json
{
    "message": "Contato não encontrado"
}
```

<br>

---

<br>

<h3 id="delete-trash-bin-destroy">DELETE /trash-bin/delete - Deletar contato permanentemente</h3>

**RESPOSTA**
```json
{
    "status": true,
    "message": "O contato foi apagado permanentemente"
}
```



