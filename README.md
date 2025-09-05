# Biblioteca - Sistema de Gerenciamento de Livros 

Sistema completo de gerenciamento de livros, autores e assuntos, com CRUD, relatórios em Excel, autenticação JWT, testes automatizados (TDD). e execução em ambiente **Docker**

---

## Tecnologias utilizadas
- Laravel 9
- Vue.js 3
- Docker + Docker-compose
- JWT
- MySQL
- Vite
- Pinia
- Axios
- Nginx
- Quasar
- PHPUnit
- Maatwebsite Excel (Export para Excel)


## Funcionalidades

- Login, registro e logout com JWT
- CRUD completo de livros e paginação
- Filtros por titulo, autor e assunto
- Inserção, Edição, Visualização, Exclusão
- Exportação de tarefas para Excel
- Ambiente completo com docker-compose
- Containers para app, banco de dados e nginx

## Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas:

- [Docker instalado]
- [Docker Compose instalado]

---


## Instalação

1. **Clone o repositório**

```bash
git clone https://github.com/lucaasbritto/biblioteca.git
cd biblioteca
```

2. **Copie o arquivo de ambiente para produção**
```bash
  cp backend/.env.example backend/.env
```

3. **Configure o nome do banco em .env**
```env
DB_DATABASE=laravel
```

4. **Suba os containers com Docker**
```shell
  docker-compose up --build -d
```

5. **Entre no container**
```shell
  docker exec -it laravel_app_biblioteca bash
```

6. **Gere a chave da aplicação**
```shell
  php artisan key:generate
```

7. **Gere a chave JWT**
```shell
  php artisan jwt:secret
```

8. **Rode as migrações e os seeders**
```shell
  php artisan migrate --seed
```


9. **Os Seeders criam**
  - 1 usuario
  - 4 livros
  - 4 autores
  - 4 assuntos


## Acessos
  - Front-end: http://localhost:5173
  - Back-end (API): http://localhost:8080/api


## Usuários para acesso do sistema (Criado Via Seeder)
| Tipo    | Email                            | Senha                      |
|---------|----------------------------------|----------------------------|
| Usuario | user@teste.com                   | 123456                     |


## Rodando os Testes
- Foram criados **testes unitários**.
- Os testes usam o arquivo .env.testing
- Por segurança, o arquivo `.env.testing` **não está incluído no versionamento do Git** (ignorado via `.gitignore`).
- Cada desenvolvedor deve criá-lo localmente na pasta raiz 'biblioteca' com o comando:

1. **Criando o .env.testing**
```bash
cp backend/.env.example backend/.env.testing
```

2. **Configure o nome do banco em .env.testing**
```env
DB_DATABASE=laravel_testing
```

3. **Acesse o container**
```bash
  docker exec -it laravel_app_biblioteca bash
```

4. **Gere a chave da aplicação para testes**
```bash
  php artisan key:generate --env=testing
```

5. **Gere a chave JWT para testes**
```bash
  php artisan jwt:secret --env=testing
```

6. **Execute o teste**
```bash
  php artisan test
```



## Variáveis obrigatórias no .env

```env
APP_NAME=Laravel
APP_KEY=           # Gerado via php artisan key:generate
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
QUEUE_CONNECTION=database
JWT_SECRET=        # Gerado via php artisan jwt:secret
```
- (Essas informações do banco estão pre configuradas no Docker)

## Endpoints principais

| Método | Rota                         | Ação                                          |
|--------|------------------------------|-----------------------------------------------|
| POST   | /api/login                   | Login e geração de token JWT                  |
| GET    | /api/me                      | Retorna o usuário autenticado                 |
| GET    | /api/report/books            | Gera e baixa relatório de livros (Excel)      |
| GET    | /api/books/                  | Lista todos os livros                         |
| POST   | /api/books                   | Cria um novo livro                            |
| PUT    | /api/books/{id}              | Atualiza um livro existente                   |
| DELETE | /api/books/{id}              | Deleta um livro (soft delete)                 |
| GET    | /api/authors                 | Lista todos os autores                        |
| POST   | /api/authors                 | Cria um novo autor                            |
| PUT    | /api/authors/{id}            | Atualiza um autor existente                   |
| DELETE | /api/authors/{id}            | Deleta um autor                               |
| GET    | /api/subjects                | Lista todos os assuntos                       |
| POST   | /api/subjects                | Cria um novo assunto                          |
| PUT    | /api/subjects/{id}           | Atualiza um assunto existente                 |
| DELETE | /api/subjects/{id}           | Deleta um assunto                             |
| GET    | /api/filters/autores         | Retorna lista de autores para filtros         |
| GET    | /api/filters/assuntos        | Retorna lista de assuntos para filtros        |

##  Comandos úteis

- Parar containers: `docker-compose down`
- Subir containers: `docker-compose up --build -d`
- Acessar o container: `docker exec -it laravel_app_biblioteca bash`
- Rodar seeders novamente: `php artisan migrate:fresh --seed`