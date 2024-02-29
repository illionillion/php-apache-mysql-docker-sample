<?php

class Carousel
{
    private $images;

    public function __construct($diaryId)
    {
        try {
            // 各日記に関連する画像を取得するループ
            $pdo = connect_db();
            $imageQuery = $pdo->prepare("SELECT diary_image_data FROM diary_image WHERE diary_id = :diary_id");
            $imageQuery->bindParam(':diary_id', $diaryId);

            // クエリを実行
            $imageQuery->execute();

            // 画像の結果セットを取得
            $this->images = $imageQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function render()
    {
        if (isset($this->images) && !empty($this->images)) {
            $images = $this->images;
            include 'element.php';
        }
    }
}
