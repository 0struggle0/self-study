# laravel中如何防止直接访问.env文件



.env文件含有数据库账号密码等敏感数据，在laravel5.2中，在本地访问127.0.0.1/laravel/.env可直接访问到.env。

为避免.env被直接访问，可使用重定向，方法如下：

在根目录下添加.htaccess文件（与.env处于同一个目录，Apache必须开启重定向扩展）
.htaccess文件内容如下：

```
#将所有的的请求都重定向到public目录下
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteRule    ^$    public/    [L]
RewriteRule    (.*) public/$1    [L]
</IfModule>
```

这时将无法访问127.0.0.1/laravel/.env