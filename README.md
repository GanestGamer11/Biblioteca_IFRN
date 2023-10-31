# Biblioteca_IFRN

## Sobre 
Esse é um projeto de desenvolvimento de uma API para biblioteca do IFRN. Esse projeto foi desenvolvido com o objetivo de treinar e avaliar os conhecimentos adquiridos na disciplina de progamação orientada a serviços do curso informática para internet.

## Requisitos 
- Composer
- PHP 7.4^
- mysql

## instalação
Clone o repositório

    git clone https://github.com/GanestGamer11/Biblioteca_IFRN.git

Entre na pasta e instale as requisições

    composer install

Após instaladas, basta rodar a API com o comando Laravel:
    
    php artisan serve

Dessa forma, o sistema estará rodando na seguinte URI:

    localhost:8000

Você pode especificar uma porta personalizada com o comando (remova os cochetes):

    php artisan serve --port=[portaEscolhida]

## Funções disponíveis na API

A API possuí um documento openapi.yml disponível para visualização no caminho public/api com uma descrição da utilização das rotas, porém, segue adiante uma lista das funções disponíveis e sua utilização.

### Listar Livros

**URL:** `GET api/livros`

**Descrição:** Obtém a lista de todos os livros cadastrados.

### Cadastrar Livro

**URL:** `POST api/livros`

**Parâmetros:**

    titulo: string
    autor: string
    descricao: string
    editora: string
    genero: string

**Descrição:** Cadastra um novo livro com base nos dados fornecidos.

### Exibir Livro

**URL:** `GET api/livros/{id}`

**Descrição:** Exibe as informações de um livro específico com base no ID fornecido.

### Editar Livro

**URL:** `PUT api/livros/{id}`

**Descrição:** Atualiza as informações de um livro específico com base no ID fornecido.

**Parâmetros:**

    titulo: string
    autor: string
    descricao: string
    editora: string
    genero: string


### Remover Livro

**URL:** `DELETE api/livros/{id}`

**Descrição:** Remove um livro específico com base no ID fornecido.

    
