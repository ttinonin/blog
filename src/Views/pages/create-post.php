<?php require_once(__DIR__ . '/../components/header.php') ?>

<form action="/php/blog/post" method="POST">
    <div class="py-2">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="border bg-gray-100 rounded-md p-2 w-full">
    </div>

    <div class="py-2">
        <label for="post">Body:</label>
        <textarea id="post" rows="6" name="body" class="border bg-gray-100 rounded-md p-2 w-full"></textarea>
    </div>

    <button type="submit" class="py-2 px-5 bg-green-500 text-white font-medium text-sm rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2">Post</button>
</form>

<?php require_once(__DIR__ . '/../components/footer.php') ?>