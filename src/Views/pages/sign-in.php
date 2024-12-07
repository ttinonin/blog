<?php require_once(__DIR__ . '/../components/header.php') ?>

<form action="/sign-in" method="POST">

    <div class="py-2">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>

    <div class="py-2">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>

    <button type="submit" class="inline-block px-5 text-white py-2 bg-blue-500 hover:bg-blue-700 rounded-md border-blue-700">Sign In</button>
</form>

<?php require_once(__DIR__ . '/../components/footer.php') ?>