<?php

// 画像をリサイズして圧縮する関数
function resize_and_compress_image($imageData, $maxWidth, $maxHeight, $quality = 75)
{
    // 画像のサイズを取得
    $image = imagecreatefromstring($imageData);
    if (!$image) {
        // 画像の読み込みに失敗した場合のエラーハンドリング
        return false;
    }
    $width = imagesx($image);
    $height = imagesy($image);

    // 元の縦横比を保持しながら新しいサイズを計算
    $ratio = $width / $height;
    if ($ratio > 1) {
        // 横長の場合
        $newWidth = $maxWidth;
        $newHeight = round($maxWidth / $ratio); // 四捨五入して整数に変換
    } else {
        // 縦長または正方形の場合
        $newHeight = $maxHeight;
        $newWidth = round($maxHeight * $ratio); // 四捨五入して整数に変換
    }

    // 新しい画像を作成
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // 画像をリサイズ
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, (int)$newWidth, (int)$newHeight, $width, $height);

    // 画像をバッファに出力してJPEG形式で圧縮
    ob_start();
    imagejpeg($resizedImage, null, $quality); // $quality の値を調整することで圧縮率を変更できます
    $compressedImageData = ob_get_clean();

    // メモリを解放
    imagedestroy($image);
    imagedestroy($resizedImage);

    return $compressedImageData;
}
