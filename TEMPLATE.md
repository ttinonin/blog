# Classic Template

Classic is a template language inspired by HTML syntax that compiles into PHP code, designed specifically for this project.

## Example

```classic
<component src="header.php">

    <foreach array="$posts" value="$post">
        <$post['body']>
    </foreach>

<component src="footer.php">
```

Compiles to:

```php
<?php require_once __DIR__ . "/../components/header.php"; ?> 
    
    <?php foreach ( $posts as $post ): ?> 
        <?= htmlspecialchars( $post['body'] ) ?> 
    <?php endforeach; ?> 

<?php require_once __DIR__ . "/../components/footer.php"; ?>
```

## Usage

Inside the `src/Views/pages/pre_compiled directory`, create a `.classic.php` file and use the CLI to compile it into PHP with the following command:

```bash
php utils compile <file_name>.classic.php
```

It will create a compiled file inside the `src/Views/pages/` directory.

## Limitations

Alpha Status: The compiler is still in its early stages of development, and as such:

- It may produce unexpected results in certain edge cases.

- Some features might not work as intended.

- Error handling is minimal.

- Basic Functionality: Advanced templating features such as custom directives or complex expressions are not yet supported.

## Known Issues

- Lack of detailed error messages for invalid syntax.

- Performance has not been fully optimized for large templates.