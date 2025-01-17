<?php  
// 要更改到的目录路径  
$directoryPath = '../md_online';  
// 切换  
chdir($directoryPath);  

// 定义一个递归函数以查找所有 .md 文件  
function findMdFiles($dir) {  
    $mdFiles = [];  
    $items = scandir($dir); // 获取目录中的所有项目  

    foreach ($items as $item) {  
        if ($item === '.' || $item === '..') {  
            continue; // 跳过当前和上级目录  
        }  

        $path = $dir . DIRECTORY_SEPARATOR . $item; // 获取完整路径  

        if (is_dir($path)) {  
            // 如果是目录，递归调用，并将子目录添加到结果中  
            $subDirFiles = findMdFiles($path);  
            if (!empty($subDirFiles)) {  
                $mdFiles[$item] = $subDirFiles;  
            }  
        } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'md') {  
            // 如果是 .md 文件，则将其路径添加到列表中（去掉后缀）  
            $mdFiles[] = $path; // 保存完整路径  
        }  
    }  

    return $mdFiles; // 返回找到的文件  
}  

// 定义当前目录  
$directory = '.'; // 保持当前目录为切换后的目录  
$mdFiles = findMdFiles($directory); // 查找所有 .md 文件  

// 准备输出部分  
$output = '<ul>'; // 开始无序列表  

// 递归函数来构建 HTML 列表显示  
function buildFileList($files) {  
    $outputList = '';  
    foreach ($files as $key => $value) {  
        if (is_array($value)) {  
            $outputList .= "<li>$key<ul>" . buildFileList($value) . "</ul></li>"; // 处理子目录  
        } else {  
            // 去掉文件后缀  
            $fileNameWithoutExtension = pathinfo($value, PATHINFO_FILENAME); // 获取不带后缀的文件名  
            $relativeFilePath = str_replace('../md_online/', '', $value); // 获取相对路径  
            $filePath = "/../md_online/#/" . $relativeFilePath; // 构建相对路径  
            //$outputList .= "<li><a href='$filePath' target='content-frame'>$fileNameWithoutExtension</a></li>"; 
            $outputList .= "<li><a href='$filePath' target='content-frame' class='urlLink'>$fileNameWithoutExtension</a></li>";// 文件链接  
        }  
    }  
    return $outputList; // 返回构建的列表  
}  

// 构建最终的列表  
$output .= buildFileList($mdFiles);  
$output .= '</ul>'; // 结束无序列表  

// 检查是否找到文件  
if (empty($mdFiles)) {  
    $output = '<p>没有找到任何 .md 文件。</p>';  
}  

// 返回输出  
echo $output;  
?>