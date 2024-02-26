<?php
include "./lib/connect_db.php";
include "./lib/session_check.php";

session_check();

try {
    // データベースに接続
    $pdo = connect_db();

    // 日記を取得するクエリを準備
    $diaryQuery = $pdo->prepare("SELECT d.diary_id, d.diary_title, d.diary_content, d.user_id, d.created_at, u.user_name FROM diary d JOIN user u ON d.user_id = u.user_id");

    // クエリを実行
    $diaryQuery->execute();

    // 日記の結果セットを取得
    $diaries = $diaryQuery->fetchAll(PDO::FETCH_ASSOC);

    // 各日記に関連する画像を取得するループ
    foreach ($diaries as $diary) {
        // 日記に関連する画像を取得するクエリを準備
        $imageQuery = $pdo->prepare("SELECT diary_image_data FROM diary_image WHERE diary_id = :diary_id");
        $imageQuery->bindParam(':diary_id', $diary['diary_id']);

        // クエリを実行
        $imageQuery->execute();

        // 画像の結果セットを取得
        $images = $imageQuery->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    // エラーハンドリング
    echo "Error: " . $e->getMessage();
} finally {
    // データベース接続を閉じる
    if ($pdo !== null) {
        $pdo = null;
    }
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日記一覧</title>
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/main.js"></script>

</head>

<body>
    <main class="container row m-auto">
        <h1 class="text-center py-3">日記一覧</h1>
        <div class="d-flex gap-3">
            <a href="/" class="link-secondary">日記作成</a>
            <a href="/api/signout.php" class="link-secondary">サインアウト</a>
        </div>
        <div class="row gap-2">
            <?php foreach ($diaries as $diary) : ?>
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h5><?= $diary["diary_title"] ?></h5>
                            <p>作成者：<?= $diary["user_name"] ?></p>
                        </div>
                        <pre class="card-text"><?= $diary["diary_content"] ?></pre>
                        <div id="carouselExample<?= $diary["diary_id"] ?>" class="carousel slide" style="height: 300px;">
                            <div class="carousel-inner h-100">
                                <?php foreach ($images as $i => $image) : ?>
                                    <div class="carousel-item h-100 <?= $i == 0 ? "active" : "" ?>">
                                        <img class="d-block img-thumbnail w-100 h-100" style="object-fit: contain;" src="data:image/jpeg;base64,<?= base64_encode($image['diary_image_data']) ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample<?= $diary["diary_id"] ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-primary rounded" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample<?= $diary["diary_id"] ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-primary rounded" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>