## 位运算符

------

首先应该先搞懂各个位运算符的作用。 

| 例子           | 名称                | 结果                                                     |
| :------------- | :------------------ | :------------------------------------------------------- |
| **\$a & \$b**  | And（按位与）       | 将把 $a 和 $b 中都为 1 的位设为 1。                      |
| **\$a \| ​\$b** | Or（按位或）        | 将把 $a 和 $b 中任何一个为 1 的位设为 1。                |
| **\$a ^ ​\$b**  | Xor（按位异或）     | 将把 $a 和 $b 中一个为 1 另一个为 0 的位设为 1。         |
| **~ $a**       | Not（按位取反）     | 将 $a 中为 0 的位设为 1，反之亦然。                      |
| **\$a << $b**  | Shift left（左移）  | 将 $a 中的位向左移动 $b 次（每一次移动都表示“乘以 2”）。 |
| **\$a >> \$b** | Shift right（右移） | 将 $a 中的位向右移动 $b 次（每一次移动都表示“除以 2”）。 |

## 平常开发需要用位运算吗？

> 注：以下所有说到第几位都是从 0 位开始数，所有 2 进制都是抹去了高位为 0 的位只保留了用于对比的那几位。

```php
之前我一直以为对我平常开发来说我并不需要用到位运算符，我觉得这东西需要做很复杂的操作才会用到。
但是在我用了很多次 json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) 
这个函数以后，我开始好奇为什么只用一个参数就可以控制 json 字符串输出的两个设置，既能格式化输出还能不把内容编码成 \uXXXX 可以更直观的看到中文是什么内容。

于是我分别打印了 JSON_UNESCAPED_UNICODE 和 JSON_PRETTY_PRINT 的值，他们分别是 256 和 128，开始十进制开不出个所以然。于是我对比了他们的二级制值。

```

| 常量                                       | 二进制数值  | 10 进制数值 |
| ------------------------------------------ | ----------- | ----------- |
| JSON_UNESCAPED_UNICODE                     | 0b100000000 | 256         |
| JSON_PRETTY_PRINT                          | 0b010000000 | 128         |
| SON_UNESCAPED_UNICODE \| JSON_PRETTY_PRINT | 0b110000000 | 384         |

```php
可以看到从右往左数 256 第 8 位是 1，而 128 第七位是 1，通过按位或运算以后 7 位和 8 位都成了 1。那函数内部就可以只需要判断 json_encode 的第二个参数的二级制数第 8 位如果是 1 就是 JSON_UNESCAPED_UNICODE 为真，第 7 位如果是 1 就是 JSON_PRETTY_PRINT 为真了。

于是我又回想了还有哪个地方用了位操作符，一下又想起了这个函数 error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE)，对比下二进制值。
```

>注意一下 `E_ALL` 在 5.4.x 版本以后为 32767，早期版本为 30719。下面的举例假设 PHP >= 5.4.x

| 常量                         | 二进制数值        | 10 进制数值 |
| ---------------------------- | ----------------- | ----------- |
| E_ALL                        | 0b111111111111111 | 32767       |
| E_WARNING                    | 0b000000000000010 | 2           |
| E_NOTICE                     | 0b000000000001000 | 8           |
| E_ALL ^ E_WARNING ^ E_NOTICE | 0b111111111110101 | 32757       |

竖着直观的看下，运算以后第 1 位和第 3 位变为 0 了，也就是说 E_WARNING、E_NOTICE 被排除掉了。

## 很酷，一定要用！

到此忽然觉得这玩意儿太酷了，试想一下。比方说我现在要实现一个函数来初始化我家里的灯的开关状态。

错误示范
控制灯还不简单嘛，声明一个函数，一个参数控制一个开关。

```php
<?php
function showLight($masterRoom = 0, $livingRoom = 0, $diningRoom = 0, $secondLie = 0, $kitchen = 0) {
    echo '主卧', "\t";
    echo '客厅', "\t";
    echo '餐厅', "\t";
    echo '次卧', "\t";
    echo '厨房', "\t", PHP_EOL;

    echo $masterRoom, "\t";
    echo $livingRoom, "\t";
    echo $diningRoom, "\t";
    echo $secondLie, "\t";
    echo $kitchen, "\t";
    echo PHP_EOL;
}

//只开主卧灯
showLight(1);
//只开厨房灯
showLight(0, 0, 0, 0, 1);
//开所有灯
showLight(1, 1, 1, 1, 1);
```



可以看到我当我需要控制厨房灯的时候却要传其它四个参数，太不科学了，要是能要开哪个就传那个参数就好了。
用哪个传那个参数？用数组参数不就行了？



```php
<?php
function showLight(array $control)
{
    $control = array_merge([
        'masterRoom' => 0,
        'livingRoom' => 0,
        'diningRoom' => 0,
        'secondLie'  => 0,
        'kitchen'    => 0,
    ], $control);

    echo '主卧', "\t";
    echo '客厅', "\t";
    echo '餐厅', "\t";
    echo '次卧', "\t";
    echo '厨房', "\t", PHP_EOL;

    echo $control['masterRoom'], "\t";
    echo $control['livingRoom'], "\t";
    echo $control['diningRoom'], "\t";
    echo $control['secondLie'], "\t";
    echo $control['kitchen'], "\t";
    echo PHP_EOL;
}

//只开主卧和厨房
showLight(['masterRoom' => 1, 'kitchen' => 1]);

嗯，选择开启了。那我要排除厨房呢？
showLight(['masterRoom' => 1, 'kitchen' => 0, 'livingRoom' => 1, 'diningRoom' => 1, 'secondLie' => 1])，又得输入全部参数了。
我现在还只有 5 盏灯，要是我是要控制一栋楼的所有灯只排除某一盏灯呢？我去......
```



### 再来看看用了位操作以后

先声明一个灯光控制的类，用 5 个位来表示 5 盏灯的开关为 1 则表示开灯。

```php
<?php

class LightControl
{
    const TURN_ON_ALL = 0b11111;
    const KITCHEN     = 0b10000;
    const SECOND_LIE  = 0b01000;
    const DINING_ROOM = 0b00100;
    const LIVING_ROOM = 0b00010;
    const MASTER_ROOM = 0b00001;

    private $options;

    public function __construct($options = 0)
    {
        $this->options = $options;
        echo '主卧', "\t";
        echo '客厅', "\t";
        echo '餐厅', "\t";
        echo '次卧', "\t";
        echo '厨房', "\t", PHP_EOL;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function showOptions()
    {
        echo self::getOption($this->options, self::MASTER_ROOM), "\t";
        echo self::getOption($this->options, self::LIVING_ROOM), "\t";
        echo self::getOption($this->options, self::DINING_ROOM), "\t";
        echo self::getOption($this->options, self::SECOND_LIE), "\t";
        echo self::getOption($this->options, self::KITCHEN);
    }

    //获取指定灯的开关状态
    private static function getOption($options, $option)
    {
        return intval(($options & $option) > 0);
    }
}
//LightControl.php


我们来看看 getOption 这个方法。因为我们用了五个位来表示每盏灯的开关状态。
可以看到从右边左数 0-4 位分别是 1 的是 MASTER_ROOM 主卧灯、LIVING_ROOM 客厅、DINING_ROOM 餐厅、SECOND_LIE 次卧、KITCHEN 厨房。
所以我们只需要一个方法来获取 $options 指定位上是否为 1 就可以确定开关的状态了。
因为 $option 一定只有个位上是 1 其它的都是 0，所以 $options 和 $option 按位与以后如果他们的值大于 0 的话，它们肯定有一个相同的位都为 1，也就是 $option 的那个位上。

举个例子：

0b11111 $options 5个位上都是1
0b10000 KITCHEN
0b10000 $options & KITCHEN
```



可以看到 `0b10000` 是一定大于 0 的。

- 全部关闭

```php
<?php
$lightControl = new LightControl();
$lightControl->showOptions();
```

输出结果：

```php
主卧  客厅  餐厅  次卧  厨房  
 0    0    0     0     0
```

- 全部打开

```php
<?php
$lightControl = new LightControl(LightControl::TURN_ON_ALL);
$lightControl->showOptions();
```

- 输出结果：

```php
主卧  客厅  餐厅  次卧  厨房  
1   1   1   1   1
```

- 排除厨房

```php
<?php
$lightControl = new LightControl(LightControl::TURN_ON_ALL ^ LightControl::KITCHEN);
$lightControl->showOptions();

```

- 输出结果：

```php
主卧  客厅  餐厅  次卧  厨房  
1   1   1   1   0
```

| 常量                                              | 二进制数值 |
| ------------------------------------------------- | ---------- |
| LightControl::TURN_ON_ALL                         | 0b11111    |
| LightControl::KITCHEN                             | 0b10000    |
| LightControl::TURN_ON_ALL ^ LightControl::KITCHEN | 0b01111    |

```
LightControl::TURN_ON_ALL ^ LightControl::KITCHEN 的值为 0b01111 除了第 4 位（也就是厨房灯）其它都是 1，成功排除厨房。
```

- 厨房和餐厅

```php
<?php
$lightControl = new LightControl(LightControl::KITCHEN | LightControl::DINING_ROOM);
$lightControl->showOptions();
```

输出结果：

```
主卧  客厅  餐厅  次卧  厨房  
0   0   1   0   1
```

| 常量                                               | 二进制数值 |
| -------------------------------------------------- | ---------- |
| LightControl::KITCHEN                              | 0b10000    |
| LightControl::DINING_ROOM                          | 0b00100    |
| LightControl::KITCHEN \| LightControl::DINING_ROOM | 0b10100    |

```
LightControl::KITCHEN | LightControl::DINING_ROOM 的值为 0b10100，第 2、4 位（也就是厨房灯、客厅灯）都是 1，选择打开了厨房灯、客厅灯。

可以看到用位操作以后可以灵活的控制灯了，如果要开的灯太多可以用排除法，要开的少可以用选择法。
```

## 总结

------

当需要用一个参数来控制众多只有 true、false 选项的时候可以考虑用到位运算来实现，可以用来简化参数的传递并且更为灵活。