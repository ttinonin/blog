<?php require_once(__DIR__ . '/../components/header.php') ?>

<div class="flex justify-between items-center mt-2">
    <h1 class="font-bold text-2xl"><?= $post["title"] ?></h1>

    <p class="text-muted"><?= date("d/m/Y - H:i", strtotime($post["created_at"])) ?></p>
</div>

<hr class="border-t-2 border-gray-200 my-4">

<p><?= $post["body"] ?></p>

<div class="text-gray-500 text-sm italic text-left mt-3">
  Posted by: <span class="font-semibold text-gray-700"><?= $post["username"] ?></span>
</div>

<?php if(App\Services\Policies\PostPolicy::can_create()): ?>
    <form action="/delete-post/<?= $post["id"] ?>" method="POST">
        <button type="submit" class="px-5 py-2 text-white mt-3 bg-red-500 hover:bg-red-700 rounded-md">Delete</button>
    </form>
<?php endif; ?>

<?php require_once(__DIR__ . '/../components/footer.php') ?>