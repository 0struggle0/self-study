# 关于php自带的访问服务器xml的方法的坑

就据我了解，php中有两种读取读取xml文件的方法，我就简单介绍一下，

一种是使用simplexml_load_file($src)读取xml文件。simplexml_load_file会把该函数参数里面的文件路径加载进来，并赋值给一个变量，以对象的形式。

第二种是创建一个dom对象，$xmlDoc = new DOMDocument();调用该对象的load方法把xml文件加载进来，然后使用一个循环去遍历该子树得到他子树的值。

在本地使用，加载本地文件本来应该也没什么问题了，但是如果你是在自己的服务器上使用这两个方法加载别的服务器传来的xml，那你就很可能出bug了，用这两个方法会莫名其妙有时候加载不到xml文件，就像参数不存在一样，我试过一直得到结果一直为空的情况，也有试过刷新5次页面，第5次就有结果的情况，但是这么奇异的现象,只要把服务器一重启，都能加载，但是过了一段时间，又间接性不能加载，到完全无法加载。这其中的原因让我百思不得其解，我甚至试过加一个while循环，把得到的结果用empty函数去判断，如果是true就重新加载，还是不行。。。最后发现如果使用file_get_contents函数就没问题，这种奇怪的现象有人能解释吗？反正我以后打死也不会用simplexml_load_file()和DOMDocument()

 

现在总算找到个正确php获取远程获取xml数据的方式，首先是用`$content = file_get_contents($src)`获取，然后是​`$content1 = simplexml_load_string($content);`获取xml文件，而不要一步到位直接用simplexml_load_file，这样很可能获取不到数据