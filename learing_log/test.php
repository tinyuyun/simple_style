<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallpape</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class="title">
<h1>Wallpaper</h1>
</div>
<div class="wrapper">
    <!-- filter Items -->
    <nav>
        <div class="items">
            <span class="item active" data-name="all">全部</span>
            <?php
            // 获取当前目录下的所有文件夹
            $folders = array_filter(glob('*'), 'is_dir');
            foreach ($folders as $folder) {
                echo '<span class="item" data-name="' . $folder . '">' . ucfirst($folder) . '</span>';
            }
            ?>
        </div>
    </nav>
    <!-- filter Images -->
    <div class="gallery">
        <?php
        // 遍历每个文件夹并获取其中的图片
        foreach ($folders as $folder) {
            $images = glob($folder . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE); // 获取该文件夹下的所有图片
            foreach ($images as $image) {
                echo '<div class="image" data-name="' . $folder . '"><span><img src="' . $image . '" alt=""></span></div>';
            }
        }
        ?>
    </div>
</div>
<!-- fullscreen img preview box -->
<div class="preview-box">
    <div class="details">
        <span class="title">Image Category: <p></p></span>
        <span class="icon fas fa-times"></span>
    </div>
    <div class="image-box"><img src="" alt=""></div>
</div>
<div class="shadow"></div>

<script src="script.js"></script>

</body>
</html>