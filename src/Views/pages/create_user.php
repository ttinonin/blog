<?php require_once(__DIR__ . '/../components/header.php') ?>

<form action="/user" method="POST">
    <div class="py-2">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>

    <div class="py-2">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>

    <div class="py-2">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>

    <div class="py-2">
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>
    <button type="submit">Create</button>
</form>

<?php require_once(__DIR__ . '/../components/footer.php') ?>