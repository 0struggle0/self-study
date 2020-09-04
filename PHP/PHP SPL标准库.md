一.什么是SPL？

　　　　SPL是用于解决典型问题(standard problems)的一组接口与类的集合。

　　　　SPL，PHP 标准库（Standard PHP Library） ，从 PHP 5.0 起内置的组件和接口，且从 PHP5.3 已逐渐的成熟。SPL 在所有的 PHP5 开发环境中被内置，同时无需任何设置。

　　二.如何使用？

　　　　SPL提供了一组标准数据结构：

　　　　双向链表

- - SplDoublyLinkedList
    - [SplStack](http://php.net/manual/zh/class.splstack.php)
    - [SplQueue](http://php.net/manual/zh/class.splqueue.php)

　　　　双链表是一种重要的线性存储结构，对于双链表中的每个节点，不仅仅存储自己的信息，还要保存前驱和后继节点的地址。

　　　　PHP SPL中的SplDoublyLinkedList类提供了对双链表的操作。

　　　　SplDoublyLinkedList类摘要如下：

```php
SplDoublyLinkedList implements Iterator  , ArrayAccess  , Countable  {

  public __construct ( void )
  public void add ( mixed $index , mixed $newval )
  //双链表的头部节点
  public mixed top ( void )
  //双链表的尾部节点
  public mixed bottom ( void )
  //双联表元素的个数
  public int count ( void )
  //检测双链表是否为空
  public bool isEmpty ( void )


  //当前节点索引
  public mixed key ( void )
  //移到上条记录
  public void prev ( void )
  //移到下条记录
  public void next ( void )
  //当前记录
  public mixed current ( void )
  //将指针指向迭代开始处
  public void rewind ( void )
  //检查双链表是否还有节点
  public bool valid ( void )

  //指定index处节点是否存在
  public bool offsetExists ( mixed $index )
  //获取指定index处节点值
  public mixed offsetGet ( mixed $index )
  //设置指定index处值
  public void offsetSet ( mixed $index , mixed $newval )
  //删除指定index处节点
  public void offsetUnset ( mixed $index )

  //从双链表的尾部弹出元素
  public mixed pop ( void )
  //添加元素到双链表的尾部
  public void push ( mixed $value )

  //序列化存储
  public string serialize ( void )
  //反序列化
  public void unserialize ( string $serialized )

  //设置迭代模式
  public void setIteratorMode ( int $mode )
  //获取迭代模式SplDoublyLinkedList::IT_MODE_LIFO (Stack style) SplDoublyLinkedList::IT_MODE_FIFO (Queue style)
  public int getIteratorMode ( void )

  //双链表的头部移除元素
  public mixed shift ( void )
  //双链表的头部添加元素
  public void unshift ( mixed $value )

}
```

使用起来也比较简单

```php
$list = new SplDoublyLinkedList();
$list->push('a');
$list->push('b');
$list->push('c');
$list->push('d');

$list->unshift('top');
$list->shift();

$list->rewind();//rewind操作用于把节点指针指向Bottom所在的节点
echo 'curren node:'.$list->current()."<br />";//获取当前节点

$list->next();//指针指向下一个节点
echo 'next node:'.$list->current()."<br />";

$list->next();
$list->next();
$list->prev();//指针指向上一个节点
echo 'next node:'.$list->current()."<br />";

if($list->current())
    echo 'current node is valid<br />';
else
    echo 'current node is invalid<br />';


if($list->valid())//如果当前节点是有效节点，valid返回true
    echo "valid list<br />";
else
    echo "invalid list <br />";


var_dump(array(
    'pop' => $list->pop(),
    'count' => $list->count(),
    'isEmpty' => $list->isEmpty(),
    'bottom' => $list->bottom(),
    'top' => $list->top()
));

$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
var_dump($list->getIteratorMode());

for($list->rewind(); $list->valid(); $list->next()) {
    echo $list->current().PHP_EOL;
}

var_dump($a = $list->serialize());
//print_r($list->unserialize($a));

$list->offsetSet(0,'new one');
$list->offsetUnset(0);
var_dump(array(
    'offsetExists' => $list->offsetExists(4),
    'offsetGet' => $list->offsetGet(0),

));
var_dump($list);

//堆栈，先进后出
$stack = new SplStack();//继承自SplDoublyLinkedList类

$stack->push("a<br />");
$stack->push("b<br />");

echo $stack->pop();
echo $stack->pop();
echo $stack->offsetSet(0,'B');//堆栈的offset=0是Top所在的位置，offset=1是Top位置节点靠近bottom位置的相邻节点，以此类推
$stack->rewind();//双向链表的rewind和堆栈的rewind相反，堆栈的rewind使得当前指针指向Top所在的位置，而双向链表调用之后指向bottom所在位置
echo 'current:'.$stack->current().'<br />';

$stack->next();//堆栈的next操作使指针指向靠近bottom位置的下一个节点，而双向链表是靠近top的下一个节点
echo 'current:'.$stack->current().'<br />';
echo '<br /><br />';

//队列，先进先出
$queue = new SplQueue();//继承自SplDoublyLinkedList类

$queue->enqueue("a<br />");//插入一个节点到队列里面的Top位置
$queue->enqueue("b<br />");

$queue->offsetSet(0,'A');//堆栈的offset=0是Top所在的位置，offset=1是Top位置节点靠近bottom位置的相邻节点，以此类推

echo $queue->dequeue();
echo $queue->dequeue();

echo "<br /><br />";
```

　堆

- - SplHeap
    - [SplMaxHeap](http://php.net/manual/zh/class.splmaxheap.php)
    - [SplMinHeap](http://php.net/manual/zh/class.splminheap.php)

　　　　堆(Heap)就是为了实现优先队列而设计的一种数据结构，它是通过构造二叉堆(二叉树的一种)实现。根节点最大的堆叫做最大堆或大根堆（SplMaxHeap），根节点最小的堆叫做最小堆或小根堆（SplMinHeap）。二叉堆还常用于排序(堆排序)。

　　　　SplHeap类摘要如下：

```php
abstract SplHeap implements Iterator , Countable {
　　/* 方法 */
　　public __construct ( void )
　　abstract protected int compare ( mixed $value1 , mixed $value2 )
　　public int count ( void )
　　public mixed current ( void )
　　public mixed extract ( void )
　　public void insert ( mixed $value )
　　public bool isEmpty ( void )
　　public mixed key ( void )
　　public void next ( void )
　　public void recoverFromCorruption ( void )
　　public void rewind ( void )
　　public mixed top ( void )
　　public bool valid ( void )
}
```

显然它是一个抽象类，最大堆([SplMaxHeap](http://php.net/manual/zh/class.splmaxheap.php))和最小堆([SplMinHeap](http://php.net/manual/en/class.splminheap.php))就是继承它实现的。最大堆和最小堆并没有额外的方法。

SplHeap简单使用：

```php
//堆
class MySplHeap extends SplHeap{
    //compare()方法用来比较两个元素的大小，绝对他们在堆中的位置
    public function compare( $value1, $value2 ) {
        return ( $value1 - $value2 );
    }
}

$obj = new MySplHeap();

$obj->insert(0);
$obj->insert(1);
$obj->insert(2);
$obj->insert(3);
$obj->insert(4);

echo $obj->top();//4
echo $obj->count();//5

foreach ($obj as $item) {
    echo $item."<br />";
}
```

队列

- - [SplPriorityQueue](http://php.net/manual/zh/class.splpriorityqueue.php)

优先队列也是非常实用的一种数据结构，可以通过加权对值进行排序，由于排序在php内部实现，业务代码中将精简不少而且更高效。通过SplPriorityQueue::setExtractFlags(int  $flag)设置提取方式可以提取数据（等同最大堆）、优先级、和两者都提取的方式。

　　　　SplPriorityQueue类摘要如下：

```php
SplPriorityQueue implements Iterator , Countable {
　　/* 方法 */
　　public __construct ( void )
　　public int compare ( mixed $priority1 , mixed $priority2 )
　　public int count ( void )
　　public mixed current ( void )
　　public mixed extract ( void )
　　public void insert ( mixed $value , mixed $priority )
　　public bool isEmpty ( void )
　　public mixed key ( void )
　　public void next ( void )
　　public void recoverFromCorruption ( void )
　　public void rewind ( void )
　　public void setExtractFlags ( int $flags )
　　public mixed top ( void )
　　public bool valid ( void )
}
```

简单使用：

```php
$pq = new SplPriorityQueue();

$pq->insert('a', 10);
$pq->insert('b', 1);
$pq->insert('c', 8);

echo $pq->count() .PHP_EOL; //3
echo $pq->current() . PHP_EOL; //a

/**
 * 设置元素出队模式
 * SplPriorityQueue::EXTR_DATA 仅提取值
 * SplPriorityQueue::EXTR_PRIORITY 仅提取优先级
 * SplPriorityQueue::EXTR_BOTH 提取数组包含值和优先级
 */
$pq->setExtractFlags(SplPriorityQueue::EXTR_DATA);

while($pq->valid()) {
    print_r($pq->current());  //a  c  b
    $pq->next();
}
```

阵列

- - [SplFixedArray](http://php.net/manual/zh/class.splfixedarray.php)

SplFixedArray主要是处理数组相关的主要功能，与普通php array不同的是，它是固定长度的，且以数字为键名的数组，优势就是比普通的数组处理更快。通常情况下SplFixedArray要比php array快上20%~30%，所以如果你是处理巨大数量的固定长度数组，还是强烈建议使用。

SplFixedArray类摘要如下：

```php
SplFixedArray implements Iterator , ArrayAccess , Countable {
　　/* 方法 */
　　public __construct ([ int $size = 0 ] )
　　public int count ( void )
　　public mixed current ( void )
　　public static SplFixedArray fromArray ( array $array [, bool $save_indexes = true ] )
　　public int getSize ( void )
　　public int key ( void )
　　public void next ( void )
　　public bool offsetExists ( int $index )
　　public mixed offsetGet ( int $index )
　　public void offsetSet ( int $index , mixed $newval )
　　public void offsetUnset ( int $index )
　　public void rewind ( void )
　　public int setSize ( int $size )
　　public array toArray ( void )
　　public bool valid ( void )
　　public void __wakeup ( void )
}
```

简单使用：

```php
$arr = new SplFixedArray(4);
$arr[0] = 'php';
$arr[1] = 1;
$arr[3] = 'python';

//遍历， $arr[2] 为null
foreach($arr as $v) {
    echo $v . PHP_EOL;
}

//获取数组长度
echo $arr->getSize(); //4

//增加数组长度
$arr->setSize(5);
$arr[4] = 'new one';

//捕获异常
try{
    echo $arr[10];
} catch (RuntimeException $e) {
    echo $e->getMessage();
}
```

映射

- - [SplObjectStorage](http://php.net/manual/zh/class.splobjectstorage.php)

用来存储一组对象的，特别是当你需要唯一标识对象的时候。

PHP SPL SplObjectStorage类实现了[Countable,Iterator,Serializable,ArrayAccess四个接口](http://www.phpddt.com/php/php-interfaces.html)。可实现统计、迭代、序列化、数组式访问等功能。

SplObjectStorage类摘要如下：

```php
SplObjectStorage implements Countable , Iterator , Serializable , ArrayAccess {
　　/* 方法 */
　　public void addAll ( SplObjectStorage $storage )
　　public void attach ( object $object [, mixed $data = NULL ] )
　　public bool contains ( object $object )
　　public int count ( void )
　　public object current ( void )
　　public void detach ( object $object )
　　public string getHash ( object $object )
　　public mixed getInfo ( void )
　　public int key ( void )
　　public void next ( void )
　　public bool offsetExists ( object $object )
　　public mixed offsetGet ( object $object )
　　public void offsetSet ( object $object [, mixed $data = NULL ] )
　　public void offsetUnset ( object $object )
　　public void removeAll ( SplObjectStorage $storage )
　　public void removeAllExcept ( SplObjectStorage $storage )
　　public void rewind ( void )
　　public string serialize ( void )
　　public void setInfo ( mixed $data )
　　public void unserialize ( string $serialized )
　　public bool valid ( void )
}
```

简单使用：

```php
class A {
    public $i;
    public function __construct($i) {
        $this->i = $i;
    }
}

$a1 = new A(1);
$a2 = new A(2);
$a3 = new A(3);
$a4 = new A(4);

$container = new SplObjectStorage();

//SplObjectStorage::attach 添加对象到Storage中
$container->attach($a1);
$container->attach($a2);
$container->attach($a3);

//SplObjectStorage::detach 将对象从Storage中移除
$container->detach($a2);

//SplObjectStorage::contains用于检查对象是否存在Storage中
var_dump($container->contains($a1)); //true
var_dump($container->contains($a4)); //false

//遍历
$container->rewind();
while($container->valid()) {
    var_dump($container->current());
    $container->next();
}
```

