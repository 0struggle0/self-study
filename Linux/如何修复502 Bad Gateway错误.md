​	502网关错误的最常见原因是请求服务器响应时间太长。此延迟可能是由高流量引起的暂时故障，也可能是由于服务器配置错误，所以发生这种情况。

### 如何修复502 Bad Gateway错误？

当服务器无法找到无响应原因时，通常会导致此错误。我们需要尝试不同的故障排除步骤，直到找到问题为止。下面依次进行排除：

**第1步：重新加载网站**

有时由于流量增加或服务器资源不足，服务器可能需要更长时间才能响应，这种情况可能会在几分钟内自动消失。可以尝试重新加载正在查看的网页，看看是否修复了。如果问题解决了，后面的就可以不用看了。但是，如果这种错误经常发生，就需要继续往下阅读，因为可能还有其他需要修复的内容。

 

**第2步：清除浏览器缓存**

浏览器可能显示的是缓存中的错误页面。即使问题得到解决，也会看到502错误，因为浏览器正在从缓存加载网站。要解决此问题，使用Windows / Linux操作系统的用户可以按Ctrl + F5按钮，Mac OS用户可以按键盘上的CMD + Shift + R按钮刷新页面。也可以从浏览器设置中手动删除缓存。

 

**第3步：检查服务器**

如果上述所有故障排除步骤均失败，则可能是服务器出现问题，就检查服务器配置。

```shell
#php-fpm.conf重要参数详解

pid = run/php-fpm.pid
#pid设置，默认在安装目录中的var/run/php-fpm.pid，建议开启
 
error_log = log/php-fpm.log
#错误日志，默认在安装目录中的var/log/php-fpm.log
 
log_level = notice
#错误级别. 可用级别为: alert（必须立即处理）, error（错误情况）, warning（警告情况）, notice（一般重要信息）, debug（调试信息）. 默认: notice.
 
emergency_restart_threshold = 60
emergency_restart_interval = 60s
#表示在emergency_restart_interval所设值内出现SIGSEGV或者SIGBUS错误的php-cgi进程数如果超过 emergency_restart_threshold个，php-fpm就会优雅重启。这两个选项一般保持默认值。
 
process_control_timeout = 0
#设置子进程接受主进程复用信号的超时时间. 可用单位: s(秒), m(分), h(小时), 或者 d(天) 默认单位: s(秒). 默认值: 0.
 
daemonize = yes
#后台执行fpm,默认值为yes，如果为了调试可以改为no。在FPM中，可以使用不同的设置来运行多个进程池。 这些设置可以针对每个进程池单独设置。
 
listen = 127.0.0.1:9000
#fpm监听端口，即nginx中php处理的地址，一般默认值即可。可用格式为: 'ip:port', 'port', '/path/to/unix/socket'. 每个进程池都需要设置.
 
listen.backlog = -1
#backlog数，-1表示无限制，由操作系统决定，此行注释掉就行。backlog含义参考：http://www.3gyou.cc/?p=41
 
listen.allowed_clients = 127.0.0.1
#允许访问FastCGI进程的IP，设置any为不限制IP，如果要设置其他主机的nginx也能访问这台FPM进程，listen处要设置成本地可被访问的IP。默认值是any。每个地址是用逗号分隔. 如果没有设置或者为空，则允许任何服务器请求连接
 
listen.owner = www
listen.group = www
listen.mode = 0666
#unix socket设置选项，如果使用tcp方式访问，这里注释即可。
 
user = www
group = www
#启动进程的帐户和组
 
pm = dynamic #对于专用服务器，pm可以设置为static。
#如何控制子进程，选项有static和dynamic。如果选择static，则由pm.max_children指定固定的子进程数。如果选择dynamic，则由下开参数决定：
pm.max_children #，子进程最大数
pm.start_servers #，启动时的进程数
pm.min_spare_servers #，保证空闲进程数最小值，如果空闲进程小于此值，则创建新的子进程
pm.max_spare_servers #，保证空闲进程数最大值，如果空闲进程大于此值，此进行清理
 
pm.max_requests = 1000
#设置每个子进程重生之前服务的请求数. 对于可能存在内存泄漏的第三方模块来说是非常有用的. 如果设置为 '0' 则一直接受请求. 等同于 PHP_FCGI_MAX_REQUESTS 环境变量. 默认值: 0.
 
pm.status_path = /status
#FPM状态页面的网址. 如果没有设置, 则无法访问状态页面. 默认值: none. munin监控会使用到
 
ping.path = /ping
#FPM监控页面的ping网址. 如果没有设置, 则无法访问ping页面. 该页面用于外部检测FPM是否存活并且可以响应请求. 请注意必须以斜线开头 (/)。
 
ping.response = pong
#用于定义ping请求的返回相应. 返回为 HTTP 200 的 text/plain 格式文本. 默认值: pong.
 
request_terminate_timeout = 0
#设置单个请求的超时中止时间. 该选项可能会对php.ini设置中的'max_execution_time'因为某些特殊原因没有中止运行的脚本有用. 设置为 '0' 表示 'Off'.当经常出现502错误时可以尝试更改此选项。
 
request_slowlog_timeout = 10s
#当一个请求该设置的超时时间后，就会将对应的PHP调用堆栈信息完整写入到慢日志中. 设置为 '0' 表示 'Off'
 
slowlog = log/$pool.log.slow
#慢请求的记录日志,配合request_slowlog_timeout使用
 
rlimit_files = 1024
#设置文件打开描述符的rlimit限制. 默认值: 系统定义值默认可打开句柄是1024，可使用 ulimit -n查看，ulimit -n 2048修改。
 
rlimit_core = 0
#设置核心rlimit最大限制值. 可用值: 'unlimited' 、0或者正整数. 默认值: 系统定义值.
 
chroot =
#启动时的Chroot目录. 所定义的目录需要是绝对路径. 如果没有设置, 则chroot不被使用.
 
chdir =
#设置启动目录，启动时会自动Chdir到该目录. 所定义的目录需要是绝对路径. 默认值: 当前目录，或者/目录（chroot时）
 
catch_workers_output = yes
#重定向运行过程中的stdout和stderr到主要的错误日志文件中. 如果没有设置, stdout 和 stderr 将会根据FastCGI的规则被重定向到 /dev/null . 默认值: 空.
```



#### 1. nginx等待时间超时

```shell
Nginx代理过程，将业务服务器请求数据缓存到本地文件，再将文件数据转发给请求客户端。高并发的客户端请求，必然要求服务器文件句柄的并发打开限制。

使用ulimit命令（ulimit -n），查看Linux系统文件句柄并发限制，默认是1024，我们可以改为65535（2 的 16 次方，这是系统端口的极限）。
修改的方法为：修改系统文件/etc/security/limits.conf，添加如下信息，并重新启动系统生效。

修改nginx.conf配置参数

部分PHP程序的执行时间超过了Nginx的等待时间，可以适当增加nginx.conf配置文件中FastCGI的timeout时间，例如：

http { 
　　fastcgi_connect_timeout 300; #链接
　　fastcgi_send_timeout 300;  #读取
　　fastcgi_read_timeout 300; # 发请求
}

fastcgi_read_timeout是指fastcgi进程向nginx进程发送response的整个过程的超时时间
fastcgi_send_timeout是指nginx进程向fastcgi进程发送request的整个过程的超时时间
这两个选项默认都是秒(s),可以手动指定为分钟(m),小时(h)等

```



### 2. php问题

````shell
一般是/usr/local/php/etc/php-fpm.conf三个参数(最主要的问题)
pm.max_children #表示 php-fpm 在静态方式下能启动的子进程的最大数量。
pm.start_servers = 20; # 表示 php-fpm 在动态方式下能启动的子进程的最大数量。
pm.min_spare_servers = 5; #动态方式下的最小php-fpm进程数量
pm.max_spare_servers = 35; #动态方式下的最大php-fpm进程数量
pm.max_requests 
request_terminate_timeout # 表示将执行时间太长的进程直接终止。
php-cgi进程数不够用、php执行时间长、或者是php-cgi进程死掉，都会出现502错误。

数值设置，参考自己的实际硬件配置，可以参考 总内存/30M 来计算。
	如果dm设置为static，那么其实只有pm.max_children这个参数生效。系统会开启设置数量的php-fpm进程。
	如果dm设置为dynamic，那么pm.max_children参数失效，后面3个参数生效。系统会在php-fpm运行开始的时候启动pm.start_servers个php-fpm进程，然后根据系统的需求动态在pm.min_spare_servers和pm.max_spare_servers之间调整php-fpm进程数。
	问题：如何判断我选择“pm = dynamic”还是“pm = static”呢？哪一种更好呢？
	事实上，跟Apache一样，运行的PHP程序在执行完成后，或多或少会有内存泄露的问题。
	这也是为什么开始的时候一个php-fpm进程只占用3M左右内存，运行一段时间后就会上升到20-30M的原因了。
	对于内存大的服务器（比如8G以上）来说，用静态的max_children实际上更为妥当，因为这样不需要进行额外的进程数目控制，会提高效率。因为频繁开关php-fpm进程也会有时滞，所以内存够大的情况下开静态效果会更好。数量也可以根据 总内存/30M 得到，比如8GB内存可以设置为100，那么php-fpm耗费的内存就能控制在 2G-3G的样子。
	如果内存稍微小点，比如1~2G，那么指定静态的进程数量更加有利于服务器的稳定。这样可以保证php-fpm只获取够用的内存，将不多的内存分配给其他应用去使用，会使系统的运行更加畅通。
	对于小内存的服务器来说，比如256M内存的VPS，即使按照一个20M的内存量来算，10个php-cgi进程就将耗掉200M内存，那系统的崩溃就应该很正常了。
	因此应该尽量地控制php-fpm进程的数量，大体明确其他应用占用的内存后，给它指定一个静态的小数量，会让系统更加平稳一些。
	或者使用动态方式，因为动态方式会结束掉多余的进程，可以回收释放一些内存，所以推荐在内存较少的服务器或VPS上使用，具体最大数量根据 总内存/20M 得到。
	比如说512M的VPS，建议pm.max_spare_servers设置为20。至于pm.min_spare_servers，则建议根据服务器的负载情况来设置，比较合适的值在5~10之间。

#pm是来控制php-fpm的工作进程数到底是一次性产生固定不变（static）还是在运行过程中随着需要动态变化（dynamic）。众所周知，工作进程数与服务器性能息息相关，太少则不能及时处理请求，太多则会占用内存过大而拖慢系统。因为php-fpm处理请求时会随着处理的请求数的增加而占用越来越多的内存，所以static模式下往往不好判断启动的能使内存利用最大化的固定进程数，所以想到了dynamic模式。可是为什么我们不用dynamic模式呢，试想某个时刻请求数比较低，20个进程足够应付，突然压力增大了，出现了40个并发PHP请求，按照最小5个空闲进程的设置就需要45个进程，也就是说需要在短时间内创建出25个进程，我们知道创建进程的操作是比较消耗系统资源的，再加上40个并发PHP请求肯定也会给MySQL带来一定的压力，此时再创建25个进程无疑是雪上加霜，所以我在这里还是选择了static模式。

#总结：内存小的建议用动态（pm = dynamic），内存大的建议用静态（pm = static）。

配置php慢日志，用于监控
request_slowlog_timeout = 10s #request_slowlog_timeout 是脚本超过多长时间，就可以记录到日志文件；
slowlog = var/log/slow.log #slowlog 是日志文件的存储路径；

开启后，如果有脚本执行超过指定的时间，就会在指定的日志文件中写入类似如下的信息：
[06-Dec-2017 20:05:31]  [pool www] pid 22271
script_filename = /home/wwwroot/default/tz/tz.php #script_filename 是入口文件
[0x00007f75e662a398] preg_match_all() /home/wwwroot/default/tz/tz.php:453 #preg_match_all() 说明是执行这个方法的时候超过执行时间的。
[0x00007f75e6627f08] sys_linux() /home/wwwroot/default/tz/tz.php:410  #sys_linux() 说明是执行这个方法的时候超过执行时间的。
#每行冒号后面的数字是行号。

配置php-fpm进程可打开的最大文件句柄数，
rlimit_files = 1024 #默认1024，此值可以不需要配置

一、pm.max_children 多大合适？
这个值原则上是越大越好，php-cgi的进程多了就会处理的很快，排队的请求就会很少。

设置”max_children” 也需要根据服务器的性能进行设定。
计算方式如下：
	一般来说一台服务器正常情况下每一个php-cgi所耗费的内存在20M~30M左右，因此我的”max_children”我设置成40个，20M*40=800M也就是说在峰值的时候所有PHP-CGI所耗内存在800M以内，低于我的有效内存2Gb。
	而如果我 的”max_children”设置的较小，比如5-10个，那么php-cgi就会“很累“，处理速度也很慢，等待的时间也较长，占用的CPU也很高。
	如果长时间没有得到处理的请求就会出现 504 Gateway Time-out 这个错误，而正在处理的很累的那几个php-cgi如果遇到了问题就会出现 502 Bad gateway 这个错误。
max_children较好的设置方式根据req/s（吞吐率，单位时间里服务器处理的最大请求数，单位req/s）来设置，若程序是 100 req/s 的处理能力，那么就设置 100比较好，这是动态来调整的。

二、request_terminate_timeout 多大合适？
计算方式如下：
	如果你的服务器性能足够好，且宽带资源足够充足，PHP脚本没有循环或BUG的话你可以直接将”request_terminate_timeout”设 置成0s。0s的含义是让PHP-CGI一直执行下去而没有时间限制。
	而如果你做不到这一点，也就是说你的PHP-CGI可能出现某个BUG，或者你的宽带不够充足或者其他的原因导致你的PHP-CGI能够假死那么就建议你给”request_terminate_timeout”赋一个值，这个值可以根 据你服务器的性能进行设定。
	一般来说性能越好你可以设置越高，20分钟-30分钟都可以。由于我的服务器PHP脚本需要长时间运行，有的可能会超过10分钟因此我设置了900秒，这样不会导致PHP-CGI死掉而出现502 Bad gateway这个错误。
	
三、 request_terminate_timeout的值如果设置为0或者过长的时间，可能会引起file_get_contents的资源问题。
如果file_get_contents请求的远程资源如果反应过慢，file_get_contents就会一直卡在那里不会超时，我们知道php.ini 里面max_execution_time 可以设置 PHP 脚本的最大执行时间，但是，在 php-cgi(php-fpm) 中，该参数不会起效。真正能够控制 PHP 脚本最大执行时间的是 php-fpm.conf 配置文件中的request_terminate_timeout参数。

request_terminate_timeout默认值为 0 秒，也就是说，PHP 脚本会一直执行下去。这样，当所有的 php-cgi 进程都卡在 file_get_contents() 函数时，这台 Nginx+PHP 的 WebServer 已经无法再处理新的 PHP 请求了，Nginx 将给用户返回“502 Bad Gateway”。修改该参数，设置一个 PHP 脚本最大执行时间是必要的，但是，治标不治本。例如改成 30s，如果发生 file_get_contents() 获取网页内容较慢的情况，这就意味着 150 个 php-cgi 进程，每秒钟只能处理 5 个请求，WebServer 同样很难避免"502 Bad Gateway"。解决办法是request_terminate_timeout设置为10s或者一个合理的值，或者给file_get_contents加一个超时参数。
$ctx = stream_context_create(array(  
   'http' => array(  
       'timeout' => 10 //设置一个超时时间，单位为秒  
       )  
   )  
);  
file_get_contents($str, 0, $ctx);  
四、 max_requests参数配置不当，可能会引起间歇性502错误：
http://hily.me/blog/2011/01/nginx-php-fpm-502/

pm.max_requests = 1000
#设置每个子进程重生之前服务的请求数. 对于可能存在内存泄漏的第三方模块来说是非常有用的. 如果设置为 '0' 则一直接受请求. 等同于 PHP_FCGI_MAX_REQUESTS 环境变量. 默认值: 0.
这段配置的意思是，当一个 PHP-CGI 进程处理的请求数累积到 500 个后，自动重启该进程。

但是为什么要重启进程呢？

一般在项目中，我们多多少少都会用到一些 PHP 的第三方库，这些第三方库经常存在内存泄漏问题，如果不定期重启 PHP-CGI 进程，势必造成内存使用量不断增长。因此 PHP-FPM 作为 PHP-CGI 的管理器，提供了这么一项监控功能，对请求达到指定次数的 PHP-CGI 进程进行重启，保证内存使用量不增长。

正是因为这个机制，在高并发的站点中，经常导致 502 错误，我猜测原因是 PHP-FPM 对从 NGINX 过来的请求队列没处理好。不过我目前用的还是 PHP 5.3.2，不知道在 PHP 5.3.3 中是否还存在这个问题。

目前我们的解决方法是，把这个值尽量设置大些，尽可能减少 PHP-CGI 重新 SPAWN 的次数，同时也能提高总体性能。在我们自己实际的生产环境中发现，内存泄漏并不明显，因此我们将这个值设置得非常大（204800）。大家要根据自己的实际情况设置这个值，不能盲目地加大。

话说回来，这套机制目的只为保证 PHP-CGI 不过分地占用内存，为何不通过检测内存的方式来处理呢？我非常认同高春辉所说的，通过设置进程的峰值内在占用量来重启 PHP-CGI 进程，会是更好的一个解决方案。
````

