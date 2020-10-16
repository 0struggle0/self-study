# 解决php读取word文件过程中乱码问题

#### 一、首先要确认php版本，最好是高于5.6

#### 二、启用PHP   Com  扩展

```php
// 将以下两行代码放入php.ini中, 并且重启服务器
// 开启扩展
extension=php_com_dotnet.dll
// COM扩展里自带的，只需将前面的；去掉就可以了
com.allow_dcom = true
```

#### 三、代码如下：

```php
    public function readWord($url)
    {
        $word = new COM("word.application") or die("Unable to instantiate Word");

        // 打开路径为URL的word，doc或docx都可以
        $word->Documents->OPen($url);

        // 读取内容
        $test= $word->ActiveDocument->content->Text;

        // 统计字数
        // $num = strlen($test);

        // 解决读取过程中乱码问题
        $content= iconv('GB2312', 'UTF-8', $test);

        // 查看版本
        // $word_wersion = $word->Version;

        // 是否要打开文件，0代表否，1代表是
        $word->Visible = 0;

        // 关闭word句柄
        $word->Quit();

        // 释放对象
        $word = null;

        return [
            // 'num' => $num / 2,
            // 'word_wersion' => $wordWersion,
            'content' => $content
        ];
    }
```



**注意:**

**问题一：**

**文件url有一个地方需要注意，就是你们传进来的url千万不能是绝对地址，不能是D:\WWW\这种，，一定要自己框架的路由地址，比如localhost/..，不然会出现错误，因为用绝对地址读取word内容，只能读取一次，然后word就会被锁定，然后就无法读取了。**



**问题二：**

**使用这种方式虽然解决了读取Word内容乱码的问题，但是只限于读取纯文本的Word，而且是没有样式的那种。如果需要获取Word文档的内容包括样式、图片、字体等，这种方式就不适合。**

**我们处理的方式是，采用Aspos。用Java做了一个底层服务，把上传的Word文档都转成html格式的，如果文档中有图片的话，转换后图片会被提取到同级目录，并在生成的html文件中留下 `<img>` 标签。 这样Word文档中的字体和样式就变成了了HTML代码，最大程度保留了原文档的样式。**