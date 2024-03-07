<?php
include "./lib/session_check.php";
session_check();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日記作成アプリ</title>
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/main.js"></script>
</head>

<body>
    <main class="container row m-auto">
        <h1 class="text-center py-3">日記作成アプリ</h1>
        <h5>ユーザー名：<?= htmlspecialchars($_SESSION["user_name"]) ?></h5>
        <div class="d-flex gap-3">
            <a href="/diary-list" class="link-secondary">日記一覧</a>
            <a href="/api/signout" class="link-secondary">サインアウト</a>
        </div>
        <form action="/api/create-diary/index.php" method="post" enctype="multipart/form-data" class="row gap-3">
            <div class="w-100 form-label">
                <label for="dairy-title" class="w-100 mb-1">タイトル</label>
                <input type="text" name="dairy-title" id="dairy-title" class="form-control w-100" required
                    placeholder="タイトルを入力">
            </div>
            <div class="w-100 form-label">
                <label for="dairy-image" class="w-100 mb-1">画像</label>
                <input type="file" name="dairy-image[]" accept="image/png, image/jpeg" id="dairy-image" class="form-control w-100"
                    multiple required placeholder="画像を選択">
            </div>
            <div class="w-100 form-label">
                <label for="dairy-content" class="w-100 mb-1">内容</label>
                <textarea type="text" name="dairy-content" id="dairy-content" class="form-control w-100" required
                    placeholder="内容を入力"></textarea>
            </div>
            <div class="w-100 text-center">
                <input type="submit" class="btn btn-outline-primary" value="作成">
            </div>
        </form>
    </main>
</body>

</html>