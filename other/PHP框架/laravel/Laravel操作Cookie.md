## 设置 Cookie

- 通过 response 设置

  ```php
  public function index()
  {
      //参数格式：$name, $value, $minutes
      // 使用 response() 辅助函数设置
  	return response('设置 Cookie')->cookie('key','value');
      return response('设置 Cookie')->withCookie('cookie','hello');
      
      // 设置多个cookie
      return response('设置 Cookie')->cookie('key', 'value')->cookie('cookie','hello');
      return response('设置 Cookie')->withCookie('key','value')->withCookie('cookie', 'hello');
      
      // 把 Cookie 输出到页面
      return response()->view('admin/index')->cookie($cookie); 
      
      // 通过 response 门面模式设置
      // 需要先引用 use Illuminate\Support\Facades\Response; 类
      return Response::make()->withCookie('key','value')；
      
      // 设置多个cookie
      return Response::make()->withCookie('key','value')->withCookie('cookie', 'hello');
      // 或者
      $keyCookie = Cookie::make('key', 'value', 10);
  	$cookieCookie = Cookie::make('cookie', 'hello', 5);
      // foreverCookie = Cookie::forever('forever', 'value'); // 永不过期
  	return Response::make()->withCookie($keyCookie)->withCookie($cookieCookie);
      
      // Cookie 存储数组
      $info = array('name'=>'123','number'=>'1111');
      $userCookie = Cookie::make('user', $info, 5);
      return Response::make()->withCookie($userCookie);
  }
  ```

- 通过 Cookie 门面方式设置

  ```php
  public function index()
  {
      // 需要先引用 use Illuminate\Support\Facades\Cookie; 类
      Cookie::queue('key','value',60);
      
      // 设置多个 Cookie
      Cookie::queue('name','jack',60);
      Cookie::queue('asdf','654',60);
  }
  ```

  

## 获取 Cookie

- 通过 request 获取

  ```php
  public function index(Request $request)
  {
      // 使用 request() 辅助函数获取
      // 在取不到对应的键值的时候会返回 null ，如果不想返回 null，可以增加第二个参数来设置默认返回值
      $key = request()->cookie('key');  // request()->cookie('test', '');
      dump($key);
      
      // 通过依赖注入的方式获取
      // 需要先引用 use Illuminate\Http\Request; 类
      $key = $request->cookie('key', '');
      dump($key);
      
      // 如果想获得所有Cookie的值，可以使用不传参数的方法
      $cookies = $request->cookie();
      dump($cookies);
  }
  ```

-  通过 Cookie 门面方式获取

  ```php
  public function index()
  {
      // 需要先引用 use Illuminate\Support\Facades\Cookie; 类
      $key = Cookie::get('test');
      dump($key);
  }
  ```

- 判断某个 Cookie 存不存在

  ```php
  Cookie::has('key') 判断在请求头中是否存在某个 Cookie
  ```

  

## 删除 Cookie

**cookie 没有显式的删除方式，只能通过设置过期时间的方式来删除**

```php
public function index()
{
    // 需要先引用 use Illuminate\Support\Facades\Cookie; 类
    // Cookie 必须依附于具体某个请求和响应。所以最终我们需要通过一个响应来改变 Cookie 的过期时间。而第一步则是使其过期，第二步对该过期的 Cookie 进行响应，从而使其失效。
    $cookie = Cookie::forget('name');# 创建过期对象
    return response('删除 cookie')->withCookie($cookie); # 响应
    
    // 可以通过第三个参数设置过期时间(以分钟为单位)
    return response('过期时间')->withCookie('hello', 'world', 3);
}
```



## 明文 or 密文

出于安全考虑， Laravel 默认对所有  cookie  进行加密存储。

但是，我们如果想跟  JS  交互，让 JS 可以直接读取到 Cookie 明文。我们需要在 `app\Http\Middleware\EncryptCookies.php` 中的 $except 数组中将需要明文展示的 Cookie 键名放入数组中，如：

```php
protected $except = [
    'key',
    'cookie'
];
```