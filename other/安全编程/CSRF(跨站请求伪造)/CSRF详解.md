# CSRF详解

### 一、CSRF是什么？

　　CSRF（Cross-site request forgery），中文名称：跨站请求伪造，也被称为：one click attack/session riding，缩写为：CSRF/XSRF。

### 二、CSRF可以做什么？

　　你这可以这么理解CSRF攻击：攻击者盗用了你的身份，以你的名义发送恶意请求。CSRF能够做的事情包括：以你名义发送邮件，发消息，盗取你的账号，甚至于购买商品，虚拟货币转账......造成的问题包括：个人隐私泄露以及财产安全。

### 三、CSRF漏洞现状

　　CSRF这种攻击方式在2000年已经被国外的安全人员提出，但在国内，直到06年才开始被关注，08年，国内外的多个大型社区和交互网站分别 爆出CSRF漏洞，如：NYTimes.com（纽约时报）、Metafilter（一个大型的BLOG网站），YouTube和百度HI......而 现在，互联网上的许多站点仍对此毫无防备，以至于安全业界称CSRF为“沉睡的巨人”。

### 四、CSRF的原理

　　下图简单阐述了CSRF攻击的思想：

![1](D:\htdocs\mytest\Git\self-study\other\安全编程\CSRF(跨站请求伪造)\image\1.jpg)

从上图可以看出，要完成一次CSRF攻击，受害者必须依次完成两个步骤：

　　1.登录受信任网站A，并在本地生成Cookie。

　　2.在不登出A的情况下，访问危险网站B。

　　看到这里，你也许会说：“如果我不满足以上两个条件中的一个，我就不会受到CSRF的攻击”。是的，确实如此，但你不能保证以下情况不会发生：

　　1.你不能保证你登录了一个网站后，不再打开一个tab页面并访问另外的网站。

　　2.你不能保证你关闭浏览器了后，你本地的Cookie立刻过期，你上次的会话已经结束。（事实上，关闭浏览器不能结束一个会话，但大多数人都会错误的认为关闭浏览器就等于退出登录/结束会话了......）

　　3.上图中所谓的攻击网站，可能是一个存在其他漏洞的可信任的经常被人访问的网站。

 

　　上面大概地讲了一下CSRF攻击的思想，下面我将用几个例子详细说说具体的CSRF攻击，这里我以一个银行转账的操作作为例子（仅仅是例子，真实的银行网站没这么傻:>）

　　**示例1：**

　　银行网站A，它以GET请求来完成银行转账的操作，如：

​		`http://www.mybank.com/Transfer.php?toBankId=11&money=1000`

　　危险网站B，它里面有一段HTML的代码如下：

　　`<img src=http://www.mybank.com/Transfer.php?toBankId=11&money=1000>`

　　首先，你登录了银行网站A，然后访问危险网站B，噢，这时你会发现你的银行账户少了1000块......

　　为什么会这样呢？原因是银行网站A违反了HTTP规范，使用GET请求更新资源。在访问危险网站B的之前，你已经登录了银行网站A，而B中 的`<img>`以GET的方式请求第三方资源（这里的第三方就是指银行网站了，原本这是一个合法的请求，但这里被不法分子利用了），所以你的浏 览器会带上你的银行网站A的Cookie发出Get请求，去获取资源`http://www.mybank.com /Transfer.php?toBankId=11&money=1000`，结果银行网站服务器收到请求后，认为这是一个更新资源操作（转账 操作），所以就立刻进行转账操作......

　　**示例2：**

　　为了杜绝上面的问题，银行决定改用POST请求完成转账操作。

　　银行网站A的WEB表单如下：

```html
　　<form action="Transfer.php" method="POST">
　　　　<p>ToBankId: <input type="text" name="toBankId" /></p>
　　　　<p>Money: <input type="text" name="money" /></p>
　　　　<p><input type="submit" value="Transfer" /></p>
　　</form>
```

​		后台处理页面Transfer.php如下：

```php
　<?php
　　　　session_start();
　　　　if (isset($_REQUEST['toBankId'] &&　isset($_REQUEST['money']))
　　　　{
　　　　    buy_stocks($_REQUEST['toBankId'],　$_REQUEST['money']);
　　　　}
　　?>
```

​		危险网站B，仍然只是包含那句HTML代码：

​	`<img src=http://www.mybank.com/Transfer.php?toBankId=11&money=1000>`

　　和示例1中的操作一样，你首先登录了银行网站A，然后访问危险网站B，结果.....和示例1一样，你再次没了1000块～T_T，这次事故的 原因是：银行后台使用了$_REQUEST去获取请求的数据，而$_REQUEST既可以获取GET请求的数据，也可以获取POST请求的数据，这就造成 了在后台处理程序无法区分这到底是GET请求的数据还是POST请求的数据。在PHP中，可以使用$_GET和$_POST分别获取GET请求和POST 请求的数据。在JAVA中，用于获取请求数据request一样存在不能区分GET请求数据和POST数据的问题。

　　**示例3：**

　　经过前面2个惨痛的教训，银行决定把获取请求数据的方法也改了，改用$_POST，只获取POST请求的数据，后台处理页面Transfer.php代码如下：

```php
　<?php
　　　　session_start();
　　　　if (isset($_POST['toBankId'] &&　isset($_POST['money']))
　　　　{
　　　　    buy_stocks($_POST['toBankId'],　$_POST['money']);
　　　　}
　　?>
```

然而，危险网站B与时俱进，它改了一下代码：

```php
<html>
　　<head>
　　　　<script type="text/javascript">
　　　　　　function steal()
　　　　　　{
          　　　　 iframe = document.frames["steal"];
　　     　　      iframe.document.Submit("transfer");
　　　　　　}
　　　　</script>
　　</head>

　　<body onload="steal()">
　　　　<iframe name="steal" display="none">
　　　　　　<form method="POST" name="transfer"　action="http://www.myBank.com/Transfer.php">
　　　　　　　　<input type="hidden" name="toBankId" value="11">
　　　　　　　　<input type="hidden" name="money" value="1000">
　　　　　　</form>
　　　　</iframe>
　　</body>
</html>
```

如果用户仍是继续上面的操作，很不幸，结果将会是再次不见1000块......因为这里危险网站B暗地里发送了POST请求到银行!

　　总结一下上面3个例子，CSRF主要的攻击模式基本上是以上的3种，其中以第1,2种最为严重，因为触发条件很简单，一 个`<img>`就可以了，而第3种比较麻烦，需要使用JavaScript，所以使用的机会会比前面的少很多，但无论是哪种情况，只要触发了 CSRF攻击，后果都有可能很严重。

　　理解上面的3种攻击模式，其实可以看出，CSRF攻击是源于WEB的隐式身份验证机制！WEB的身份验证机制虽然可以保证一个请求是来自于某个用户的浏览器，但却无法保证该请求是用户批准发送的！

**CSRF工具的防御手段**

**1. 尽量使用POST，限制GET**

GET接口太容易被拿来做CSRF攻击，看第一个示例就知道，只要构造一个img标签，而img标签又是不能过滤的数据。接口最好限制为POST使用，GET则无效，降低攻击风险。

当然POST并不是万无一失，攻击者只要构造一个form就可以，但需要在第三方页面做，这样就增加暴露的可能性。

**2. 浏览器Cookie策略**

IE6、7、8、Safari会默认拦截第三方本地Cookie（Third-party Cookie）的发送。但是Firefox2、3、Opera、Chrome、Android等不会拦截，所以通过浏览器Cookie策略来防御CSRF攻击不靠谱，只能说是降低了风险。

PS：Cookie分为两种，Session Cookie（在浏览器关闭后，就会失效，保存到内存里），Third-party Cookie（即只有到了Exprie时间后才会失效的Cookie，这种Cookie会保存到本地）。

PS：另外如果网站返回HTTP头包含P3P Header，那么将允许浏览器发送第三方Cookie。

**3. 加验证码**

验证码，强制用户必须与应用进行交互，才能完成最终请求。在通常情况下，验证码能很好遏制CSRF攻击。但是出于用户体验考虑，网站不能给所有的操作都加上验证码。因此验证码只能作为一种辅助手段，不能作为主要解决方案。

**4. Referer Check**

Referer Check在Web最常见的应用就是“防止图片盗链”。同理，Referer Check也可以被用于检查请求是否来自合法的“源”（Referer值是否是指定页面，或者网站的域），如果都不是，那么就极可能是CSRF攻击。

但是因为服务器并不是什么时候都能取到Referer，所以也无法作为CSRF防御的主要手段。但是用Referer Check来监控CSRF攻击的发生，倒是一种可行的方法。

```php
<?php
// 检查上一页面是否为当前站点下的页面
if (!empty($_SERVER['HTTP_REFERER'])) {
    if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != 'html5.yang.com') {
        // 可以设置http错误码或者指向一个无害的url地址
        //header('HTTP/1.1 404 not found');
        //header('HTTP/1.1 403 forbiden');
        header('Location: http://html5.yang.com/favicon.ico');
        // 这里需要注意一定要exit(), 否则脚本会接着执行
        exit();
    }
 }

$str = file_get_contents('data.json');
// 代码省略
```

但是，这样就万事大吉了吗，如果http请求头被伪造了呢？A站点升级了防御，B站点同时也可以升级攻击，通过curl请求来实现csrf，修改B站点的csrf.php代码如下：

```php
<?php
$url = 'http://html5.yang.com/csrfdemo/get-update.php?uid=101&username=jsonp';
$refer = 'http://html5.yang.com/';
// curl方法发起csrf攻击
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);// 设置Referer
curl_setopt($ch, CURLOPT_REFERER, $refer);
// 这里需要携带上cookie, 因为A站点get-update.php对cooke进行了判断
curl_setopt($ch, CURLOPT_COOKIE, 'uid=101');
curl_exec($ch);
curl_close($ch);
?>
<img src="http://html5.yang.com/csrfdemo/get-update.php?uid=101&username=jsonp">
```

**5. Anti CSRF Token**

CSRF 攻击之所以能够成功，是因为黑客可以完全伪造用户的请求，该请求中所有的用户验证信息都是存在于 cookie 中，因此黑客可以在不知道这些验证信息的情况下直接利用用户自己的 cookie 来通过安全验证。

要抵御 CSRF，关键在于在请求中放入黑客所不能伪造的信息，并且该信息不存在于 cookie 之中。

可以在 HTTP 请求中以参数的形式加入一个随机产生的 token，并在服务器端建立一个拦截器来验证这个 token，如果请求中没有 token 或者 token 内容不正确，则认为可能是 CSRF 攻击而拒绝该请求。

例子：

1. 用户访问某个表单页面。

2. 服务端生成一个Token，放在用户的Session中，或者浏览器的Cookie中。

3. 在页面表单附带上Token参数。

4. 用户提交请求后， 服务端验证表单中的Token是否与用户Session（或Cookies）中的Token一致，一致为合法请求，不是则非法请求。

这个Token的值必须是随机的，不可预测的。由于Token的存在，攻击者无法再构造一个带有合法Token的请求实施CSRF攻击。另外使用Token时应注意Token的保密性，尽量把敏感操作由GET改为POST，以form或AJAX形式提交，避免Token泄露。

**6.  在 HTTP 头中自定义属性并验证 **

这种方法也是使用 token 并进行验证，和上一种方法不同的是，这里并不是把 token 以参数的形式置于 HTTP 请求之中，而是把它放到 HTTP 头中自定义的属性里。通过 XMLHttpRequest 这个类，可以一次性给所有该类请求加上 csrftoken 这个 HTTP 头属性，并把 token 值放入其中。这样解决了上种方法在请求中加入 token 的不便，同时，通过 XMLHttpRequest 请求的地址不会被记录到浏览器的地址栏，也不用担心 token 会透过 Referer 泄露到其他网站中去。

