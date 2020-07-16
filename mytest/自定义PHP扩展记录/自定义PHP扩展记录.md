1. PHP 扩展由几个文件组成，这些文件对所有扩展来说都是通用的。不同扩展之间，这些文件的很多细节是相似的，只是要费力去复制每个文件的内容。幸运的是，有脚本可以做所有的初始化工作，名为 **ext_skel**，自 PHP 4.0 起与其一起分发。

   不带参数运行 **ext_skel** 会产生以下输出：

```shell
find / -name ext_skel
cd /usr/local/src/php-5.6.36/ext/   #先切换到ext_skel所在的目录
./ext_skel --extname=module [--proto=file] [--stubs=file] [--xml[=file]]
           [--skel=dir] [--full-xml] [--no-help]  #系统给的例子
  
  #ext_skel 脚本的参数列表
  --extname=module   创建你的扩展名
  --proto=file       文件包含要创建的函数原型
  --stubs=file       只在文件中生成函数存根
  --xml              生成要添加到phpdoc-cvs中的xml文档
  --skel=dir         到骨架目录的路径
  --full-xml         为自包含扩展生成xml文档(未实现)
  --no-help          不要试图友好地在代码中创建注释和辅助函数来测试模块是否编译完成
  
	通常来说，开发一个新扩展时，仅需关注的参数是 --extname 和 --no-help。除非已经熟悉扩展的结构，否则不要想去使用 --no-help; 指定此参数会造成 ext_skel 会在生成的文件里省略很多有用的注释。
	剩下的 --extname 会将扩展的名称传给 ext_skel。"name" 是一个全为小写字母的标识符，仅包含字母和下划线，在 PHP 发行包的 ext/ 文件夹下是唯一的。
	--proto 选项允许开发人员指定一个头文件，由此创建一系列 PHP 函数，表面上看就是要开发基于一个函数库的扩展，但对大多数头现代的文件来说很少能起作用。如果用 zlib.h 头文件来做测试，就会导致在 ext_skel 的输出文件中存在大量的空的和无意义的原型文件。--xml 和 --full-xml 选项当前完全不起作用。--skel 选项可用于指定用一套修改过的框架文件来工作。
```

2. 例子

```shell
find / -name ext_skel
cd /usr/local/src/php-5.6.36/ext/   #先切换到ext_skel所在的目录
#生成名字为helloworld的目录，该目录包含所需的文件
./ext_skel --extname=helloworld   #增加一个helloworld扩展（目录及扩展，并初始化相关文件）
cd helloworld/
ls
config.m4  config.w32  CREDITS  EXPERIMENTAL  helloworld.c  helloworld.php  php_helloworld.h  tests


#修改config.m4
//修改
dnl PHP_ARG_WITH(helloworld, for helloworld support,
dnl Make sure that the comment is aligned:
dnl [  --with-helloworld             Include helloworld support])
//为
PHP_ARG_WITH(helloworld, for helloworld support,
[  --with-helloworld             Include helloworld support])
//dnl 代表注释，下边 –enable-myext，是表示编译到php内核中。with是作为动态链接库载入


#修改php_helloworld.h，（php7就不需要修改.h文件，直接在.c中添加函数）
#这里就是扩展函数声明部分
PHP_FUNCTION(confirm_myext_compiled); 下面增加一行
PHP_FUNCTION(myext_helloworld); //表示声明了一个myext_helloworld的扩展函数。


#然后修改helloworld.c，这个是扩展函数的实现部分
//修改
const zend_function_entry myext_functions[] = {
        PHP_FE(confirm_myext_compiled,  NULL)   /* For testing, remove later. */
        PHP_FE_END      /* Must be the last line in myext_functions[] */
};

//这是函数主体，我们将我们的函数myext_helloworld的指针注册到PHP_FE，必须以PHP_FE_END      结束
const zend_function_entry myext_functions[] = {
        PHP_FE(confirm_myext_compiled,  NULL)   /* For testing, remove later. */
        PHP_FE(myext_helloworld,  NULL)
        PHP_FE_END      /* Must be the last line in myext_functions[] */
};

//在helloworld.c末尾加myext_helloworld的执行代码。

PHP_FUNCTION(myext_helloworld)
{
    char *arg = NULL;
    int arg_len, len;
    //这里说明该函数需要传递一个字符串参数为arg指针的地址，及字符串的长度
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
        return;
    }
    php_printf("Hello World!\n");
    RETURN_TRUE;
}

#zend_parse_parameters的参数（类似scanf）：
ZEND_NUM_ARGS()：传递给函数参数总个数的宏。
TSRMLS_CC：为了线程安全，宏。
"s"：指定参数类型，s代表字符串。
&arg：传进来的参数存放在arg中
&arg_len：存放字符串长度

#在helloworld目录下依次执行phpize、./configure 、make、make install
//执行make install时，可以看到本地php的默认扩展读取目录
root@iZuf6fih:/code/php5-5.5.9+dfsg/ext/helloworld# make install
Installing shared extensions:     /usr/lib/php5/20121212/

//进入/usr/lib/php5/20121212/可以看到生成的 helloworld.so
root@iZuf6fih# cd  /usr/lib/php5/20121212/
root@iZuf6fih:/usr/lib/php5/20121212# ls
beacon.so  helloworld.so  json.so  lary.so  mysqli.so  mysql.so  opcache.so  pdo_mysql.so  pdo.so  readline.so

#把编译出的.so文件加入php.ini中：
//php.ini一般位于/etc/php/7.0/apache2/php.ini下，在php.ini中搜索extension =，然后在下一行添加
extension =  /usr/lib/php5/20121212/helloworld.so

#重启服务器
nginx -s reload
service php-fpm restart

#然后编写一个简单的php脚本来调用扩展函数：
<php
echo myext_helloworld();
phpinfo();//输出的php信息中可以看到扩展库的产生
?>
```

