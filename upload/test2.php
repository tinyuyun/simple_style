<?php

// 递归遍历文件夹，获取所有md文件及其子目录的级别
function getFilesWithLevels($dir, $rootDir) {
    $filesWithLevels = [];
    $dirIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($dirIterator as $file) {
        if ($file->getExtension() == 'md') {
            // 计算相对路径层级
            $relativePath = str_replace($rootDir . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            $level = substr_count($relativePath, DIRECTORY_SEPARATOR);
            $filesWithLevels[$file->getRealPath()] = $level;
        }
    }
    return $filesWithLevels;
}

// 替换图片路径
function replaceImagePaths($filePath, $rootDir, $levels, $domain) {
    $content = file_get_contents($filePath);

    // 匹配 ![[Pasted image 文件名.png]]
    preg_match_all('/!\[\[Pasted image (.*?)\]\]/', $content, $matches);

    foreach ($matches[1] as $imageName) {
        // 根据文件路径查表获取级别
        $level = $levels[$filePath];
        // 构造相对路径
        $relativePath = str_repeat('..\\', $level) . '图片\\' . $imageName;

        // 将相对路径转换为URL格式，并对URL进行编码
        $encodedImageName = urlencode($imageName); // 对图片名进行URL编码
        $imageUrl =  urlencode('md_online/图片/') . 'Pasted%20image%20' . urlencode($encodedImageName);
        $imageUrl = $domain .'/'. $imageUrl;
        $newImagePath = '!' . '[](' . $imageUrl . ')';
        $content = str_replace("![[Pasted image $imageName]]", $newImagePath, $content);
    }

    // 更新文件内容
    file_put_contents($filePath, $content);
}

$rootDir = realpath('../md_online');
// 获取当前域名，若获取失败则使用 localhost
$domain = isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : 'http://localhost';

$filesWithLevels = getFilesWithLevels($rootDir, $rootDir);

foreach ($filesWithLevels as $file => $level) {
    replaceImagePaths($file, $rootDir, $filesWithLevels, $domain);
}
echo "finish";
?>
