<?php
include "../../lib/connect_db.php";
include "../../lib/session_check.php";
include "../../lib/resize_and_compress_image.php";

session_check();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GETリクエストの場合の処理（直接アクセスされた場合）

    // 別のページにリダイレクト
    header("Location: /");
    exit;
}

// NULLチェック
if (!isset($_POST["dairy-title"]) || empty($_POST["dairy-title"])) {
    header("Location: /?error=1");
    die("Error: dairy-title is null or empty");
}
if (!isset($_POST["dairy-content"]) || empty($_POST["dairy-content"])) {
    header("Location: /?error=2");
    die("Error: dairy-content is null or empty");
}
if (!isset($_FILES["dairy-image"]) || empty($_FILES["dairy-image"])) {
    header("Location: /?error=3");
    die("Error: dairy-image is null or empty");
}

$dairyTitle = $_POST["dairy-title"];
$dairyContent = $_POST["dairy-content"];
$userId = $_SESSION["user_id"];
$dairyImages = $_FILES["dairy-image"];

try {
    $pdo = connect_db();

    // 日記を挿入
    $stmt = $pdo->prepare("INSERT INTO diary (diary_title, diary_content, user_id) VALUES (:title, :content, :user_id)");
    $stmt->bindParam(':title', $dairyTitle, PDO::PARAM_STR);
    $stmt->bindParam(':content', $dairyContent, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $stmt->execute();

    // 直前に挿入された日記のIDを取得
    $diaryId = $pdo->lastInsertId();

    if (is_array($dairyImages["tmp_name"])) {
        // 画像を1つずつ処理
        foreach ($dairyImages["tmp_name"] as $index => $tmpName) {
            $imageData = file_get_contents($tmpName);
            $resizedImage = resize_and_compress_image($imageData, 800, 600); 
            // 画像を挿入
            $stmt = $pdo->prepare("INSERT INTO diary_image (diary_id, diary_image_data) VALUES (:diary_id, :image_data)");
            $stmt->bindParam(':diary_id', $diaryId, PDO::PARAM_INT);
            $stmt->bindParam(':image_data', $resizedImage, PDO::PARAM_LOB);
            $stmt->execute();
        }
    } else {
        $tmpName = $dairyImages["tmp_name"];
        $imageData = file_get_contents($tmpName);
        $resizedImage = resize_and_compress_image($imageData, 800, 600); 
        // 画像を挿入
        $stmt = $pdo->prepare("INSERT INTO diary_image (diary_id, diary_image_data) VALUES (:diary_id, :image_data)");
        $stmt->bindParam(':diary_id', $diaryId, PDO::PARAM_INT);
        $stmt->bindParam(':image_data', $resizedImage, PDO::PARAM_LOB);
        $stmt->execute();
    }

    // 成功した場合、リダイレクト
    header("Location: /?success");

    exit;
} catch (PDOException $e) {
    // エラーが発生した場合の処理
    // echo $e->getMessage();
    // エラーページにリダイレクトやエラーメッセージの表示など
    header("Location: /?error=4");
    exit;
} finally {
    // finally ブロックで接続をクローズ
    if ($pdo !== null) {
        $pdo = null;
    }
}
