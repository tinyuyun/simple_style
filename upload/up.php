<?php  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    if (isset($_FILES['file'])) {  
        $file = $_FILES['file'];  

        // 设置上传目录  
        $uploadDir = '../md_online/';  
        // 确保上传目录存在  
        if (!is_dir($uploadDir)) {  
            mkdir($uploadDir, 0777, true);  
        }  

        // 清理函数，删除所有文件和目录，排除 index.html  
        function cleanupUploadDir($dir) {  
            $files = array_diff(scandir($dir), ['.', '..', 'index.html']); // 获取除了 . 和 .. 及 index.html 的所有文件  
            foreach ($files as $file) {  
                $filePath = $dir . $file;  
                if (is_dir($filePath)) {  
                    // 递归删除目录  
                    cleanupUploadDir($filePath . '/');  
                    rmdir($filePath);  
                } else {  
                    // 删除文件  
                    unlink($filePath);  
                }  
            }  
        }  

        // 清理上传目录  
        cleanupUploadDir($uploadDir);  

        $uploadFilePath = $uploadDir . basename($file['name']);  
        
        // 移动上传的文件到指定目录  
        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {  
            echo "文件上传成功: " . htmlspecialchars($file['name']);  
            
            // 检查上传的文件是否为 ZIP 文件  
            if (pathinfo($uploadFilePath, PATHINFO_EXTENSION) === 'zip') {  
                $zip = new ZipArchive();  
                
                // 尝试打开 ZIP 文件  
                if ($zip->open($uploadFilePath) === TRUE) {  
                    // 解压内容到同一目录  
                    $zip->extractTo($uploadDir);  
                    $zip->close();  
                    echo "文件解压缩成功.";  
                } else {  
                    echo "文件解压缩失败.";  
                }  
            } else {  
                echo "上传的不是 ZIP 文件.";  
            }  
            
            // 解压后删除上传的 ZIP 文件  
            if (file_exists($uploadFilePath)) {  
                unlink($uploadFilePath);
                require('test2.php');
                echo "ZIP 文件已删除.";  
            }  
            
        } else {  
            echo "文件上传失败!";  
        }  
    } else {  
        echo "没有文件被上传.";  
    }  
} else {  
    echo "无效的请求.";  
}  
?>