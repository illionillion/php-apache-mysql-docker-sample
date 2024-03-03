<?php if (isset($images) && !empty($images)) : ?>
    <?php foreach ($images as $i => $image) : ?>
        <div class="carousel-item h-100 <?= $i == 0 ? "active" : "" ?>">
            <img class="d-block img-thumbnail w-100 h-100" style="object-fit: contain;" src="data:image/jpeg;base64,<?= base64_encode($image['diary_image_data']) ?>" />
        </div>
    <?php endforeach; ?>
<?php endif; ?>