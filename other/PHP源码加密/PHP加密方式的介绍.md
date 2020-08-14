**温馨提示：世界上没有破不了的密码，如果有那也只是时间问题。**

我们能做的只是增加破解时间。如果这个破解时间大于一个人的寿命，那么这个加密方式肯定是成功的。

对于加密的程序，就像破解者需要了解、猜测编写者的思路一样，编写者也需要去了解破解者的方法、手段。这样才能写出破解难度更高的程序。



## 壳”加密”

这一类“加密”包括：

1. 无扩展加密：phpjiami、zhaoyuanma的免费版本等
2. 有扩展的加密：`php-beast`、`php_screw`、`screw_plus`、`ZoeeyGuard`、`tonyenc`等市面上几乎所有的开源PHP加密扩展。

把它们称为“加密”算是抬举，它们真的真的只能被称为“自解压压缩包”，像是PHP界的WinRAR，或者是UPX、ASPack。笔者写到这里时暂时停顿了一下，笔者认为把这种“加密”和UPX这些壳相提并论是对UPX的侮辱。因为**任何一个较为熟悉PHP的人，都可以在一天之内写出这种级别的加密，而不需要任何额外的知识。**

这一类自解压压缩包的共同思路是：

1. 加密：直接加密整个PHP文件，不对原始PHP逻辑作出改动。无扩展的加密将给用户一个运行时环境（“壳”）和加密后的数据，有扩展的加密将直接获得加密后的数据，并要求用户在使用时安装对应的扩展。
2. 解密：壳或扩展先确认环境有没有被调试的风险，倘若没有，就直接在内存中解密出整个PHP文件，并使用`eval`或类似方式直接运行。

以下是笔者写的一个简化的代码示例：

```php
<?php
  $code = file_get_contents('待加密的PHP');
  $code = base64_encode(openssl_encrypt($code, 'aes-128-cbc', '密钥', false, 'IV'));
  echo "<?php eval(openssl_decrypt(base64_decode($code), 'aes-128-cbc', '密钥', false, 'IV'));";
```

相信读到这里的各位都能意识到，对这一类“壳加密”来说，是有万能的“解密”方案的。不需要知道数据的加密算法到底是什么，因为真实代码在执行时总会被解密出来，各位只需要知道PHP到底执行了什么，从这儿拿出代码。

不管是`eval`、`assert`、`preg_replace('//e')`，还是这类PHP加密扩展，想要动态执行代码就必须经过`zend_compile_string`这一个函数。只需要编写一个dll/so，给`zend_compile_string`挂上“钩子”，就能直接拿到完整的代码。笔者觉得详细讲这种加密是浪费本文空间，给出几篇文章作为参考：

https://www.leavesongs.com/PENETRATION/unobfuscated-phpjiami.html

http://blog.evalbug.com/2017/09/21/phpdecode_01/

也有一些网站可以在线解密，例如国外的UnPHP：https://www.unphp.net/

而如果你不会C，或者不想从PHP底层来破解，也有不少的伸手党策略，像是这篇针对`phpjiami` / `zym`的破解方案 https://www.52pojie.cn/thread-693641-1-1.html，可从中了解这些壳的基本运行方式。

有扩展加密中，`php_screw`因加密方式太弱，容易被已知明文攻击（举例：大部分PHP文件的开头均为`<?php`）推测出密钥。其他的加密就都需要手动逆向，过于麻烦，直接使用通用方案来反而是更简单的破解方式。

另外，还有一部分加密提供了一些附加功能。例如phpjiami提供的防SQL注入和访问控制功能。

![1597395867589](C:\Users\zzh\AppData\Roaming\Typora\typora-user-images\1597395867589.png)

如果真的相信SQL注入能靠这些“加密”来防御，那也未免too young too simple。这些防SQL注入**没有任何用处**，通过关键字过滤反而容易**拦截正常的用户输入**。相信它们，还不如在网站前面加一层360网站卫士、百度云加速。正确的防SQL注入的方式应当是在用户输入处使用`mysqli_real_escape_string`，或者使用PDO的预处理查询，或者使用各类ORM框架。



## 混淆加密

这一类加密才刚刚上了加密的道。

在国内用的最多的是[EnPHP](http://enphp.djunny.com/)，开源的有[php-obfusactor](https://github.com/naneau/php-obfuscator)。当然，还有一种更强大的开源加密[yakpro-po](https://github.com/pk-fr/yakpro-po)，笔者猜测，微擎的混淆算法就是基于这个来修改的。它们的基本原理是：

1. 移除代码内的变量，将其替换为乱码或`l1O0`组合成的变量名。因为只改变变量名，大部分情况下并不会对代码的逻辑产生影响。
2. 对PHP代码本身的明文字符串，像是变量名、函数名这些进行替换。
3. 一定程度上改变代码原始逻辑。

这一类加密的开发门槛就相对高些了，需要熟悉对于抽象语法树（AST）的操作。

代码混淆对于一般的防破解来说强度是足够的，Google 在 Android 上即默认提供了 ProGuard 这一明文符号混淆工具，在PHP上同样，如果变量名、函数名等被混淆，确实可以增加破解难度，对应的工具是`php-obfusactor`。不过，这对一般的逆向造不成什么影响，批量替换变量名就可以解决了。`EnPHP`和`yakpro-po`相对会麻烦一些。

`EnPHP`的特征是，将所有的函数名都提取到一个常量池，在一定程度上修改了变量名，不过不改变代码逻辑。

![1597395898865](C:\Users\zzh\AppData\Roaming\Typora\typora-user-images\1597395898865.png)

这种加密实现难度不高，只要熟悉对`php-parser`的操作即可写出来。笔者随手花了十分钟写了一个，分享给大家：

```php
<?php
use PhpParser\Lexer;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitor\Abstract;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

require './vendor/autoload.php';

class ObfuscateCode extends NodeVisitorAbstract
{
    public $mode = 0;
    private $_parser = null
    private $_variableName = '';
    private $_strings = [];
    private $_stringShuffledKeys = [];
    private $_ast;

    public function __construct($parser, $variableName)
    {
        $this->_parser = $parser;
        $this->_variableName = $variableName;
    }

    public static function initialize()
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $variableName = 'O0O0OO00';
        return new ObfuscateCode($parser, $variableName);
    }

    public function obfuscate(string $code)
    {
        $this->getFunctionNames($code);
        $this->shuffleStringKeys();
        $this->getObfuscatedAST($this->_ast);

        $keys = [];
        foreach ($this->_strings as $key => $value) {
            $keys[$value] = $key;
        }

        $prettyPrinter = new Standard();
        $text = $prettyPrinter->prettyPrint($this->_ast);
        $text = '$' . $this->_variableName . '=' . var_export($keys, true) . ';' . $text;
        return $text;
    }

    public function enterNode(Node $node)
    {
        return $node;
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof NodeExprFuncCall || $node instanceof NodeExprMethodCall) {
            if ($node->name instanceof NodeName) {
                if ($this->mode === 0) {
                    $name = $node->name->toString();
                    if (!isset($this->_strings[$name])) {
                        $this->_strings[$name] = 1;
                    }
                } else if ($this->mode === 1) {
                    $name = $node->name->toString();
                    if (isset($this->_strings[$name])) {
                        $node->name = new ExprArrayDimFetch(
                            new ExprVariable($this->_variableName),
                            NodeScalarLNumber::fromString($this->_strings[$name])
                        );
                    }
                }
            }
        }

        if ($node instanceof NodeScalarString_) {
            if ($this->mode === 0) {
                $name = $node->value;
                if (!isset($this->_strings[$name]) && strlen($name) > 1) {
                    $this->_strings[$name] = 1;
                }
            } else if ($this->mode === 1) {
                $name = $node->value;
                if (isset($this->_strings[$name])) {
                    return new ExprArrayDimFetch(
                        new ExprVariable($this->_variableName),
                        NodeScalarLNumber::fromString($this->_strings[$name])
                    );
                }
            }
        }

        return $node;
    }

    private function getFunctionNames(string $code)
    {
        $traverser = new NodeTraverser();
        $this->_ast = $this->_parser->parse('<?php ' . $code);
        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor($this);
        $traverser->traverse($this->_ast);
        return $this->_strings;
    }

    private function shuffleStringKeys()
    {
        $this->_stringShuffledKeys = array_keys($this->_strings);
        shuffle($this->_stringShuffledKeys);
        foreach ($this->_stringShuffledKeys as $key => $value) {
            $this->_strings[$value] = $key;
        }
    }

    private function getObfuscatedAST($ast)
    {
        $this->mode = 1;
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor($this);
        $this->_ast = $traverser->traverse($ast);
    }
}


$a = ObfuscateCode::initialize();
echo $a->obfuscate('var_dump(base64_encode("123456"));echo "test";');
```

至于破解，反向操作即可。分享一个52pojie上的破解教程和一键破解脚本：https://www.52pojie.cn/thread-883976-1-1.html

`yakpro-po`的特征是大量的goto混淆，如图所示。

![1597395937873](C:\Users\zzh\AppData\Roaming\Typora\typora-user-images\1597395937873.png)

这种混淆器的特点如下：

1. 正常语句，将被混淆成`labelxxx: one_line; goto nextlabel;`。直接将这三条语句视为一个混淆节点即可。
2. if / if else / if elseif else，处理差别不大，直接还原即可。
3. 嵌套型 if 相对比较麻烦，因为没有嵌套 if 的概念，一切 if 均在最外层。简单的处理方案是，如果跳到的节点有 if 语法，重新递归解析这个节点。

关于该混淆器网络上没有开源的解混淆方案，因此笔者也贴不出链接。只是笔者认为对于混淆类加密，万变不离其宗，基本上只需要通过简单的AST操作即可还原其原始代码（变量名可能被破坏）。不过出于防君子不防小人的目的，这一类加密已经足够日常使用。



## 无扩展虚拟机加密

目前市面上无扩展的虚拟机加密只有两款，且收费均不菲：

1. Discuz应用中心开发的魔方加密：[https://www.mfenc.com](https://www.mfenc.com/)
2. Z-Blog团队开发的Z5加密：[https://z5encrypt.com](https://z5encrypt.com/)

这两款加密的共同特点是：它们都实现了一个PHP语言的编译器，将PHP转换为它们的内部代码；用户将收到一个解释器，解释器的作用是根据内部代码来执行对应的指令。这就像写C语言一样，编译器负责把C语言写的代码转换为机器码，这种机器码CPU可以直接执行。

这种加密方式，在Windows / Linux上已经很成熟了，代表作品是VMProtect。这种运行方式已经在理论上证明了反编译出源码是不可能的，相对来说也是无扩展加密中最安全的。安全的同时也需要付出一定的代价，它们的运行效率也是最低的。

尽管如此，它们也不是百分百安全。虽然不能反编译出源码，但是可以根据它们的执行逻辑转写出功能类似的代码。魔方加密仅有一层虚拟机，缺少调试对抗策略，导致现在已经有了比较成熟的一键反编译方案：

魔方一代加密破解：https://www.52pojie.cn/thread-695189-1-1.html

魔方二代加密破解：https://www.52pojie.cn/thread-770762-1-1.html

Z5加密的作者似乎在这之上改进了不少，笔者登陆其官网，发现其有如下功能：

1. 增加垃圾代码、扁平化控制流、指令膨胀。
2. 明文字符串加密、常量池。
3. 虚拟机共享、反调试。

Z5加密的破解极为麻烦，笔者对PHP引擎进行了大量修改，包括`zend_compile_string`、`zend_execute`、`microtime`、`php_sapi_name`等一系列函数，花了几天时间才勉强读懂这款加密的执行逻辑。其官网声称让“破解的成本要远高于购买您的程序的成本”，笔者还是比较认同的。



## 近似加密

这其实不属于加密，而是利用PHP自身功能来达到类似加密的效果。PHP在5.5之后自带OPcache，而5.5之前有Zend Optimizer。而已经停止开发的`Zend Guard`、老版本`ionCube`和部分配置下的`Swoole Compiler`，即是基于这一些系统功能进行加密。

PHP通常在Zend引擎上运行，Zend引擎会先将PHP编译为OPcode，OPcache的原理就是缓存了这些OPcode避免下一次运行时仍然产生编译开销。当然，OPcache也是人类不可直接读的。按照PHP官网所说：

> OPcache 通过将 PHP 脚本预编译的字节码存储到共享内存中来提升 PHP 的性能， 存储预编译字节码的好处就是 省去了每次加载和解析 PHP 脚本的开销。
>
> PHP 5.5.0 及后续版本中已经绑定了 OPcache 扩展。 对于 PHP 5.2，5.3 和 5.4 版本可以使用 [» PECL](https://pecl.php.net/package/ZendOpcache) 扩展中的 OPcache 库。

Zend Guard和部分情况下的Swoole Compiler的原理与之相同，即直接将OPcode塞入Zend引擎。

Zend Guard已经被Dezend等工具解密，开源解密工具见：https://github.com/Tools2/Zend-Decoder

对于PHP 5.5+的OPcache的读取和解析，可以参考这一篇文章的后半部分：[https://blog.zsxsoft.com/post/36。他使用VLD扩展来解析OPcache。](https://blog.zsxsoft.com/post/36)



## 扩展加密

笔者这里所说的扩展不是`php-beast`、`php_screw`这一类扩展，前文已经指出，它们根本不配被称之为“加密”。笔者认为，`Swoole Compiler`、`SG11`、高版本`ionCube`这一类扩展才配被称之为加密。

Swoole Compiler团队的郭新华曾经分享了Swoole Compile的加密过程，可以搜索得到他们的PPT：https://myslide.cn/slides/9137?vertical=1。截至目前，似乎没有公开的Swoole Compiler的破解网站。笔者没有Swoole Compiler的样本，如果他们真的如PPT所述实现，那么可以说这是最强的有扩展加密。

根据PPT所述，他们的加密过程包括：

1. 剔除注释、混淆局部变量。
2. 编译优化、内联函数和指令、花指令。
3. 增加垃圾代码、扁平化控制流。
4. 明文字符串加密。
5. 基于LLVM编译成LLVM Bytecode。

分发给用户的扩展还包括：

1. 内置函数名替换（参考zhaoyuanma的破解：https://www.zhaoyuanma.com/article/48.html）。
2. OPCode混淆，仅保留Handler。
3. 反调试、防篡改、加壳。

SG11目前没有公开资料，解密的市场价大约200-300元/文件，笔者目前也没有SG11加密过的样本，只能简单分析SG11 Loader。笔者猜测可以从`zend_execute`内直接拿出所有的Bytecode来跳过OPCode解密流程。



![1597396003364](C:\Users\zzh\AppData\Roaming\Typora\typora-user-images\1597396003364.png)

之后找到每个OPCode执行的Handler，在这个Handler里应该包括二次解密的流程，再往下笔者就不再探究了。

![1597396023075](C:\Users\zzh\AppData\Roaming\Typora\typora-user-images\1597396023075.png)

## 文末

就目前而言，这些加密拥有足够的强度，值得推荐：

[php-obfusactor](https://github.com/naneau/php-obfuscator) ：开源免费，混淆型免扩展加密，较类似Android上的ProGuard。

[yakpro-po](https://github.com/pk-fr/yakpro-po)：开源免费，混淆型免扩展加密，打乱了程序的运行流程。

[Z5加密](https://z5encrypt.com/)：商业，虚拟机型免扩展加密，Z-Blog团队出品。

[Swoole Compiler](https://www.swoole-cloud.com/compiler.html)：商业，有扩展加密，Swoole官方出品。

[Virbox Protector](https://shell.virbox.com/index.html)：商业