<?php
// 获取"works" folder目录
$directory = './works/';
$folders = array_filter(glob($directory . '*'), 'is_dir');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>web_learn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./web_learn.css">
</head>
<body>
<div class="select-menu">
    <div class="select">
        <span>Select groups</span>
        <i class="fa fa-angle-down"></i>
    </div>
    <div class="options-list">
        <?php foreach ($folders as $folder): ?>
            <?php
            $folderName = basename($folder); // Get the folder name  
            ?>
            <div class="option">
                <a href="<?= $folder ?>/index.html"><?= htmlspecialchars($folderName) ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="./web_learn.js"></script>
</body>
</html>