<?php

// 压缩单个文件
// $errorHtmlUrl = 'error.html';
// $html = '<p>测试压缩包</p>';
// file_put_contents($errorHtmlUrl, $html);

// $zipFilename = "error.zip";
// $zip = new ZipArchive();
// if ($zip->open($zipFilename, ZipArchive::CREATE) === true) { // 打开压缩包
//     $zip->addFile($errorHtmlUrl, 'test.html'); // 向压缩包中添加文件error.html, 并重命名为test.html(可以选择性填写)
//     $zip->close();  // 关闭压缩包；I/O操作一般都比较消耗服务器资源，用完就得关闭
//     echo 'create zip success';
// } else {
//     echo 'create zip failed';
// }


// 压缩多个文件
// 其实就是addFile执行多次，可以通过数组的遍历来实现。
// $fileNames = array(
//     'test.php',
//     'test2.php',
//     'test3.php'
// );

// $zipFilename = 'test.zip';
// $zip = new ZipArchive();
// if ($zip->open($zipFilename, ZipArchive::CREATE) === true) { // 打开压缩包
    // foreach ($fileNames as $fileName) {
    //     $zip->addFile($fileName);   
    // }
    // $zip->close(); 
// } else {
//     echo 'create zip failed';
// }

// 解压文件
// $zip = new ZipArchive;
// if ($zip->open('test.zip') === TRUE) {
//     // extractTo 方法解压缩文件,将压缩文件解压缩到指定的目录; 
//     // 还可以有第二个参数，它接受一个解压缩文件名数组，只把压缩包中的与这些文件同名的解压出来。 
//     $zip->extractTo('./testzipfile/'); 
//     $zip->close();
//     echo 'unzip success';
// } else {
//     echo 'unzip failed';
// }

// 压缩一个目录
// $zip = new ZipArchive();
// if ($zip->open('test.zip', ZipArchive::CREATE) === TRUE) {
//     addFileToZip('uploadImages/', $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
//     $zip->close(); //关闭处理的zip文件
// }

// function addFileToZip($path, $zip)
// {
//     $handler = opendir($path); // 打开指定指定文件夹
//     while (($filename = readdir($handler)) !== false) {
//         if ($filename != "." && $filename != "..") { // 文件夹文件名字为'.'和‘..’，不要对他们进行操作
//             if (is_dir($path . "/" . $filename)) { // 如果读取的某个对象是文件夹，则递归往下
//                 addFileToZip($path . "/" . $filename, $zip);
//             } else { // 将文件加入zip
//                 $zip->addFile($path . "/" . $filename);
//             }
//         }
//     }
//     @closedir($path); // 关闭目录指定指定文件夹
// }

#注意：
// $zip->open方法第二个参数可以有这四个参数
// ZIPARCHIVE::CREATE(integer) 如果不存在则创建一个zip压缩包。  
// ZIPARCHIVE::OVERWRITE(integer) 总是以一个新的压缩包开始，此模式下如果已经存在则会被覆盖。  
// ZIPARCHIVE::EXCL(integer) 如果压缩包已经存在，则出错。  
// ZIPARCHIVE::CHECKCONS(integer) 对压缩包执行额外的一致性检查，如果失败则显示错误。 


// 压缩并下载zip包
// 我的时候，我们需要打包之后，提供下载，然后删除压缩包。
// 可以分为以下几步：
// 判断给出的路径，是文件夹，还是文件。文件夹还需要遍历添加文件。
// 设置相关文件头，并使用readfile函数提供下载。
// 使用unlink函数删除压缩包
// function addFileToZip($path, $zip)
// {
//     $handler = opendir($path); //打开当前文件夹由$path指定。
//     while (($filename = readdir($handler)) !== false) {
//         if ($filename != "." && $filename != "..") { //文件夹文件名字为'.'和‘..’，不要对他们进行操作
//             if (is_dir($path . "/" . $filename)) { // 如果读取的某个对象是文件夹，则递归
//                 addFileToZip($path . "/" . $filename, $zip);
//             } else { //将文件加入zip对象
//                 $zip->addFile($path . "/" . $filename);
//             }
//         }
//     }
//     @closedir($path);
// }

// $zip = new ZipArchive();
// if ($zip->open('rsa.zip', ZipArchive::OVERWRITE) === TRUE) {
//     $path = 'rsa/';
//     if (is_dir($path)) {  //给出文件夹，打包文件夹
//         addFileToZip($path, $zip);
//     } else if (is_array($path)) {  //以数组形式给出文件路径
//         foreach ($path as $file) {
//             $zip->addFile($file);
//         }
//     } else {      //只给出一个文件
//         $zip->addFile($path);
//     }

//     $zip->close(); //关闭处理的zip文件
// }


// 还有zip函数zip_open()、zip_read()、zip_close()等 
// 二、 使用Zlib 函数 处理.gz文件
// 三、 使用RarArchive 类处理.rar文件
// 四、使用Bzip2 函数 处理.bz2文件
// 五、使用Phar 类处理.phar文件