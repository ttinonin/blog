<?php require_once(__DIR__ . '/../components/header.php') ?>

<div class="flex items-center justify-between">
    <h1 class="text-lg">Posts</h1>
    <?php if(App\Services\Policies\PostPolicy::can_create()): ?>
        <a href="/php/blog/create-post">
            <button class="bg-green-500 hover:bg-green-600 w-full font-semibold text-white px-3 py-1 rounded-md">+ Create</button>
        </a>
    <?php endif; ?>
</div>

<?php foreach($posts as $post): ?>
    <a href="/php/blog/post/<?= $post["id"]?>">
        <div class="rounded-xl border bg-gray-100 p-3 cursor-pointer mt-2">
            <h2 class="text-lg font-bold"><?= $post["title"] ?></h2>
            <p><?= $post["body"] ?></p>
        </div>
    </a>
<?php endforeach; ?>

<?php require_once(__DIR__ . '/../components/footer.php') ?>