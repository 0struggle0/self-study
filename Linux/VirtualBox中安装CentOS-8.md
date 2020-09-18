## 下载CentOS

第一步：登陆[CentOS官网](https://links.jianshu.com/go?to=https%3A%2F%2Fwww.centos.org%2Fdownload%2F)，点击CentOS Linux DVD ISO，开始下载， 保存到指定目录;![1](D:\htdocs\mytest\Git\self-study\Linux\image\1.webp)

## VirtualBox配置CentOS

第一步：VirtualBox新建虚拟机 CentOS-8，配置电脑名称和操作系统类型 ；![2](D:\htdocs\mytest\Git\self-study\Linux\image\2.webp)

![3](D:\htdocs\mytest\Git\self-study\Linux\image\3.webp)

第二步：配置内存大小；

![4](D:\htdocs\mytest\Git\self-study\Linux\image\4.webp)

第三步：虚拟硬盘；

![5](D:\htdocs\mytest\Git\self-study\Linux\image\5.webp)

第四步：创建虚拟硬盘；

![6](D:\htdocs\mytest\Git\self-study\Linux\image\6.webp)

第五步：虚拟硬盘存储在物理硬盘的配置，动态分配；

![7](D:\htdocs\mytest\Git\self-study\Linux\image\7.webp)

第六步：虚拟硬盘存储在物理硬盘上的文件位置以及大小；

![8](D:\htdocs\mytest\Git\self-study\Linux\image\8.webp)

第七步：配置完成

![9](D:\htdocs\mytest\Git\self-study\Linux\image\9.webp)

## CentOS操作系统配置

第一步：选择安装的CentOS系统，点击设置；

![10](D:\htdocs\mytest\Git\self-study\Linux\image\10.webp)

第二步：选择网络连接方式，点击确定；

![11](D:\htdocs\mytest\Git\self-study\Linux\image\11.webp)

第三步：选择系统镜像，Choose a disk file...；

![12](D:\htdocs\mytest\Git\self-study\Linux\image\12.webp)

![13](D:\htdocs\mytest\Git\self-study\Linux\image\13.webp)

## CentOS操作系统安装

第一步：选择新配置的虚拟机，点击启动（注意：光驱中配置了系统镜像）；

![14](D:\htdocs\mytest\Git\self-study\Linux\image\14.webp)

第三步：开始安装，回车开始测试媒体，并安装系统；

![15](D:\htdocs\mytest\Git\self-study\Linux\image\15.webp)

第四步：选择语言；

![16](D:\htdocs\mytest\Git\self-study\Linux\image\16.webp)

第五步：选择安装的操作系统类型；

![17](D:\htdocs\mytest\Git\self-study\Linux\image\17.webp)

第六步：选择虚拟化主机；

![18](D:\htdocs\mytest\Git\self-study\Linux\image\18.webp)

> 界面说明：
> 1、带GUI的服务器，集成的易于管理的带有图形界面的服务器；
> 2、服务器，集成的易于管理的服务器；
> 3、最小安装，基本功能；
> 4、工作站，工作站是用户友好的笔记本电脑和PC的桌面系统；
> 5、定制操作系统；
> 6、虚拟化主机，最小虚拟化主机。

第七步：设置地区和时间；

![19](D:\htdocs\mytest\Git\self-study\Linux\image\19.webp)

![20](D:\htdocs\mytest\Git\self-study\Linux\image\20.webp)

第八步：设置安装目的地；

![21](D:\htdocs\mytest\Git\self-study\Linux\image\21.webp)

![22](D:\htdocs\mytest\Git\self-study\Linux\image\22.webp)

第九步：设置root用户密码；

![23](D:\htdocs\mytest\Git\self-study\Linux\image\23.webp)

![24](D:\htdocs\mytest\Git\self-study\Linux\image\24.webp)

第十步：等待安装，并重启（重启前，先移除虚拟盘）；

![25](D:\htdocs\mytest\Git\self-study\Linux\image\25.webp)

## CentOS操作系统配置网络

第一步：root 用户登录系统，查看IP；

![26](D:\htdocs\mytest\Git\self-study\Linux\image\26.webp)

第二步：`cd /etc/sysconfig/network-scripts/`；

![27](D:\htdocs\mytest\Git\self-study\Linux\image\27.webp)

第三步：查看宿主机的IP；

![28](D:\htdocs\mytest\Git\self-study\Linux\image\28.webp)

第四步：`vi ifcfg-enp0s3`；

![29](D:\htdocs\mytest\Git\self-study\Linux\image\29.webp)

第五步：`nmcli c reload` 重新加载网络配置；

>说明，CentOS 8默认不支持network.service服务，需要使用yum install network-scripts命令来安装此服务
>`yum install -y network-scripts`

第六步：配置静态IP

![30](D:\htdocs\mytest\Git\self-study\Linux\image\30.webp)

第七步：重启网卡；

![31](D:\htdocs\mytest\Git\self-study\Linux\image\31.webp)

第八步：重启网络服务；

![32](D:\htdocs\mytest\Git\self-study\Linux\image\32.webp)

第九步：ping百度；

![33](D:\htdocs\mytest\Git\self-study\Linux\image\33.webp)

第十步：ping宿主机，此时发现不通；

![34](D:\htdocs\mytest\Git\self-study\Linux\image\34.webp)

第十一步：配置network；

![35](D:\htdocs\mytest\Git\self-study\Linux\image\35.webp)



原文链接 ：https://www.jianshu.com/p/4aee7e81db11