# PHP Blog Application

This is a blog application built with pure PHP, implementing the MVC (Model-View-Controller) architecture. A lightweight custom framework was developed specifically for this project, providing the essential features required to build and extend a modern PHP application.

## Features

- Create, read, update, delete blog posts
- Dynamic routing system for clean and user-friendly URLs.
- Basic form validation and error handling.
- Fully responsive design using Tailwind CSS (optional).

## Framework Features

The project includes a custom lightweight PHP framework with the following features:

- Routing System: Handles dynamic routes and maps them to controllers, with middleware support.
- Template Rendering: Renders views with basic templating logic.
- Database Facades: Simplifies database queries.
- Policies: Ensure that users can only perform actions they are permitted to.
- CLI: Custom CLI, for creating Middlewares, Controllers, Models and run Migrations operations.
- Template Compiler: Converts custom template syntax inspired by HTML into PHP code. This allows developers to write expressive templates using a familiar syntax, like `<if>` and `<foreach>`, which are seamlessly compiled into efficient PHP code. See the [TEMPLATE](./TEMPLATE.md) file for details.

### Documentation

To read the framework documentation, install phpDocumentor and run the following command in your terminal:

```bash
php phpDocumentor.phar -d src -t framework-docs
```

### CLI

To use the CLI run on your terminal:

```bash
php utils --help
```

## Instalation

1. Clone the repository:

```bash
git clone https://github.com/ttinonin/blog.git
cd blog/
```

2. Install dependencies:

```bash
composer install
npm install
```

3. Set up the database:

- Create a `.env` file in the project root directory based on [.env.example](./.env.example)

- Run the migrations:

```bash
php utils migrate:run
```

4. Start the server:

```bash
php utils start
```

## Contributing

Contributions are welcome! Please fork the repository, create a new branch for your feature, and submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE.md) file for details.