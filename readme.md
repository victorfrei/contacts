# 📇 Contacts API

Uma API simples em PHP para cadastro de contatos, interações, upload de arquivos e envio de e-mails.

---

## ✨ Requisitos

- PHP 8.1 ou superior
- Composer
- MySQL ou MariaDB
- Terminal ou servidor local (como XAMPP, WAMP ou php -S)

---

## 🚀 Como rodar o projeto localmente

## Para iniciar o projeto use:

```
php -S localhost:8000 -t public
```

### 1\. Clonar o projeto

```bash
git clone https://github.com/seu-usuario/contacts.git
cd contacts
```

### 2\. Instalar dependências

```bash
composer install
```

### 3\. Configurar o banco de dados

No arquivo `app/config.php`:

```php
return [
    'db' => [
        'host' => 'localhost',
        'dbname' => 'agenda',
        'user' => 'root',
        'pass' => ''
    ]
];
```

### 4\. Importar a base de dados

> ⚠️ Certifique-se de que o banco `agenda` já existe antes.

Você pode rodar a migração com:

```bash
composer migrate
```

Esse comando executa `app/migrate.php` que cria as tabelas do banco.

---

## 🚪 Iniciar servidor local

```bash
php -S localhost:8000 -t public
```

---

## 🔍 Principais endpoints

| Método | Rota | Descrição |
| --- | --- | --- |
| GET | /contacts | Lista todos os contatos |
| POST | /contact | Cria novo contato |
| PUT | /contact/{id} | Atualiza um contato |
| DELETE | /contact/{id} | Remove um contato |
| POST | /interactions | Cria uma interação com contato |
| POST | /upload | Envia imagem e/ou anexo |
| POST | /send-email | Envia e-mail de teste |

---

## 📂 Uploads

- **Imagem (profile)**: máximo 2MB
- **Arquivo (attachment)**: máximo 5MB
- 1 de cada tipo por contato
- Se reenviar, o arquivo atual é substituído
- Campos devem ser enviados com nome correto:

```json
{
  "profile": file
}
```

ou

```json
{
  "attachment": file
}
```

---

## 🙌 Envio de e-mail

O endpoint `/send-email` recebe:

```json
{
  "to": "email@exemplo.com",
  "subject": "Assunto",
  "message": "Mensagem em texto simples"
}
```

---

## ⏳ Tempo de desenvolvimento

- Tempo total estimado: **3 horas**
- Desenvolvido com foco em clareza, organização e separação de responsabilidades

### ⚠️ Limitações:

- Sem autenticação JWT ou login
- Uploads locais (sem serviço em nuvem)
- Não possui paginação
- Apenas uma API REST, com interface básico usando Nextjs, não consegui fazer somente em HTML e CSS

---

## 🛂 Estrutura do projeto

```
contacts/
├── app/
│   ├── src/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   └── Core/
|   |   └── Services/
│   ├── migrate.php
│   └── config.php
├── public/
│   ├── index.php
├── sql/
│   └── general.sql
├── composer.json
├── index.html
```

---

## 👤 Autor

Desenvolvido por **Victor Freire** [LinkedIn](https://www.linkedin.com/in/victorfreire)