<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サインイン</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/main.js"></script>
</head>

<body>
    <main class="container row m-auto">
        <h1 class="text-center py-3">サインイン</h1>
        <a href="/register.php" class="link-secondary">サインアップ</a>
        <form action="/api/signin.php" method="post" class="row gap-3">
            <div class="w-100 form-label">
                <label for="user-name" class="w-100 mb-1">ユーザー名</label>
                <input type="text" name="user-name" id="user-name" class="form-control w-100" required placeholder="ユーザー名を入力">
            </div>
            <div class="w-100 form-label">
                <label for="user-password" class="w-100 mb-1">パスワード</label>
                <input type="password" name="user-password" id="user-password" class="form-control w-100" required placeholder="パスワードを入力">
            </div>
            <div class="w-100 text-center">
                <input type="submit" class="btn btn-outline-primary" value="サインイン">
            </div>
        </form>
    </main>
</body>

</html>