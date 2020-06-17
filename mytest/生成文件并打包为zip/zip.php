<?php

$errorHtmlUrl = 'error.html';
$filename = "error.zip";
file_put_contents($errorHtmlUrl, '<p>法律的框架给人</p>');

$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE);   //打开压缩包
$zip->addFile($errorHtmlUrl, basename($errorHtmlUrl)); //向压缩包中添加文件
$zip->close();  //关闭压缩包


// 压缩多个文件
// 压缩多个文件，其实就是addFile执行多次，可以通过数组的遍历来实现。
$fileList = array(
    "c:/wamp/www/log.txt",
    "c:/wamp/www/weixin.class.php"
);
$filename = "test.zip";
$zip = new ZipArchive();
$zip->open($filename,ZipArchive::CREATE);   //打开压缩包
foreach($fileList as $file){
    $zip->addFile($file,basename($file));   //向压缩包中添加文件
}
$zip->close();  //关闭压缩包


// 压缩一个目录
function addFileToZip($path,$zip){
    $handler=opendir($path); //打开当前文件夹由$path指定。
    while(($filename=readdir($handler))!==false){
        if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
            if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                addFileToZip($path."/".$filename, $zip);
            }else{ //将文件加入zip对象
                $zip->addFile($path."/".$filename);
            }
        }
    }
    @closedir($path);
}
$zip=new ZipArchive();
if($zip->open('rsa.zip', ZipArchive::OVERWRITE)=== TRUE){
    addFileToZip('rsa/', $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
    $zip->close(); //关闭处理的zip文件
}


// 压缩并下载zip包
// 我的时候，我们需要打包之后，提供下载，然后删除压缩包。

// 可以分为以下几步：

// 判断给出的路径，是文件夹，还是文件。文件夹还需要遍历添加文件。
// 设置相关文件头，并使用readfile函数提供下载。
// 使用unlink函数删除压缩包
function addFileToZip($path,$zip){
    $handler=opendir($path); //打开当前文件夹由$path指定。
    while(($filename=readdir($handler))!==false){
        if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
            if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                addFileToZip($path."/".$filename, $zip);
            }else{ //将文件加入zip对象
                $zip->addFile($path."/".$filename);
            }
        }
    }
    @closedir($path);
}
$zip=new ZipArchive();
if($zip->open('rsa.zip', ZipArchive::OVERWRITE)=== TRUE){
    $path = 'rsa/';
    if(is_dir($path)){  //给出文件夹，打包文件夹
        addFileToZip($path, $zip);
    }else if(is_array($path)){  //以数组形式给出文件路径
        foreach($path as $file){
            $zip->addFile($file);
        }
    }else{      //只给出一个文件
        $zip->addFile($path);
    }
 
    $zip->close(); //关闭处理的zip文件
}