stdClass是PHP的一个基类，所以任何时候都可以被new，可以让这个变量成为一个object。

同时，这个基类又有一个特殊的地方，就是没有方法。

PHP可以用 $object = new StdClass(); 创建一个没有成员方法和属性的空对象。

很多时候，我们会将一些参数配置项之类的信息放在数组中使用，但是数组有时操作起来并不是很方便，很多时候使用对象操作符->xxx比数组操作符['xxx']要方便不少。

于是就需要创建一个空的对象，来将需要的属性名和属性值存储到对象中。

然而PHP中没有Javascript里面 var object = {}; 这样的语法。

PHP创建空对象至少可以使用3种方法实现
**方法一：写一个空类**
勉强能完成任务，但是特别没有格局。

```php
<?php
        class cfg {                
        }        
        $cfg = new cfg;
        $cfg->dbhost = 'www.51-n.com';
        echo $cfg->dbhost;
?>
```



**方法二：实例化 StdClass 类**
StdClass类是PHP中的一个基类，然而比较诡异的是PHP手册里面血几乎没有提到过这个类，至少在PHP索引中是搜索不到这个类的。
StdClass类没有任何成员方法，也没有任何成员属性，实例化以后就是一个空对象。

```php
<?php
        $cfg = new StdClass();
        $cfg->dbhost = 'www.51-n.com';
        echo $cfg->dbhost;
?>
```



**方法三：折腾json_encode()和json_decode()**
这种方法就是把一个空的JSON对象通过json_decode()转变为PHP的StdClass空对象。
同样的道理，你可以将一个数组通过json_encode()转成JSON，再通过json_decode()将JSON转为StdClass对象。有时候我们调用外部接口的时候，获得的数据格式就是StdClass；这时需要 json_decode添加第二个属性，true，来把StdClass转换为可用的数组结构。

```php
<?php
        $cfg = json_decode('{}');
        $cfg->dbhost = 'www.51-n.com';
        echo $cfg->dbhost;
?>
```



#### 那new stdclass()用在什么场景呢？

1、在返回特定数据类型的时候，使用stdClass，如：

```php
$person
   -> name = "John"
   -> surname = "Miller"
   -> address = "123 Fake St"
```

2、在返回同类型数据的列表时使用Array，如：

```
  "John Miller"
  "Peter Miller"
  "Josh Swanson"
  "Harry Miller"
```

3、在返回特定类型的列表时，stdClass、array并用，如：

```php
 $person[0]
    -> name = "John"
    -> surname = "Miller"
    -> address = "123 Fake St"


  $person[1]
    -> name = "Peter"
    -> surname = "Miller"
    -> address = "345 High St"
```



