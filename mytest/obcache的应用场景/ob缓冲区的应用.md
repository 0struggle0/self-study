# ob函数的应用场景

ob，输出缓冲区，是output buffering的简称，而不是output cache。ob用对了，是能对速度有一定的帮助，但是盲目的加上ob函数，只会增加CPU额外的负担。

ob的基本原则：如果ob缓存打开，则echo的数据首先放在ob缓存。如果是header信息，直接放在程序缓存。当页面执行到最后，会把ob缓存的数据放到程序缓存，然后依次返回给浏览器。

ob的基本作用：

```php
	(1)防止在浏览器有输出之后再使用setcookie()、header()或session_start()等发送头文件的函数造成的错误。其实这样的用法少用为好，养成良好的代码习惯。
  	(2)捕捉对一些不可获取的函数的输出，比如phpinfo()会输出一大堆的HTML，但是我们无法用一个变量例如$info=phpinfo();来捕捉，这时候ob就管用了。
  	(3)对输出的内容进行处理，例如进行gzip压缩，例如进行简繁转换，例如进行一些字符串替换。
        复制代码 代码如下:
        ob_start(ob_gzhandler);
        要缓存的内容

        没错，加一个ob_gzhandler这个回调函数就可以了，不过这么做有些小问题，一是需要zlib支持，二是没有判断浏览器是否支持gzip（现在好像都支持，iphone浏览器好像都支持了）。
        以前的做法是判断一下浏览器是否支持gzip，然后用第三方的gzip函数来压缩ob_get_contents() 的内容，最后echo。
  	(4)生成静态文件，其实就是捕捉整页的输出，然后存成文件。经常在生成HTML，或者整页缓存中使用。
        // 有个缺陷：不能随着代码的变化重新生成文件
        if (is_file('./index.html')){
            header('location:./index.html');
        }

        ob_start();
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
        </head>
        <body>
        <p align="center">PHP生成HTML文件....</p>
        </body>
        </html>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        file_put_contents('./index.html',$html);

	对于刚才说的第三点中的GZIP压缩，可能是很多人想用，却没有真用上的，其实稍稍修改下代码，就可以实现页面的gzip压缩。

    (5)通过PHP写文件下载程序的时候.
	为了让文件下载更安全,同时提高更多的可控性,很多朋友都喜欢用PHP写文件下载页面.其原理很简单,就是通过fwrite把文件内容读出并显示,然后通过header来发送HTTP头,让浏览器知道这是一个附件,这样
    就可以达到提供下载的效果.
    如果用上面的办法提供下载页面,会碰到一个效率问题,如果一个文件很大,假设为100M,那么在不开启缓冲区输出的情况下,必须要把100M数据全部读出,然后一次返回到页面上,如果这样做,用户将会在所有数据读完
    之后才会得到响应,降低了用户体验感.
    如果开启了输出缓冲区,当PHP程序读完文件的某一段,然后马上输出到apache,然后让apache马上返回到浏览器,这样就可以减少用户等待时间.那后面的数据怎么办呢?我们可以写一个while循环,一直一段一段地读取文件
    每读一段,就马上输出,直到把文件全部输出为止,这样浏览器就可以持续地接受到数据,而不必等到所有文件读取完毕.

    另外,该做法还解决了另外一个很严重的问题.例如一个文件是100M,如果不开启缓冲区的情况下,则需要把100M文件全部读入内存,然后再输出.但是,如果PHP程序做了内存限制呢?为了保证服务器的稳定,管理员通常会把PHP的执行
    内存设一个限制(通过php.ini总的memory_limit, 其默认值是8M), 也就是每个PHP程序使用的内存不能使用超过这个值的内存. 假设该值为8M,而要读入的文件是100M,根本就没有足够的内存来读入该文件.这个时候,我们就需要用到上面的
    办法来解决这个问题,每次只读某一段,这样就可以避免了内存的限制
```



* ## ob_start() 开启缓冲区

```php
bool ob_start ([ callback $output_callback [, int $chunk_size [, bool $erase ]]] )

此函数将打开输出缓冲。当输出缓冲激活后，脚本将不会输出内容（除http标头外），相反需要输出的内容被存储在内部缓冲区中。
* 第一个参数要传递一个回调函数，其需将缓冲区内容做为参数，并且返回一个字符串。他会在缓冲区被送出时调用，缓冲区送出指的是执行了例如ob_flush() 等函数或者脚本执行完毕。
* 第二个参数 chunk_size 为缓冲区的字节长度，如果缓冲区内容大于此长度，将会被送出缓冲区，默认值为0，代表函数将会在最后被调用，其余的特殊值可以将 chunk_size 从 1 设定到 4096。 
* 第三个参数 erase 如果被设置为flase , 则代表脚本执行完毕后缓冲区才会被删除，如果提前执行了删除缓冲区函数(后面会提到)，会抛出一个"notice",并返回 FALSE 值。

例：
    <?php
    ob_start('handleString');
    echo '123456';

    function handleString($string){
      return md5($string);
    }
例：
    利用 ob_start() 进行页面压缩输出  //比较实用，能够压缩页面增加响应效率
    <?php
    ob_start('ob_gzhandler');
    echo str_repeat('oschina', 1024);
例：
	严防被人利用ob_start()第一个参数回调函数的特性执行外部命令
    $cmd = 'system';
    ob_start($cmd);
    echo "$_GET[a]";
    ob_end_flush();
```

* ## ob_get_contents() 获取缓冲区内容

```php
string ob_get_contents ( void )
    
此函数返回输出缓冲区的内容，或者如果输出缓冲区无效将返回FALSE 。 

例：
    <?php
    echo str_pad('', 4096);//使缓冲区溢出
    ob_start();//打开缓冲区
    phpinfo();
    $string = ob_get_contents();//获取缓冲区内容
    $re = fopen('./phpinfo.txt', 'wb');
    fwrite($re, $string);//将内容写入文件
    fclose($re);
    ob_end_clean();//清空并关闭缓冲区
```

*  ## ob_get_length()

```PHP
int ob_get_length ( void )

返回输出缓冲区内容的长度；或者返回FALSE——如果没有起作用的缓冲区。 

例：
    <?php
    ob_start();
    echo "Hello ";
    $len1 = ob_get_length();
    echo "World";
    $len2 = ob_get_length();
    ob_end_clean();
    echo $len1 . ", ." . $len2;
```

* ## ob_get_level

```php
int ob_get_level ( void )
    
返回输出缓冲机制的嵌套级别。 
    
例：
    <?php
    ob_start();
	echo '第一层';
    var_dump(ob_get_level());
    ob_start();
	echo '第二层';
    var_dump(ob_get_level());
    ob_end_flush();
    ob_end_flush();
```

*   ## ob_get_status

```php
array ob_get_status ([ bool $full_status  = FALSE ] )

ob_get_status()返回最顶层输出缓冲区的状态信息；或者如果full_status设为TRUE，返回一个详细信息的数组(所有有效的输出缓冲级别)。
    
设为TRUE 返回所有有效的输出缓冲区级别的状态信息。如果设为 FALSE 或者没有设置，仅返回最 顶层输出缓冲区的状态信息

 level 为嵌套级别，也就是和通过 ob_get_level() 取到的值一样。
 type 为处理缓冲类型，0为系统内部自动处理，1为用户手动处理。
 status 为缓冲处理状态， 0为开始， 1为进行中， 2为结束
 name 为定义的输出处理函数名称，也就是在 ob_start() 函数中第一个参数传入的函数名。
 del  为是否运行了删除缓冲区操作
    
例：
    如果调用时没有full_status参数，或者full_status = FALSE 将返回一个包含下面元素的简单数组： 
    Array
    (
        [level] => 2
        [type] => 0
        [status] => 0
        [name] => URL-Rewriter
        [del] => 1
    )
    
例：
    如果调用时full_status = TRUE，将返回一个数组，该数组的每个元素包含有效的输出缓冲区级别的状态信息。缓冲区的级别数用来当作数组的第一维数；每个元素自身是另一个数组，它持有该有效输出级别的状态信息。 
    Array
    (
        [0] => Array
            (
                [chunk_size] => 0
                [size] => 40960
                [block_size] => 10240
                [type] => 1
                [status] => 0
                [name] => default output handler
                [del] => 1
            )

        [1] => Array
            (
                [chunk_size] => 0
                [size] => 40960
                [block_size] => 10240
                [type] => 0
                [buffer_size] => 0
                [status] => 0
                [name] => URL-Rewriter
                [del] => 1
            )

    )
```

-  ## ob_list_handlers()

```php
array ob_list_handlers ( void )
    
此函数将返回一个数组，数组元素是正在使用中输出处理程序名（如果存在的输出处理程序的话）。 如果启用了output_buffering 或者在 ob_start() 中创建了一个匿名函数，ob_list_handlers() 将返回 "default output handler"。

例：
    <?php
    //using output_buffering=On
    print_r(ob_list_handlers());
    ob_end_flush();

    ob_start("ob_gzhandler");
    print_r(ob_list_handlers());
    ob_end_flush();

    // anonymous functions
    ob_start(create_function('$string', 'return $string;'));
    print_r(ob_list_handlers());
    ob_end_flush();

	Array
    (
        [0] => default output handler
    )

    Array
    (
        [0] => ob_gzhandler
    )

    Array
    (
        [0] => default output handler
    )
```

-   ## ob_flush()

```php
void ob_flush ( void )

这个函数将送出缓冲区的内容（如果里边有内容的话）。如果想进一步处理缓冲区中的内容，必须在ob_flush()之前调用ob_get_contents() ，因为在调用ob_flush()之后缓冲区内容将被丢弃。 

此函数不会销毁输出缓冲区，而像ob_end_flush() 函数会销毁缓冲区。 

```

- ## flush()

```php
void flush ( void )

刷新PHP程序的缓冲，而不论PHP执行在何种情况下（CGI ，web服务器等等）。该函数将当前为止程序的所有输出发送到用户的浏览器。 

flush() 函数不会对服务器或客户端浏览器的缓存模式产生影响。因此，必须同时使用 ob_flush() 和flush() 函数来刷新输出缓冲。 

个别web服务器程序，特别是Win32下的web服务器程序，在发送结果到浏览器之前，仍然会缓存脚本的输出，直到程序结束为止。 

有些Apache的模块，比如mod_gzip，可能自己进行输出缓存，这将导致flush()函数产生的结果不会立即被发送到客户端浏览器。 

甚至浏览器也会在显示之前，缓存接收到的内容。例如 Netscape 浏览器会在接受到换行或 html 标记的开头之前缓存内容，并且在接受到 </table> 标记之前，不会显示出整个表格。 

一些版本的 Microsoft Internet Explorer 只有当接受到的256个字节以后才开始显示该页面，所以必须发送一些额外的空格来让这些浏览器显示页面内容。 

```

- ## ob_implicit_flush()

```php
void ob_implicit_flush ([ int $flag = true ] )
    
此函数用来打开/关闭绝对刷送模式，就是在每一次输出后自动执行 flush()，从而不需要再显示的调用 flush() 
设为TRUE 打开绝对刷送，反之是 FALSE 。 
    
implicit_flush
该配置直接影响apache的缓冲区,有2种配置参数. on/off
on    - 自动刷新apache缓冲区,也就是,当php发送数据到apache的缓冲区的时候,不需要等待其他指令,直接就把输出返回到浏览器
off    - 不自动刷新apache缓冲区,接受到数据后,等待刷新指令

    
例：
    <?php
    echo str_pad('', 1024);//使缓冲区溢出
    ob_implicit_flush(true);//打开绝对刷送
    echo 'oschina.net';
    //flush();  之后不需要再显示的调用 flush()
    sleep(1);
    echo '红薯';
    //flush();
    sleep(1);
    echo '虫虫'; 
```

- ## ob_get_flush()

```php
bool ob_end_flush ( void )

此函数将缓冲区的内容送出，并关闭缓冲区。实际上相当于执行了 ob_flush() 和 ob_end_clean() ;
```

- ##ob_get_flush ()

```php
string ob_get_flush ( void )

此函数和 ob_end_flush() 的作用基本一致，只是其会以字符串的形式返回缓冲区的内容.
```

-  ## ob_clean()

```php
void ob_clean ( void )

此函数会将当前缓冲区清空，但不会关闭缓冲区，下面这个例子的输出将不会显示，因为在输出前，缓冲区已经被清空了，但我们又可以获取到缓冲区的属性，说明缓冲区没被关闭
 
例：
    <?php
    ob_start();
    echo 'oschina';
    ob_clean();
    var_dump(ob_get_status());
```

- ## ob_end_clean()

```php
bool ob_end_clean ( void )
    
此函数清空并关闭缓冲区

例：
    <?php
    ob_start();
    echo 'oschina';
    ob_end_clean();
    var_dump(ob_get_status());
```

- ##ob_get_clean()

```php
string ob_get_clean ( void )

此函数清空并关闭缓存，但会以字符串的形式返回缓存中的数据，实际上，这个函数就是分别执行了 ob_get_contents() 和 ob_end_clean();
```

- ## output_add_rewrite_var()

```php
bool output_add_rewrite_var ( string $name , string $value )

此函数添加URL重写机制的键和值，这里的URL重写机制，是指在URL的最后以GET方式添加键值对，或者在表单中以隐藏表单添加键值对
    
例：
    <?php
    output_add_rewrite_var('var', 'value');

    // some links
    echo '<a href="file.php">link</a>
    <a href="http://example.com">link2</a>';

    // a form
    echo '<form action="script.php" method="post">
    <input type="text" name="var2" />
    </form>';
    print_r(ob_list_handlers());

    //输出结果：
    <a href="file.php?var=value">link</a>
    <a href="http://example.com">link2</a>

    <form action="script.php" method="post">
    <input type="hidden" name="var" value="value" />
    <input type="text" name="var2" />
    </form>

    Array
    (
        [0] => URL-Rewriter
    )

   不是绝对URL地址的链接 和 Form表单 被加上了对应的键值对。
```

- ##output_reset_rewrite_vars()

```php
bool output_reset_rewrite_vars ( void )

此函数用来清空所有的URL重写机制，也就是删除由 output_add_rewrite_var() 设置的重写变量。
```



## 与输出缓冲区有关的配置

与输出缓冲区有关的配置
在PHP.INI中,有两个跟缓冲区紧密相关的配置项
1.output_buffering
该配置直接影响的是php本身的缓冲区,有3种配置参数.on/off/xK(x为某个整型数值);
on    - 开启缓冲区
off    - 关闭缓冲区
256k    - 开启缓冲区,而且当缓冲区的内容超过256k的时候,自动刷新缓冲区(把数据发送到apache);



## 使用缓冲区的相关内容

​	1.ob_flush和flush的次序关系.上面的分析可以看出,ob_flush是和php自身相关的,而flush操作的是apache的缓冲区,所有我们在使用这两个函数的时候,需要先执行ob_flush,
再执行flush,因为我们需要先把数据从PHP上发送到apache,然后再由apache返回到浏览器.如果php还没有把数据刷新到apache,就调用了flush,则apache无任何数据返回到浏览器.

​	2.有的浏览器,如果接受到的字符太少,则不会把数据显示出来,例如老版的IE(必须要大于256k才显示).这样就会造成一个疑问, 明明在php和apache都进行了刷新缓冲区的操作,但是浏览器就是没有出现自己想要的数据,也许就是这个原因造成的.所以才测试的时候,可以在输出数据的后面加上多个空格,以填满数据,确定不会浏览器造成这类诡异的问题.

​	3.有些webserver,他自身的输出缓冲区会有一些限制,比如nginx,他有一个配置fastcgi_buffer_size 4k, 就是是表明,当自身的输出缓冲区的内容达到4K才会刷新,所以为了保证内容的数据,可以添加以下代码,保证内容长度

​	4.在apache中,如果你开启了mod_gzip的压缩模块,这样可能会导致你的flush函数刷新不成功,其原因是,mod_gzip有自己的输出缓冲区,当php执行了flush函数,指示apache刷新输出缓冲区,但是内容需要压缩,apache就把内容输出到自身的mod_gzip模块,mod_gzip也有自身的输出 缓冲区,他也不会马上输出,所以造成了内容不能马上输出.为了改善这个情况,可以关闭mod_gzip模块,或者在httpd.conf增加以下内容,以禁止压缩

```
SetEnv no-gzip dont-vary
```

