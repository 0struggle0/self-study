## 一、为什么要使用composer
做PHP开发一定会遇到引用第三方类库的时候，而第三方类库一般都是一个整体，都有一个统一的自动加载文件autuload.php，如果在项目中只引用了一个类库，项目本身的自动加载与类库之间的依赖关系还容易解决，但是如果项目中引用了N多个第三方类库又或者引用A类库的时候发现A类库依赖于B类库，B类库又依赖于C类库，那光是解决这些类库之间的依赖引用关系就比较麻烦，而使用composer的话，只要声明你需要的类库名称及版本号，它会找出哪个版本的包需要安装，并安装它们（将它们下载到你的项目中），还会帮我们解决不同类库之间的依赖关系，到时候我们只需要引用composer生成的autuload.php就行了，所以我们需要使用composer。
## 二、composer介绍
Composer 是 PHP 的一个依赖管理工具。
什么是依赖管理工具？就是说我们在项目中引用第三方类库的时候，Composer 会帮你下载并整理这些类库的文件，而且还会解决这些类库不同文件之间的引用依赖，有了它，我们就可以很轻松的使用一个命令将其他人的优秀代码引用到我们的项目中来。
Composer 默认情况下不是全局安装，而是基于指定的项目的某个目录中（例如 vendor）进行安装。
Composer 需要 PHP 5.3.2+ 以上版本，且需要开启 openssl。
Composer 可运行在 Windows 、 Linux 以及 OSX 平台上。
## 三、composer的安装
1. Wondows 平台上，我们只需要下载 [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) 后，一步步安装即可。
2. 需要注意PHP是否开启 openssl 配置，如果没有我们需要php.ini，将 extension=php_openssl.dll 前面的分号去掉就可以了。
3. 安装成功后，我们可以通过命令窗口(cmd) 输入 composer --version 命令来查看是否安装成功
4. 为了方便全局使用composer命令，可以打开环境变量，在path中增加composer的安装路径 如：C:\Program\ComposerSetup\bin;
## 四、切换镜像
为什么要切换镜像？因为composer是老外做的，所以包地址也在国外，然而，由于众所周知的原因，国外的网站连接速度很慢，并且随时可能被“墙”甚至“不存在”。

“Packagist 中国全量镜像”所做的就是缓存所有安装包和元数据到国内的机房并通过国内的 CDN 进行加速，这样就不必再去向国外的网站发起请求，从而达到加速 `composer install` 以及 `composer update` 的过程，并且更加快速、稳定。因此，即使 `packagist.org`、`github.com` 发生故障（主要是连接速度太慢和被墙），你仍然可以下载、更新安装包。

所以我们切换到国内镜像后就不用担心速度的问题了。

有两种方式切换镜像服务：

- **系统全局配置：** 即将配置信息添加到 Composer 的全局配置文件 `config.json` 中
- **单个项目配置：** 将配置信息添加到某个项目的 `composer.json` 文件中

### **方法一：** 修改 composer 的全局配置文件**（推荐方式）**

打开命令行窗口（windows用户）或控制台（Linux、Mac 用户）并执行如下命令：

```
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

### **方法二：** 修改当前项目的 `composer.json` 配置文件：

打开命令行窗口（windows用户）或控制台（Linux、Mac 用户），进入你的项目的根目录（也就是 `composer.json` 文件所在目录），执行如下命令：

```
composer config repo.packagist composer https://packagist.phpcomposer.com
```

上述命令将会在当前项目中的 `composer.json` 文件的末尾自动添加镜像的配置信息（你也可以自己手工添加）：

```json
"repositories": {
    "packagist": {
        "type": "composer",
        "url": "https://packagist.phpcomposer.com"
    }
}
```

以 laravel 项目的 `composer.json` 配置文件为例，执行上述命令后如下所示（注意最后几行）：

```
{
    "name": "laravel/laravel",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "type": "project",
    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*"
    },
    "config": {
        "preferred-install": "dist"
    },
    "repositories": {
        "packagist": {
            "type": "composer",
            "url": "https://packagist.phpcomposer.com"
        }
    }
}
```

## 五、解除镜象：

如果需要解除镜像并恢复到 packagist 官方源，请执行以下命令：

复制

```bash
composer config -g --unset repos.packagist
```

执行之后，composer 会利用默认值（也就是官方源）重置源地址。

将来如果还需要使用镜像的话，只需要根据前面的“镜像用法”中介绍的方法再次设置镜像地址即可。

## 六、composer的使用

```php
1. 要想使用 Composer，我们需要先在项目的目录下创建一个 composer.json 文件，文件描述了项目的需要引用的类库名称以及版本。包名称由供应商名称和其项目名称构成，通常容易产生相同的项目名称，而供应商名称的存在则很好的解决了命名冲突的问题。它允许两个不同的人创建同样名为 json 的库，而之后它们将被命名为 igorw/json 和 seldaek/json。如：
    {
        "require": {
            "monolog/monolog": "1.2.*"  //供应商名称/项目的名称:版本号
        }
    }
2. 接下来只要运行以下命令即可安装依赖包：composer install
3. require 命令，除了使用 install 命令外，我们也可以使用 require 命令快速的安装一个依赖而不需要手动在 composer.json 里添加依赖信息：
    composer require monolog/monolog
4. update 命令，update 命令用于更新项目里所有的包，或者指定的某些包：
// 更新所有依赖
composer update

// 更新指定的包
composer update monolog/monolog

// 更新指定的多个包
composer update monolog/monolog symfony/dependency-injection

// 还可以通过通配符匹配包
composer update monolog/monolog symfony

//需要注意的时，包能升级的版本会受到版本约束的约束，包不会升级到超出约束的版本的范围。例如如果 composer.json 里包的版本约束为 ^1.10，而最新版本为 2.0。那么 update 命令是不能把包升级到 2.0 版本的，只能最高升级到 1.x 版本。

5. remove 命令
remove 命令用于移除一个包及其依赖（在依赖没有被其他包使用的情况下），如果依赖被其他包使用，则无法移除：

composer remove monolog/monolog

6. search 命令
search 命令可以搜索包：

composer search monolog
该命令会输出包及其描述信息，如果只想输出包名可以使用 --only-name 参数：

composer search --only-name monolog

7. show 命令可以列出当前项目使用到包的信息：

// 列出所有已经安装的包
composer show

// 可以通过通配符进行筛选
composer show monolog/*

// 显示具体某个包的信息
composer show monolog/monolog
```

## `composer.json`：项目安装

要开始在你的项目中使用 Composer，你只需要一个 `composer.json` 文件。该文件包含了项目的依赖和其它的一些元数据。

### 关于`composer.json`文件的内容

第一件事情（并且往往只需要做这一件事），你需要在 `composer.json` 文件中指定 `require` key 的值。你只需要简单的告诉 Composer 你的项目需要依赖哪些包。

```json
{
    "require": {
        "monolog/monolog": "1.0.*"
    }
}
```

你可以看到， `require` 需要一个 **包名称** （例如 `monolog/monolog`） 映射到 **包版本** （例如 `1.0.*`） 的对象。

### 包名称

包名称由供应商名称和其项目名称构成。通常容易产生相同的项目名称，而供应商名称的存在则很好的解决了命名冲突的问题。它允许两个不同的人创建同样名为 `json` 的库，而之后它们将被命名为 `igorw/json` 和 `seldaek/json`。

这里我们需要引入 `monolog/monolog`，供应商名称与项目的名称相同，对于一个具有唯一名称的项目，我们推荐这么做。它还允许以后在同一个命名空间添加更多的相关项目。如果你维护着一个库，这将使你可以很容易的把它分离成更小的部分。

### 包版本

在前面的例子中，我们引入的 monolog 版本指定为 `1.0.*`。这表示任何从 `1.0` 开始的开发分支，它将会匹配 `1.0.0`、`1.0.2` 或者 `1.0.20`。

版本约束可以用几个不同的方法来指定。

| 名称         | 实例                                    | 描述                                                         |
| :----------- | :-------------------------------------- | :----------------------------------------------------------- |
| 确切的版本号 | `1.0.2`                                 | 你可以指定包的确切版本。                                     |
| 范围         | `>=1.0` `>=1.0,<2.0` `>=1.0,<1.1|>=1.2` | 通过使用比较操作符可以指定有效的版本范围。 有效的运算符：`>`、`>=`、`<`、`<=`、`!=`。 你可以定义多个范围，用逗号隔开，这将被视为一个**逻辑AND**处理。一个管道符号`|`将作为**逻辑OR**处理。 AND 的优先级高于 OR。 |
| 通配符       | `1.0.*`                                 | 你可以使用通配符`*`来指定一种模式。`1.0.*`与`>=1.0,<1.1`是等效的。 |
| 赋值运算符   | `~1.2`                                  | 这对于遵循语义化版本号的项目非常有用。`~1.2`相当于`>=1.2,<2.0`。 |

```
"symfony/http-foundation": "^3.4"

大于等于3.4的版本 就是3.4. 代表任意数，但是不能是3.5 3.6等，只能是3.4.*
```

### 下一个重要版本（波浪号运算符）

`~` 最好用例子来解释： `~1.2` 相当于 `>=1.2,<2.0`，而 `~1.2.3` 相当于 `>=1.2.3,<1.3`。正如你所看到的这对于遵循 [语义化版本号](http://semver.org/) 的项目最有用。一个常见的用法是标记你所依赖的最低版本，像 `~1.2` （允许1.2以上的任何版本，但不包括2.0）。由于理论上直到2.0应该都没有向后兼容性问题，所以效果很好。你还会看到它的另一种用法，使用 `~` 指定最低版本，但允许版本号的最后一位数字上升。

```sh
composer install
```

创建好composer.json文件，执行上面命令后，这将会找到 `monolog/monolog` 的最新版本，并将它下载到 `vendor` 目录。 这是一个惯例把第三方的代码到一个指定的目录 `vendor`。如果是 monolog 将会创建 `vendor/monolog/monolog` 目录(第一个monolog是供应商的名称，第一个monolog是类库的名称)。另一件事是 `install` 命令将创建一个 `composer.lock` 文件到你项目的根目录中。

> **小技巧：如果你正在使用Git来管理你的项目， 你可能要添加 vendor 到你的 .gitignore 文件中。 因为第三方类库都比较大，部署代码是比较慢，所以你不会希望将所有的代码都添加到你的版本库中。**

## `composer.lock` - 锁文件

在安装依赖后，Composer 将把安装时确切的版本号列表写入 `composer.lock` 文件。这将锁定改项目的特定版本。

如果你愿意，可以在你的项目中提交 `composer.lock` 文件。他将帮助你的团队始终针对同一个依赖版本进行测试。任何时候，这个锁文件都只对于你的项目产生影响。

这意味着，任何人建立项目都将下载与指定版本完全相同的依赖。你的持续集成服务器、生产环境、你团队中的其他开发人员、每件事、每个人都使用相同的依赖，从而减轻潜在的错误对部署的影响。即使你独自开发项目，在六个月内重新安装项目时，你也可以放心的继续工作，即使从那时起你的依赖已经发布了许多新的版本。

如果不存在 `composer.lock` 文件，Composer 将读取 `composer.json` 并创建锁文件。

如果你不想提交锁文件，并且你正在使用 Git，那么请将它添加到 `.gitignore` 文件中。

这意味着如果你的依赖更新了新的版本，你将不会获得任何更新。此时要更新你的依赖版本请使用 `update` 命令。这将获取最新匹配的版本（根据你的 `composer.json` 文件）并将新版本更新进锁文件。

## 自动加载

对于库的自动加载信息，Composer 生成了一个 `vendor/autoload.php` 文件。你可以简单的引入这个文件，你会得到一个免费的自动加载支持。

```php
require 'vendor/autoload.php';
```

这使得你可以很容易的使用第三方代码。例如：如果你的项目依赖 monolog，你就可以像这样开始使用这个类库，并且他们将被自动加载。

```php
$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));

$log->addWarning('Foo');
```

你可以在 `composer.json` 的 `autoload` 字段中增加自己的 autoloader。

```json
{
    "autoload": {
        "psr-4": {"Acme\\": "src/"}
    }
}
```

Composer 将注册一个 [PSR-4](http://www.php-fig.org/psr/psr-4/) autoloader 到 `Acme` 命名空间。

你可以定义一个从命名空间到目录的映射。此时 `src` 会在你项目的根目录，与 `vendor` 文件夹同级。例如 `src/Foo.php` 文件应该包含 `Acme\Foo` 类。

添加 `autoload` 字段后，你应该再次运行 `install` 命令来生成 `vendor/autoload.php` 文件。

引用这个文件也将返回 autoloader 的实例，你可以将包含调用的返回值存储在变量中，并添加更多的命名空间。这对于在一个测试套件中自动加载类文件是非常有用的，例如。

```php
$loader = require 'vendor/autoload.php';
$loader->add('Acme\\Test\\', __DIR__);
```

除了 PSR-4 自动加载，classmap 也是支持的。这允许类被自动加载，即使不符合 PSR-0 规范。

> **注意：** **Composer 提供了自己的 autoloader。如果你不想使用它，你可以仅仅引入 `vendor/composer/autoload_*.php` 文件，它返回一个关联数组，你可以通过这个关联数组配置自己的 autoloader。**



## 更新composer版本

composer self-update