<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>
<body>

<header class="bg-violet-900 text-white">
    <div class="container mx-auto flex items-center justify-between">
        <h1 class="text-lg font-bold m-3">Daniel's Blog</h1>

        <ul>
            <a href="/php/blog/" class="inline-block px-3 m-3"><li>Home</li></a>
            <a href="/php/blog/posts" class="inline-block px-3 m-3"><li>Posts</li></a>
            <a href="/php/blog/user" class="inline-block px-3 m-3"><li>Profile</li></a>
            
            <a href="/php/blog/create-user" class="inline-block px-3 m-3 bg-green-500 hover:bg-green-700 rounded-md border-2 border-green-700"><li>Sign Up</li></a>
            <a href="/php/blog/create-user" class="inline-block px-3 m-3 bg-blue-500 hover:bg-blue-700 rounded-md border-2 border-blue-700"><li>Sign In</li></a>
        </ul>
    </div>
</header>

<div class="container mx-auto p-3">
    <?php if(isset($error)): ?>
    
    <div class="bg-red-400 border-2 rounded-lg border-red-600 my-2 p-3">
        <p class="text-red-900">Error: <?= $error ?></p>
    </div>
    
    <?php endif; ?>