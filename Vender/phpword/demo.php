<?php
header("Content-Type: text/html; charset=UTF-8");
// include "./phpword/PHPWord.php";

// $PHPWord = new PHPWord();
// $sectionStyle = array(
//     'orientation' => 'landscape', // 设置纸张方向为横向，不设置值或者为null即为纵向
//     'marginLeft' => 900,  // 相当于css中的padding-left
//     'marginRight' => 900, // 相当于css中的padding-right
//     'marginTop' => 900, // 相当于css中的padding-top
//     'marginBottom' => 900, // 相当于css中的padding-bottom
//     'pageSizeW' => 21500, // 页面的宽度
//     'pageSizeH' => 12500
// ); // 页面的高度
// $section = $PHPWord->createSection($sectionStyle); //创建页面

$text = <<<'EOD'
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$attribute$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:宋体">慢性支气管炎、慢性阻塞性肺疾病</span><span style="font-family:'Times New Roman'">{~$|$~}B</span><span style="font-family:宋体">型题</span><span style="font-family:'Times New Roman'">{~$|$~}</span><span style="font-family:宋体">中</span><span style="font-family:'Times New Roman'">{~$|$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$subject$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">A</span><span style="font-family:宋体">、</span><span style="font-family:宋体; font-weight:bold">肺功能正常范围</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">B</span><span style="font-family:宋体">、潮气量增加</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">C</span><span style="font-family:宋体">、残气量减少</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">D</span><span style="font-family:宋体">、第</span><span style="font-family:'Times New Roman'">1</span><span style="font-family:宋体">秒用力呼气量减少</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">E</span><span style="font-family:宋体">、</span><span style="font-family:宋体; color:#ff0000">闭合气量减少</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:宋体">下列病例肺功能检查显示</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_attribute$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:宋体">主观题</span><span style="font-family:'Times New Roman'">{~$|$~}1</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_subject$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:隶书">患者</span><span style="font-family:隶书">,</span><span style="font-family:隶书">男</span><span style="font-family:隶书">,40</span><span style="font-family:隶书">岁</span><span style="font-family:隶书">,</span><span style="font-family:隶书">咳嗽、咳痰</span><span style="font-family:隶书">2</span><span style="font-family:隶书">年</span><span style="font-family:隶书">,</span><span style="font-family:隶书">每年持续</span><span style="font-family:隶书">3</span><span style="font-family:隶书">个月</span><span style="font-family:'Times New Roman'">(</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">)</span><span style="font-family:宋体">。</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_answer$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">A</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_analysis$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">&nbsp;</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_attribute$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:宋体">主观题</span><span style="font-family:'Times New Roman'">{~$|$~}1</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_subject$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:宋体">患者</span><span style="font-family:'Times New Roman'">,</span><span style="font-family:宋体">女</span><span style="font-family:'Times New Roman'">,55</span><span style="font-family:宋体">岁</span><span style="font-family:'Times New Roman'">,</span><span style="font-family:宋体">咳嗽、咳痰</span><span style="font-family:'Times New Roman'">15</span><span style="font-family:宋体">年</span><span style="font-family:'Times New Roman'">,</span><span style="font-family:宋体">上楼</span><span style="font-family:'Times New Roman'">,</span><span style="font-family:宋体">气短</span><span style="font-family:'Times New Roman'">5</span><span style="font-family:宋体">年</span><span style="font-family:'Times New Roman'">(</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">&nbsp;</span><span style="font-family:'Times New Roman'">)</span><span style="font-family:宋体">。</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_answer$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">D</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt"><span style="font-family:'Times New Roman'">{~$sub_analysis$~}</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; widows:0; orphans:0; font-size:10.5pt"><span style="font-family:Calibri; -aw-import:ignore">&nbsp;</span></p>
EOD;

file_put_contents('error.html', $text);

// $section->addText($text);

// // 设置字体样式
// $PHPWord->addFontStyle('rStyle', array('bold' => true, 'italic' => true, 'size' => 16));
// // 设置文本样式
// $PHPWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 100));
// // 设置标题样式
// $PHPWord->addTitleStyle(1, array('bold' => true), array('spaceAfter' => 240));
// // 设置文档内容标题
// $section->addTitle('欢迎使用', 1);
// // 设置文档内容
// $section->addText('中国');
// // 设置换行符,参数为换行符数量
// $section->addTextBreak(2);

// $src = trim($_SERVER['DOCUMENT_ROOT'] . '/test/1.jpg');
// // 设置文档内容的图片,第一个参数是某个目录下的图片名,第二个参数是图片在文档内的宽高数组
// $section->addImage($src, array('width' => 180, 'height' => 180));

// //表格--------------------------------------------------------------------------------------------

// // Define table style arrays
// $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80);
// $styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');

// // Define cell style arrays
// $styleCell = array('valign' => 'center');
// $styleCellBTLR = array('valign' => 'center', 'textDirection' => PHPWord_Style_Cell::TEXT_DIR_BTLR);

// // Define font style for first row
// $fontStyle = array('bold' => true, 'align' => 'center');

// // Add table style
// $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// // 增加这个表格
// $table = $section->addTable('myOwnTableStyle');

// // 增加表格的行
// $table->addRow(900);

// // 增加表格的单元格
// $table->addCell(2000, $styleCell)->addText('姓名 1', $fontStyle);
// $table->addCell(2000, $styleCell)->addText('性别 2', $fontStyle);
// $table->addCell(2000, $styleCell)->addText('Row 3', $fontStyle);
// $table->addCell(2000, $styleCell)->addText('Row 4', $fontStyle);
// $table->addCell(500, $styleCellBTLR)->addText('Row 5', $fontStyle);

// // Add more rows / cells
// for ($i = 1; $i <= 10; $i++) {
//     $table->addRow();
//     $table->addCell(2000)->addText("我 $i");
//     $table->addCell(2000)->addText("Cell $i");
//     $table->addCell(2000)->addText("Cell $i");
//     $table->addCell(2000)->addText("Cell $i");

//     $text = ($i % 2 == 0) ? 'X' : '';
//     $table->addCell(500)->addText($text);
// }
// //-------------------------------------表格结束-------------------------------------------------------
// // Add table
// $table = $section->addTable();

// for ($r = 1; $r <= 10; $r++) { // Loop through rows
//     // Add row
//     $table->addRow();

//     for ($c = 1; $c <= 5; $c++) { // Loop through cells
//         // Add Cell
//         $table->addCell(1750)->addText("行 $r, 列 $c");
//     }
// }
// //-----------------------------简单表格----------------------------
// // 设置文档页眉
// $header = $section->createHeader();
// $table = $header->addTable();
// $table->addRow();
// $table->addCell(4500)->addText('我是页头.');
// $table->addCell(4500)->addImage($src, array('width' => 50, 'height' => 50, 'align' => 'right'));

// //设置文档页脚
// $footer = $section->createFooter();
// $footer->addPreserveText('第 {PAGE} 页共 {NUMPAGES} 页', array('align' => 'center'));
// $section->addTextBreak(2);

// // 设置超链接
// $section->addLink('http://www.google.com', null, '中国');
// $section->addTextBreak();
// $section->addLink('http://www.google.com', '最好的搜索', array('color' => '0000FF', 'underline' => PHPWord_Style_Font::UNDERLINE_SINGLE));
// $section->addTextBreak(2);

// $PHPWord->addLinkStyle('myOwnLinkStyle', array('bold' => true, 'color' => '808000'));
// $section->addLink('http://www.bing.com', '描述', 'myOwnLinkStyle');
// $section->addLink('http://www.yahoo.com', '超级链接', 'myOwnLinkStyle');


// // 设置文档内容的形式为列表
// $section->addListItem('列表 1', 0);
// $section->addListItem('List Item 1.1', 1);
// $section->addListItem('List Item 1.2', 1);
// $section->addListItem('List Item 1.3 (styled)', 1, array('bold' => true));
// $section->addListItem('List列表Item 1.3.1', 2);
// $section->addListItem('List Item 1.3.2', 2);
// $section->addTextBreak(2);

// $section = $PHPWord->createSection();
// $lineStyle  = array('weight' => 1 ,'width' => 100 ,'height' => 0 ,'color' => 635552); 
// $section->addLine($lineStyle);

// $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'HTML');
// $objWriter->save('error.html');
