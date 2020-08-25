# CodeIgniter上传文件相关问题

## 一、上传word文档失败

CI框架出于安全考虑,对上传文件的类型判断并不仅仅是判断文件后缀名这么简单,同时还会读取文件的MIME(Multipurpose Internet Mail Extensions)类型,判断是否和config目录下mimes.php中的类型匹配,但是不知道是什么情况导致了MIME类型读取失败.

通过查看框架代码发现,CI是使用@mime_content_type函数来判断的,但是不知为何该函数返回了FALSE或者空字符串导致此问题的出现.

回到对上传文件的分析,我发现并不是所有的Office文件都会导致此问题,仅限于那些打开时Office有提示是”来源于网络的文档”.而且,当对文档进行了编辑(取消保护模式)后保存,再上传却可以上传成功!

所以暂且推测是mime_content_type对保护模式的文档MIME类型判断存在问题导致的.

### 解决方法

在config/mimes.php的$mimes数组中,对需要允许上传的类型加入特殊处理.比如如果需要上传的是doc类型的文件,就改成:

```
'doc'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword',"cdf v2 document, corrupt: can't expand summary_info"),
```