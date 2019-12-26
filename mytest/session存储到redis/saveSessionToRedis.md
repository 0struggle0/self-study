### 把session生成的文件存到redis

当我们的系统开启了session

- 应用场景一：当遇到大并发的时候，不可避免的会在服务器上存储有大量的session文件，默认的session方式为文件，而大量小文件的查找效率是很低的，肯定会影响系统性能，所以必须设置session的管理方式，常用的为redis。
- 应用场景二：如果系统是分布式的服务器集群，要解决session共享时，也需要将session存储到数据库或者缓存服务器中，通常存在redis。



![1](D:\xampp\htdocs\mytest\Git\self-study\mytest\session存储到redis\1.png)

session.save_handler 定义存储和获取与会话关联的数据的处理器的名字。默认为 files（文件存储）。

session.save_path则定义了存储的具体路径。

save_handler管理session的方式有多种，除了上面说到的文件存储之外，还可以有数据库存储（user），通过自己实现在数据库的表里面对session增删改查，然后注入到函数session_set_save_handler当中

```php
如果需要用到Redis存储Session（需要安装phpredis扩展）
方法一：修改 php.ini 的设置; 
//可以在php.ini中做如下配置后重启服务：
session.save_handler = redis
session.save_path = "tcp://127.0.0.1:6379"
方式二：通过 ini_set() 函数设置; 
//如果需要在不同的项目里面控制不同的Session存储方式，可以对应在项目公用文件中做如下配置：
ini_set("session.save_handler", "redis");
ini_set("session.save_path", "tcp://127.0.0.1:6379");
//如果配置文件 /etc/redis.conf 里设置了连接密码，保存 session 的时候会报错，save_path 这样写 tcp://127.0.0.1:6379?auth=连接密码 即可。
```

```php
<?php
//测试代码
// 如果未修改php.ini下面两行注释去掉
// ini_set('session.save_handler', 'redis');
// ini_set('session.save_path', 'tcp://127.0.0.1:6379');
 
session_start();
$_SESSION['sessionid'] = 'this is session content!';
echo $_SESSION['sessionid'];
echo '<br/>';
 
$redis = new redis();
$redis->connect('127.0.0.1', 6379);
 
// redis 用 session_id 作为 key 并且是以 string 的形式存储
echo $redis->get('PHPREDIS_SESSION:' . session_id());
```



![2](D:\xampp\htdocs\mytest\Git\self-study\mytest\session存储到redis\2.png)

### 不需要修改配置文件。

```php
//SessionService.php
<?php

class SessionService
{
    public $redis;
    public $sessionExpire = 30;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', '6379');

        // 设置session回调
        session_set_save_handler(
            [$this, 'open'],
            [$this, 'close'],
            [$this, 'read'],
            [$this, 'write'],
            [$this, 'destroy'],
            [$this, 'gc']
		);

        // 开启session
        session_start();
    }

    /**
     * 打开会话时被调用
     * @param $savePath
     * @param $sessionName
     * @return bool
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * 关闭会话时被调用
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * 读取会话数据时被调用
     * @param $sessionId
     * @return bool|string
     */
    public function read($sessionId)
    {
        $data = $this->redis->get($sessionId);
        if ($data) {
            return $data;
        } else {
            return '';
        }
    }

    /**
     * 写入会话数据时被调用
     * @param $sessionId
     * @param $data
     * @return bool
     */
    public function write($sessionId, $data)
    {
        if ($this->redis->setex($sessionId, $this->sessionExpire, $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 销毁会话时被调用
     * @param $sessionId
     * @return bool
     */
    public function destroy($sessionId)
    {
        if ($this->redis->delete($sessionId)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * php执行会话清理算法时会被调用，调用周期由 session.gc_probability 和 session.gc_divisor 参数控制
     * 当算法触发了清理事件，就会去调用destroy方法。
     * @param $lifetime
     * @return bool
     */
    public function gc($lifetime)
    {
        return true;
    }

    public function __destruct()
    {
        session_write_close();
    }
}

```



```php
//session_set.php
<?php

require_once('SessionService.php');

new SessionService();

$_SESSION['username'] = 'rao';

```

```php
//session_get.php

<?php

require_once('SessionService.php');

new SessionService();

echo $_SESSION['username'];

```

```php
//测试代码
http://192.168.10.200/session_set.php
http://192.168.10.200/session_get.php

PHP官方对于session配置的定义：
http://php.net/manual/zh/function.session-set-save-handler.php
```

