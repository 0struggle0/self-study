<?php
/**
 * Created by PhpStorm.
 * User: wz
 * Date: 2018/10/18
 * Time: 17:18
 */

$doc = new DOMDocument('1.0','utf-8');
$doc->formatOutput = true;//格式化输出格式
$root = $doc->createElement('root');//创建一个标签
$courses = $doc->createElement('courses');//创建一个标签
$course = $doc->createElement('course');//创建一个标签

$chapters = $doc->createElement('chapters');//创建一个标签
$chapter = $doc->createElement('chapter');//创建一个标签
$chapter2 = $doc->createElement('chapter');//创建一个标签
$questiontypes = $doc->createElement('questiontypes');//创建一个标签
$questiontype = $doc->createElement('questiontype');//创建一个标签

$coursetext = $doc->createTextNode('阿里巴巴');//设置标签内容
$coursename = $doc->createAttribute('name');//设置标签内容

$chaptertext = $doc->createTextNode('章节1');//设置标签内容
$chaptertext2 = $doc->createTextNode('章节2');//设置标签内容
$questiontypetext = $doc->createTextNode('A题型');//设置标签内容
$newso1 = $doc->createTextNode("单选题");//设置属性内容
$newso2 = $doc->createTextNode("1");//设置属性内容
$basequestiontype = $doc->createAttribute('basequestiontype');//设置属性
$basequestiontypenumber = $doc->createAttribute('basequestiontypenumber');//设置属性

$root->appendChild($courses);
$courses->appendChild($course);

$course->appendChild($chapters);
$coursename->appendChild($coursetext);//将属性内容赋给属性
$course->appendChild($coursename);

$chapters->appendChild($chapter);
$chapters->appendChild($chapter2);
$chapter->appendChild($chaptertext);
$chapter2->appendChild($chaptertext2);
$course->appendChild($questiontypes);
$questiontypes->appendChild($questiontype);
$questiontype->appendChild($questiontypetext);
$basequestiontype->appendChild($newso1);//将属性内容赋给属性
$basequestiontypenumber->appendChild($newso2);//将属性内容赋给属性
$questiontype->appendChild($basequestiontype);
$questiontype->appendChild($basequestiontypenumber);

$doc->appendChild($root);
$doc->save("php.xml");
header('Content-type: application/xml');
header('Content-Disposition: attachment; filename="downloaded.xml"');
readfile('php.xml');
unlink('php.xml');

