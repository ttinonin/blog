<?php require_once(__DIR__ . '/../components/header.php') ?>

<?php foreach($users as $user): ?>
    <p>
        <?= $user["username"] ?>
    </p>
<?php endforeach; ?>

<?php require_once(__DIR__ . '/../components/footer.php') ?>