<?php require_once(__DIR__ . '/../components/header.php') ?>

<form action="/php/blog/user" method="POST">
    <input type="text" name="username">
    <input type="email" name="email">
    <input type="password" name="password">
    <button type="submit">Create</button>
</form>

<?php require_once(__DIR__ . '/../components/footer.php') ?>