# 通过PHPExcel导出Excel文件时，出现“格式与文件扩展名格式不一致”错误！

在window下，通过PHPExcel导出Excel文件时，出现“格式与文件扩展名格式不一致”错误！phpExcel整个导出流程没有问题，导入也正常。没法：百度、google，基本都可以解决，深层的问题，还是得google。

还得说明一点：

发现问题的过程，就是成长的过程！只有见的多，了解的多，下次即使碰到问题，我们也可根据类似的情况，分析解决它！

就拿这个PHPExcel导出问题来说，就会引出一连串的知识点，我在最后，会转载几个我简单看过的文章。

不扯了，解决当下这个问题：

插入导出最后的部分代码，具体我没详细看过PHPExcel代码和demo，也是参照别人的代码，修改使用的：


	// 生成Excel文件的两种方式
	    // 2003excel：xls如下：
	    // header('Content-Type: application/vnd.ms-excel');
	    // header('Content-Disposition: attachment;filename="links_out'.$timestamp.'.xls"');
	    // header('Cache-Control: max-age=0');
	    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    // $objWriter->save('php://output');
	    // exit;
	    
	    // 2007excel：xlsx如下：
	    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    // header('Content-Disposition: attachment;filename="'.$excelName.'.xlsx"');
	    // header('Cache-Control: max-age=0');
	    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	    // $objWriter->save('php://output');
	    // exit;
原因：

1.发送header()头之前，不知道又啥特殊字符输出（可能是BOM，也可能是其他），导致php报错！然后将报错内容输出到了Excel

2.极大可能是：文件BOM头问题，生成的Excel文件头部添加了BOM头！

解决方案：

1.在输出Excel前，缓冲区中处理BOM头（可能是其他字符）

ob_end_clean();

ob_start();

在header()函数调用之前，清楚之前的错误输出！

2.有人第一步过后，问题未解决。通过ob_get_contents()查看导出内容，并未发现BOM头。

说明是在发送给浏览器的某个阶段添加的BOM头（应该是header()后的2行代码中，也不太清楚...）这个阶段我们不太容易处理（也就不要太纠结，有可能得捋PHPExcel代码，查找BOM头因哪个文件导致）。直接批量修改项目所有文件，去除BOM头！

这个才是真正解决问题的根本！

以上2步，应该就可以解决问题了！前提是不是因PHPExcel调用不当！（其实，第一步是不是可忽略？直接第二步就够了？？大家可以测试下，我第一步就解决了！）

----------------------------------------------------------------------------------------------

参考文章：

https://my.oschina.net/maczhao/blog/16270

它里面引用了国外一哥们提的问题，文章如下，解释的更清楚点：

http://phpexcel.codeplex.com/discussions/237813

国外这哥们，就是分了2步解决的：

里面有个人的评论，挺不错的：

When you save the file, ensure that you save it as UTF-8 without a BOM marker. Your modifications are failing because PHP will treat the BOM marker as output, which will then trigger an error when your script tries to send the headers, and this error display gets included in the Excel file that is generated. Using output buffering is preventing this output from occuring before the headers, so there won't be any error, but the BOM marker itself will still be included in the Excel file that is generated.

－－－－ 翻译 －－－－

当保存文件时，确保文件的UTF-8没有BOM标记。第一步的修改(ob_end_clean()和ob_start())失败，因为PHP将BOM标记作为输出，当脚本尝试发送header头时，将触发一个错误！并且这个错误最终将会被包含到生成的Excel文件中。使用了 'ob-控制输出'，在发送header头之前，阻止了这个输出，之前在Excel表中，会有报错信息展示，加了第一步的2个东西，只是屏蔽了这个错误，因此在Excel中不会有任何错误输出！但是 “BOM” 并非是错误！而是发送的真实文件内容！它一样会给Excel表中，所以还是会错！

我新创建一个编码分类，在里面转载了文章，编码这东西也很重要！是我们经常会碰到的问题，这篇文章真心很不错！链接如下： 

[由web程序出现乱码开始挖掘(Bom头、字符集与乱码）](https://blog.csdn.net/beyond__devil/article/details/53284005)

还转载了个批量删除文件的DOM头，这个较简单，可看看：

[递归删除utf8文件的bom头(该bom头可能导致php产生意外输出)](https://blog.csdn.net/beyond__devil/article/details/53283970)

