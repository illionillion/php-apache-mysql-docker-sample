<?php
include "../lib/connect_db.php";
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GETリクエストの場合の処理（直接アクセスされた場合）

    // 別のページにリダイレクト
    header("Location: /");
    exit;
}

// NULLチェック
if (!isset($_POST["user-name"]) || empty($_POST["user-name"])) {
    header("Location: /signin.php?error=1");
    die("Error: user-name is null or empty");
}
if (!isset($_POST["user-password"]) || empty($_POST["user-password"])) {
    header("Location: /signin.php?error=2");
    die("Error: user-password is null or empty");
}

$userName = $_POST["user-name"];
$userPassowrd = $_POST["user-password"];

try {
    $pdo = connect_db();

    // 日記を挿入
    $stmt = $pdo->prepare("SELECT user_id, user_name, password, email FROM user WHERE user_name = :user_name");
    $stmt->bindParam(':user_name', $userName, PDO::PARAM_STR);
    $stmt->execute();
    $existUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($existUser) == 0) {
        header("Location: /signin.php?error=3");
        die("Error: " . $userName . "was not found.");
    }

    $hashedPassword = hash('sha256', $userPassowrd);

    if ($existUser[0]["password"] == $hashedPassword) {
        $_SESSION['user_id'] = $existUser[0]["user_id"];
        header("Location: /");
    } else {
        header("Location: /signin.php?error=4");
    }
} catch (PDOException $e) {
    header("Location: /signin.php?error=5");
    echo $e->getMessage();
    exit;
} finally {
    // データベース接続を閉じる
    if ($pdo !== null) {
        $pdo = null;
    }
}
