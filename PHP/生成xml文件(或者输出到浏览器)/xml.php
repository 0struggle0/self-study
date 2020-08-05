<?php
/**
 * Created by PhpStorm.
 * User: wz
 * Date: 2018/10/18
 * Time: 16:24
 */
//
//保存xml文件
$doc = new DOMDocument('1.0','utf-8');
$doc->formatOutput = true;//格式化输出格式
$root = $doc->createElement('root');//创建一个标签
$book = $doc->createElement('book');//创建一个标签
//$newso = $doc->createTextNode('33333333');//设置标签内容
$root->appendChild($book);
$doc->appendChild($root);
$doc->save("php.xml");

//$dom = new DOMDocument('1.0', 'utf-8');
//$dom->formatOutput = true;//格式化输出格式
//$programlanguages = $dom->createElement('programlanguages');
//$element = $dom->createElement('programlanguage', 'PHP');
//$elementTitle = $dom->createAttribute('title');//设置标签内容
//$elementTitleText = $dom->createTextNode("PHP是世界上最好的语言");//设置属性内容
//$elementTwo = $dom->createElement('programlanguage', 'Java');
//$elementTitle->appendChild($elementTitleText);
//$element->appendChild($elementTitle);
//$programlanguages->appendChild($element);
//$programlanguages->appendChild($elementTwo);
//$dom->appendChild($programlanguages);
//$dom->save("php.xml");
//header('Content-type: application/xml');
//header('Content-Disposition: attachment; filename="downloaded.xml"');
//readfile('php.xml');

//header('Content-Type: text/xml;');
//$doc = new DOMDocument('1.0','utf-8');
//$doc->formatOutput = true;//格式化输出格式
//$root = $doc->createElement('root');//创建一个标签
//$book = $doc->createElement('book');//创建一个标签
//$newso = $doc->createTextNode('33333333');//设置标签内容
//$root->appendChild($book);
//$doc->appendChild($root);
//$xmlString = $doc->saveXML();
////输出XML字符串
//echo $xmlString;exit;


//输出到浏览器上展示
//header('Content-Type: text/xml;');
////创建新的xml文件
//$dom = new DOMDocument('1.0', 'utf-8');
////建立<response>元素
//$response = $dom->createElement('response');
//$dom->appendChild($response);
//
////建立<books>元素并将其作为<response>的子元素
//$books = $dom->createElement('books');
//$response->appendChild($books);
//
////为book创建标题
//$title = $dom->createElement('title');
//$titleText = $dom->createTextNode('PHP与AJAX');
//$title->appendChild($titleText);
//
////为book创建isbn元素
//$isbn = $dom->createElement('isbn');
//$isbnText = $dom->createTextNode('1-21258986');
//$isbn->appendChild($isbnText);
//
////创建book元素
//$book = $dom->createElement('book');
//$book->appendChild($title);
//$book->appendChild($isbn);
//
////将<book>作为<books>子元素
//$books->appendChild($book);
//
////在一字符串变量中建立XML结构
//$xmlString = $dom->saveXML();
//
////输出XML字符串
//echo $xmlString;exit;

