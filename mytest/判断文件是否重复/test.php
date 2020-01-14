<?php

/**
 * 文件的唯一标识码
 * @description: 计算指定文件的 MD5 散列值。计算 filename 文件的 MD5 散列值并返回。该散列值为 32 字符的十六进制数字。 
 * 成功返回字符串，否则返回 FALSE。 
 * @param {string} $filename 要散列的文件的文件名(要计算的文件必须在指定路径或者当前路径存在，否则会有一个warning)
 * @param {bool} $raw_output 如果被设置为 TRUE，那么报文摘要将以原始的 16 位二进制格式返回, 默认返回 32 字符长度的十六进制数字
 * @return: string
 * @note: 应用场景：可用于用户文件上传时，从根本上判断文件是否重复。(TODO: 待实验：能不能精确判断视频、音频文件多几秒，文本文件
 * 多几个字能不能判重)
 */
// $file = '1.txt';
// echo 'MD5 file hash of ' . $file . ': ' . md5_file($file);

// var_dump(md5_file('1.mp4'));
// var_dump(md5_file('2.mp4'));

/**
 * @description: 计算文件的 sha1 散列值并返回由 filename 指定的文件的 sha1 散列值。该散列值是一个 40 字符长度的十六进制数字. 
 * 成功返回一个字符串，否则返回 FALSE。 
 * @param {string} $filename 要散列的文件的文件名(要计算的文件必须在指定路径或者当前路径存在，否则会有一个warning)
 * @param {bool} $raw_output 如果被设置为 TRUE，sha1 摘要将以 20 字符长度的原始格式返回, 默认返回 40 字符长度的十六进制数字
 * @return: string
 * @note: 应用场景：可用于用户文件上传时，从根本上判断文件是否重复。(TODO: 待实验：能不能精确判断视频、音频文件多几秒，文本文件
 * 多几个字能不能判重)
 */
// string sha1_file( string $filename[, bool $raw_output = false] )

// $file = 'php-5.3.0alpha2-Win32-VC9-x64.zip';
// echo 'sha1 file hash of ' . $file . ': ' . sha1_file($file);

// if (is_dir($dir)) {
//     echo $dir . ' (SHA1: ' . sha1_file($dir) . ')', PHP_EOL;
// }

    