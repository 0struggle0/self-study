linux系统目录结构(树状目录结构)

```shell
/bin     #bin是Binary的缩写, 这个目录存放着最经常使用的命令。
/boot    #这里存放的是启动Linux时使用的一些核心文件，包括一些连接文件以及镜像文件。
/dev     #dev是Device(设备)的缩写, 该目录下存放的是Linux的外部设备，在Linux中访问设备的方式和访问文件的方式是相同的。
/etc     #这个目录用来存放所有的系统管理所需要的配置文件和子目录。
/home 	 #用户的主目录，在Linux中，每个用户都有一个自己的目录，一般该目录名是以用户的账号命名的。
/lib 	 #这个目录里存放着系统最基本的动态连接共享库，其作用类似于Windows里的DLL文件。几乎所有的应用程序都需要用到这些共享库。
/lost+found #这个目录一般情况下是空的，当系统非法关机后，这里就存放了一些文件。
/media 	 #linux系统会自动识别一些设备，例如U盘、光驱等等，当识别后，linux会把识别的设备挂载到这个目录下。
/mnt 	#系统提供该目录是为了让用户临时挂载别的文件系统的，我们可以将光驱挂载在/mnt/上，然后进入该目录就可以查看光驱里的内容了。
/opt 	#这是给主机额外安装软件所摆放的目录。比如你安装一个ORACLE数据库则就可以放到这个目录下。默认是空的。
/proc 	#这个目录是一个虚拟的目录，它是系统内存的映射，我们可以通过直接访问这个目录来获取系统信息。这个目录的内容不在硬盘上而是在内存里，我们也可以直接修改里面的某些文件，比如可以通过下面的命令来屏蔽主机的ping命令，使别人无法ping你的机器：
# echo 1 > /proc/sys/net/ipv4/icmp_echo_ignore_all !!!
/root 	#该目录为系统管理员，也称作超级权限者的用户主目录。
/sbin #s就是Super User的意思，这里存放的是系统管理员使用的系统管理程序。
/selinux  #这个目录是Redhat/CentOS所特有的目录，Selinux是一个安全机制，类似于windows的防火墙，但是这套机制比较复杂，这个目录就是存放selinux相关的文件的。
/srv #该目录存放一些服务启动之后需要提取的数据。
/sys #这是linux2.6内核的一个很大的变化。该目录下安装了2.6内核中新出现的一个文件系统 sysfs。
/tmp #这个目录是用来存放一些临时文件的。

/usr #这是一个非常重要的目录，用户的很多应用程序和文件都放在这个目录下，类似于windows下的program files目录。
/usr/bin #系统用户使用的应用程序。
/usr/sbin #超级用户使用的比较高级的管理程序和系统守护程序。
/usr/src #内核源代码默认的放置目录。

/var #这个目录中存放着在不断扩充着的东西，我们习惯将那些经常被修改的目录放在这个目录下。包括各种日志文件。
/run #是一个临时文件系统，存储系统启动以来的信息。当系统重启时，这个目录下的文件应该被删掉或清除。如果你的系统上有 /var/run 目录，应该让它指向 run。

#！！！
#在 Linux 系统中，有几个目录是比较重要的，平时需要注意不要误删除或者随意更改内部文件。
#/etc： 上边也提到了，这个是系统中的配置文件，如果你更改了该目录下的某个文件可能会导致系统不能启动。
#/bin, /sbin, /usr/bin, /usr/sbin: 这是系统预设的执行文件的放置目录，比如 ls 就是在/bin/ls 目录下的。
#值得提出的是，/bin, /usr/bin 是给系统用户使用的指令（除root外的通用户），而/sbin, /usr/sbin 则是给root使用的指令。
#/var： 这是一个非常重要的目录，系统上跑了很多程序，那么每个程序都会有相应的日志产生，而这些日志就被记录到这个目录下，具体在/var/log 目录下，另外mail的预设放置也是在这里。
```



系统的关机、重启以及用户登出

```shell
#在linux领域内大多用在服务器上，很少遇到关机的操作。毕竟服务器上跑一个服务是永无止境的，除非特殊情况下，不得已才会关机。
#正确的关机流程为：sync > shutdown / reboot
#不管是重启系统还是关闭系统，首先要运行 sync 命令，把内存中的数据写到磁盘中。!!!

sync 将数据由内存同步到硬盘中。

shutdown –h 10 ‘This server will shutdown after 10 mins’ #这个命令告诉大家，计算机将在10分钟后关机，并且会显示在登陆用户的当前屏幕中。
shutdown –h now #立马关机
shutdown –h 20:25 #系统会在今天20:25关机
shutdown –h +10 #十分钟后关机
shutdown -c #取消按预定时间关闭系统
shutdown –r now #系统立马重启
shutdown –r +10 #系统十分钟后重启
reboot #就是重启，等同于 shutdown –r now

halt #关闭系统，等同于shutdown –h now 和 poweroff
init 0 #关闭系统(2) 

logout #注销 
```



快捷键

```shell
Ctrl + C  #如果在Linux 底下输入了错误的指令或参数，让当前的程序停掉
Ctrl + d  #等同于 exit 的输入(注销当前用户)。

shift + PageUP  #往前翻页 
shift + PageDown  #往后翻页 
```



显示工作路径  

```shell
pwd #显示工作路径 
```



切换目录

```shell
cd /home #进入 '/ home' 目录' 
cd .. #返回上一级目录 
cd ../.. #返回上两级目录 
cd - #返回上次所在的目录 
cd ~ #进入"家"目录
```



显示目录下的目录及文件

```shell
ls #查看目录中的文件 
ls -l #显示除了文件名之外，还将文件的权限、所有者、文件大小等详细信息 
ls -a #显示隐藏文件(如果一个目录或文件名以一个点 . 开始，表示这个目录或文件是一个隐藏目录或文件(如：.bashrc))
ls -lh #显示显示文件和目录的详细资料并显示文件的大小(-h 不能单独使用，需要配合-l等参数)
ls -S  #以文件大小排序
ls -t #以文件修改时间排序
```



创建、删除目录及文件

```shell
mkdir dir1 #创建一个叫做 'dir1' 的目录
mkdir dir1 dir2 #同时创建两个目录 
mkdir -p /tmp/dir1/dir2 #创建一个目录树

rmdir dir1 #删除一个叫做 'dir1' 的空目录(rmdir不能删除非空目录！！！)
rm -rf dir1 dir2 #强制删除两个目录及它们子目录的内容 

touch file #创建一个文件

rm -f file1 #强制删除(不提示)一个叫做 'file1' 的文件' 
rm -rf dir1 #强制删除一个叫做 'dir1' 的目录并同时删除其子目录内容 
rm -f *.log #强制删除所有.log文件
```



移动、重命名文件

```shell
mv /tmp/a.php /home/ #把a.php从/tmp目录下移动到/home目录下
mv * ../ #移动当前文件夹下的所有文件到上一级目录
mv a.php b.php #把a.php重命名为b.php，重命名时文件名称一定要确保不重复，不然就把上一个文件覆盖了
```



复制文件、目录

```shell
# 复制的时候，不管是复制文件或者目录，都可以在复制后重命名
cp /dir1/file1 /dir2/file2 #复制一个目录下的文件到另一个目录 
cp dir/* . #复制一个目录下的所有文件到当前工作目录 
cp -a dir1 dir2 #复制一个目录到另一个目录 
```



创建文件的软、硬链接

```shell
ln -s file1 lnk1 #创建一个指向文件或目录的软链接(相当于Windows的快捷方式，根文件删除快捷方式失效)
ln file1 lnk1 #创建一个指向文件或目录的硬(物理)链接(相当于将文件复制了一份，删除根文件，不影响复制后的文件)
```



文件搜索 

```shell
#【find】
# -name 是精确查找
# -iname 不区分大小写查找
# * 表示通配任意的字符且任意个数
# ？表示通配任意的单个字符
# [] 表示通配括号里面的任意一个字符
# -user 根据属主来查找文件
# -group 根据属组来查找文件
# -uid(用户id) 和 -gid(用户所属组id)来查找文件
# -a 连接两个不同的条件（两个条件必须同时满足）
# -o 连接两个不同的条件（两个条件满足其一即可）
# -not 对条件取反的
#-atime, -mtime, -ctime, -amin, -mmin, -cmin   这里的atime,mtime,ctime就是分别对应的“最近一次访问时间”“最近一次内容修改时间”“最近一次属性修改时间”，这里的atime的单位指的是“天”，amin的单位是分钟
# -type    f     // 普通文件
#         d     //目录文件
#         l     //链接文件
#         b     //块设备文件
#         c     //字符设备文件
#         p     //管道文件
#         s     //socket文件
#-size 根据大小来查找文件
#【查找完执行的action】
# -print                       //默认情况下的动作
# -ls                          //查找到后用ls 显示出来
# -ok  [commend]               //查找后执行命令的时候询问用户是否要执行
# -exec [commend]              //查找后执行命令的时候不询问用户，直接执行
#也可以使用xargs来对查找到的文件并且执行完action后进一步操作

find / -name file1 #从 '/' 开始进入根文件系统搜索文件和目录
find /home/user1 -name *.bin #在目录 '/ home/user1' 中搜索带有'.bin' 结尾的文件 
find /etc -name passwd? #在目录 ' /etc' 中搜索带以'passwd' 开头的文件 
find /tmp -name [ab].sh #在目录 ' /tmp' 中搜索文件名为'a.sh或者b.sh' 的文件 
find / -user user1 #搜索属于用户 'user1' 的文件和目录
find /tmp -uid  500  #查找uid是500 的文件
find /tmp -gid  1000 #查找gid是1000的文件
find /tmp  -name "*.sh" -a -user root #在目录 ' /tmp' 中搜索文件名为'*.sh'并且所属用户是root的文件 
find  /tmp  –atime  +5  #表示查找在五天内没有访问过的文件
find  /tmp  -atime  -5  #表示查找在五天内访问过的文件
find /tmp -type f  #在目录 ' /tmp' 中搜索普通文件 
find /tmp -size 2M #查找在/tmp 目录下等于2M的文件
find /tmp -name "*.sh" -exec chmod 755 '{}' \;  #搜索以 '.sh' 结尾的文件并定义其权限 
#！！！这里要注意{}的使用：替代查找到的文件
find /tmp -name "*.sh" -exec cp  {} {}.new \; #搜索以 '.sh' 结尾的文件并复制为新的以.new为后缀的文件
find  /tmp -atime +30 –exec rm –rf  {} \; #删除查找到的超过30天没有访问过文件
find / -xdev -name *.rpm #搜索以 '.rpm'结尾的文件，忽略光驱、捷盘等可移动设备 
```



查看文件内容

```shell
#[cat]
cat file1 #从第一个字节开始正向查看文件的全部内容 
cat file1 > file #把file1的文件内容输出到文件file中，覆盖file中的原来的内容
cat -n ccc.sh > ddd.sh #把ccc.sh中的内容带着行号输出到ddd.sh中，ddd.sh如果不存在则自动创建

#[tac]
tac file1 #从最后一行开始反向查看一个文件的全部内容 

#[more, 功能类似于cat同样是展示文件内容, more会以一页一页的显示方便使用者逐页阅读，而最基本的指令就是按空格键就往下一页显示，按b键就会往回上一页显示]
# +n 从笫n行开始显示
# -n 定义屏幕大小为n行
# 回车键 向下n行，需要定义。默认为1行
#q 退出more
more file1 #查看一个长文件的全部内容 

#[less, 功能与more类似，但使用less可以随意浏览文件，而more仅能向前，向后移动，而且less在查看之前不会加载整个文件]
# -N  显示每行的行号
# -o 文件名  将less输出的内容在指定文件中保存起来
# /字符串：向下搜索“字符串”的功能
# ?字符串：向上搜索“字符串”的功能
# n：重复前一个搜索（与 / 或 ? 有关）
# N：反向重复前一个搜索（与 / 或 ? 有关）
# q  退出less 命令
# y  向前滚动一行
# 回车键 向下滚动一行
# 空格键 向下滚动一页
# pagedown 向下翻动一页
# pageup   向上翻动一页

less file1
ps -aux | less -N #ps查看进程信息并通过less分页显示
less 1.log 2.log #查看多个文件 (可以使用n查看下一个，使用p查看前一个)
         
#[head用来显示档案的开头至标准输出中，默认head命令打印其相应文件的开头10行]
head -n file1 #查看一个文件的前n行 

#[tail用于显示指定文件末尾内容，不指定文件时，作为输入信息进行处理。常用查看日志文件]
# -f 循环读取（常用于查看递增的日志文件）
tail -n file1 #查看一个文件的最后n行 
tail -f /var/log/messages #实时查看被添加到一个文件中的内容 
tail -f ping.log #查看日志
```





挂载一个文件系统 
mount /dev/hda2 /mnt/hda2 挂载一个叫做hda2的盘 - 确定目录 '/ mnt/hda2' 已经存在 
umount /dev/hda2 卸载一个叫做hda2的盘 - 先从挂载点 '/ mnt/hda2' 退出 
fuser -km /mnt/hda2 当设备繁忙时强制卸载 
umount -n /mnt/hda2 运行卸载操作而不写入 /etc/mtab 文件- 当文件为只读或当磁盘写满时非常有用 
mount /dev/fd0 /mnt/floppy 挂载一个软盘 
mount /dev/cdrom /mnt/cdrom 挂载一个cdrom或dvdrom 
mount /dev/hdc /mnt/cdrecorder 挂载一个cdrw或dvdrom 
mount /dev/hdb /mnt/cdrecorder 挂载一个cdrw或dvdrom 
mount -o loop file.iso /mnt/cdrom 挂载一个文件或ISO镜像文件 
mount -t vfat /dev/hda5 /mnt/hda5 挂载一个Windows FAT32文件系统 
mount /dev/sda1 /mnt/usbdisk 挂载一个usb 捷盘或闪存设备 
mount -t smbfs -o username=user,password=pass //WinClient/share /mnt/share 挂载一个windows网络共享 



磁盘空间 
df -h 显示已经挂载的分区列表 
ls -lSr |more 以尺寸大小排列文件和目录 
du -sh dir1 估算目录 'dir1' 已经使用的磁盘空间' 
du -sk * | sort -rn 以容量大小为依据依次显示文件和目录的大小 
rpm -q -a --qf '%10{SIZE}t%{NAME}n' | sort -k1,1n 以大小为依据依次显示已安装的rpm包所使用的空间 (fedora, redhat类系统) 
dpkg-query -W -f='${Installed-Size;10}t${Package}n' | sort -k1,1n 以大小为依据显示已安装的deb包所使用的空间 (ubuntu, debian类系统) 



目录权限与文件权限

权限是操作系统用来限制用户访问资源的机制。权限一般分为读(r)、写(w)、执行(x)。系统中每个文件都拥有特定的权限、所属用户及所属组，通过这样的机制来限制哪些用户、哪些组可以对特定的文件进行什么样的操作。 每个进程都是以某个用户的身份运行，所以进程的权限与该用户的权限一样，用户的权限越大，该进程所拥有的权限也就越大。

用户的分类

在 Linux 下针对文件权限分为了三类用户分别为：

| 分类          | 解释                                       |
| ------------- | ------------------------------------------ |
| 文件所有者(u) | 文件是谁创建的，属于谁                     |
| 文件所属组(g) | 文件属于哪个用户组                         |
| 其他用户(o)   | 既不是文件创建者，又不属于文件所属组的用户 |

目录权限

| 权限            | 解释                       |
| --------------- | -------------------------- |
| r（可读权限）   | 用户是否能浏览目录中的内容 |
| w（可写权限）   | 用户是否能够创建或删减目录 |
| x（可执行权限） | 用户是否可以进入目录       |

文件权限

| 权限            | 解释                       |
| --------------- | -------------------------- |
| r（可读权限）   | 用户是否能读取文件中的内容 |
| w（可写权限）   | 用户是否能编辑文件中的内容 |
| x（可执行权限） | 用户是否能执行该文件       |



用户和群组 
groupadd group_name 创建一个新用户组 
groupdel group_name 删除一个用户组 
groupmod -n new_group_name old_group_name 重命名一个用户组 
useradd -c "Name Surname " -g admin -d /home/user1 -s /bin/bash user1 创建一个属于 "admin" 用户组的用户 
useradd user1 创建一个新用户 
userdel -r user1 删除一个用户 ( '-r' 排除主目录) 
usermod -c "User FTP" -g system -d /ftp/user1 -s /bin/nologin user1 修改用户属性 
passwd 修改口令 
passwd user1 修改一个用户的口令 (只允许root执行) 
chage -E 2005-12-31 user1 设置用户口令的失效期限 
pwck 检查 '/etc/passwd' 的文件格式和语法修正以及存在的用户 
grpck 检查 '/etc/passwd' 的文件格式和语法修正以及存在的群组 
newgrp group_name 登陆进一个新的群组以改变新创建文件的预设群组 



文件的权限 - 使用 "+" 设置权限，使用 "-" 用于取消 
ls -lh 显示权限 
ls /tmp | pr -T5 -W$COLUMNS 将终端划分成5栏显示 
chmod ugo+rwx directory1 设置目录的所有人(u)、群组(g)以及其他人(o)以读（r ）、写(w)和执行(x)的权限 
chmod go-rwx directory1 删除群组(g)与其他人(o)对目录的读写执行权限 
chown user1 file1 改变一个文件的所有人属性 
chown -R user1 directory1 改变一个目录的所有人属性并同时改变改目录下所有文件的属性 
chgrp group1 file1 改变文件的群组 
chown user1:group1 file1 改变一个文件的所有人和群组属性 
find / -perm -u+s 罗列一个系统中所有使用了SUID控制的文件 
chmod u+s /bin/file1 设置一个二进制文件的 SUID 位 - 运行该文件的用户也被赋予和所有者同样的权限 
chmod u-s /bin/file1 禁用一个二进制文件的 SUID位 
chmod g+s /home/public 设置一个目录的SGID 位 - 类似SUID ，不过这是针对目录的 
chmod g-s /home/public 禁用一个目录的 SGID 位 
chmod o+t /home/public 设置一个文件的 STIKY 位 - 只允许合法所有人删除文件 
chmod o-t /home/public 禁用一个目录的 STIKY 位 



文件的特殊属性 - 使用 "+" 设置权限，使用 "-" 用于取消 
chattr +a file1 只允许以追加方式读写文件 
chattr +c file1 允许这个文件能被内核自动压缩/解压 
chattr +d file1 在进行文件系统备份时，dump程序将忽略这个文件 
chattr +i file1 设置成不可变的文件，不能被删除、修改、重命名或者链接 
chattr +s file1 允许一个文件被安全地删除 
chattr +S file1 一旦应用程序对这个文件执行了写操作，使系统立刻把修改的结果写到磁盘 
chattr +u file1 若文件被删除，系统会允许你在以后恢复这个被删除的文件 
lsattr 显示特殊的属性 



打包和压缩文件 
bunzip2 file1.bz2 解压一个叫做 'file1.bz2'的文件 
bzip2 file1 压缩一个叫做 'file1' 的文件 
gunzip file1.gz 解压一个叫做 'file1.gz'的文件 
gzip file1 压缩一个叫做 'file1'的文件 
gzip -9 file1 最大程度压缩 
rar a file1.rar test_file 创建一个叫做 'file1.rar' 的包 
rar a file1.rar file1 file2 dir1 同时压缩 'file1', 'file2' 以及目录 'dir1' 
rar x file1.rar 解压rar包 
unrar x file1.rar 解压rar包 
tar -cvf archive.tar file1 创建一个非压缩的 tarball 
tar -cvf archive.tar file1 file2 dir1 创建一个包含了 'file1', 'file2' 以及 'dir1'的档案文件 
tar -tf archive.tar 显示一个包中的内容 
tar -xvf archive.tar 释放一个包 
tar -xvf archive.tar -C /tmp 将压缩包释放到 /tmp目录下 
tar -cvfj archive.tar.bz2 dir1 创建一个bzip2格式的压缩包 
tar -jxvf archive.tar.bz2 解压一个bzip2格式的压缩包 
tar -cvfz archive.tar.gz dir1 创建一个gzip格式的压缩包 
tar -zxvf archive.tar.gz 解压一个gzip格式的压缩包 
zip file1.zip file1 创建一个zip格式的压缩包 
zip -r file1.zip file1 file2 dir1 将几个文件和目录同时压缩成一个zip格式的压缩包 
unzip file1.zip 解压一个zip格式压缩包 



RPM 包 - （Fedora, Redhat及类似系统） 
rpm -ivh package.rpm 安装一个rpm包 
rpm -ivh --nodeeps package.rpm 安装一个rpm包而忽略依赖关系警告 
rpm -U package.rpm 更新一个rpm包但不改变其配置文件 
rpm -F package.rpm 更新一个确定已经安装的rpm包 
rpm -e package_name.rpm 删除一个rpm包 
rpm -qa 显示系统中所有已经安装的rpm包 
rpm -qa | grep httpd 显示所有名称中包含 "httpd" 字样的rpm包 
rpm -qi package_name 获取一个已安装包的特殊信息 
rpm -qg "System Environment/Daemons" 显示一个组件的rpm包 
rpm -ql package_name 显示一个已经安装的rpm包提供的文件列表 
rpm -qc package_name 显示一个已经安装的rpm包提供的配置文件列表 
rpm -q package_name --whatrequires 显示与一个rpm包存在依赖关系的列表 
rpm -q package_name --whatprovides 显示一个rpm包所占的体积 
rpm -q package_name --scripts 显示在安装/删除期间所执行的脚本l 
rpm -q package_name --changelog 显示一个rpm包的修改历史 
rpm -qf /etc/httpd/conf/httpd.conf 确认所给的文件由哪个rpm包所提供 
rpm -qp package.rpm -l 显示由一个尚未安装的rpm包提供的文件列表 
rpm --import /media/cdrom/RPM-GPG-KEY 导入公钥数字证书 
rpm --checksig package.rpm 确认一个rpm包的完整性 
rpm -qa gpg-pubkey 确认已安装的所有rpm包的完整性 
rpm -V package_name 检查文件尺寸、 许可、类型、所有者、群组、MD5检查以及最后修改时间 
rpm -Va 检查系统中所有已安装的rpm包- 小心使用 
rpm -Vp package.rpm 确认一个rpm包还未安装 
rpm2cpio package.rpm | cpio --extract --make-directories *bin* 从一个rpm包运行可执行文件 
rpm -ivh /usr/src/redhat/RPMS/`arch`/package.rpm 从一个rpm源码安装一个构建好的包 
rpmbuild --rebuild package_name.src.rpm 从一个rpm源码构建一个 rpm 包 



YUM 软件包升级器 - （Fedora, RedHat及类似系统） 
yum install package_name 下载并安装一个rpm包 
yum localinstall package_name.rpm 将安装一个rpm包，使用你自己的软件仓库为你解决所有依赖关系 
yum update package_name.rpm 更新当前系统中所有安装的rpm包 
yum update package_name 更新一个rpm包 
yum remove package_name 删除一个rpm包 
yum list 列出当前系统中安装的所有包 
yum search package_name 在rpm仓库中搜寻软件包 
yum clean packages 清理rpm缓存删除下载的包 
yum clean headers 删除所有头文件 
yum clean all 删除所有缓存的包和头文件 



DEB 包 (Debian, Ubuntu 以及类似系统) 
dpkg -i package.deb 安装/更新一个 deb 包 
dpkg -r package_name 从系统删除一个 deb 包 
dpkg -l 显示系统中所有已经安装的 deb 包 
dpkg -l | grep httpd 显示所有名称中包含 "httpd" 字样的deb包 
dpkg -s package_name 获得已经安装在系统中一个特殊包的信息 
dpkg -L package_name 显示系统中已经安装的一个deb包所提供的文件列表 
dpkg --contents package.deb 显示尚未安装的一个包所提供的文件列表 
dpkg -S /bin/ping 确认所给的文件由哪个deb包提供 



APT 软件工具 (Debian, Ubuntu 以及类似系统) 
apt-get install package_name 安装/更新一个 deb 包 
apt-cdrom install package_name 从光盘安装/更新一个 deb 包 
apt-get update 升级列表中的软件包 
apt-get upgrade 升级所有已安装的软件 
apt-get remove package_name 从系统删除一个deb包 
apt-get check 确认依赖的软件仓库正确 
apt-get clean 从下载的软件包中清理缓存 
apt-cache search searched-package 返回包含所要搜索字符串的软件包名称 



文本处理 
cat file1 file2 ... | command <> file1_in.txt_or_file1_out.txt general syntax for text manipulation using PIPE, STDIN and STDOUT 
cat file1 | command( sed, grep, awk, grep, etc...) > result.txt 合并一个文件的详细说明文本，并将简介写入一个新文件中 
cat file1 | command( sed, grep, awk, grep, etc...) >> result.txt 合并一个文件的详细说明文本，并将简介写入一个已有的文件中 
grep Aug /var/log/messages 在文件 '/var/log/messages'中查找关键词"Aug" 
grep ^Aug /var/log/messages 在文件 '/var/log/messages'中查找以"Aug"开始的词汇 
grep [0-9] /var/log/messages 选择 '/var/log/messages' 文件中所有包含数字的行 
grep Aug -R /var/log/* 在目录 '/var/log' 及随后的目录中搜索字符串"Aug" 
sed 's/stringa1/stringa2/g' example.txt 将example.txt文件中的 "string1" 替换成 "string2" 
sed '/^$/d' example.txt 从example.txt文件中删除所有空白行 
sed '/ *#/d; /^$/d' example.txt 从example.txt文件中删除所有注释和空白行 
echo 'esempio' | tr '[:lower:]' '[:upper:]' 合并上下单元格内容 
sed -e '1d' result.txt 从文件example.txt 中排除第一行 
sed -n '/stringa1/p' 查看只包含词汇 "string1"的行 
sed -e 's/ *$//' example.txt 删除每一行最后的空白字符 
sed -e 's/stringa1//g' example.txt 从文档中只删除词汇 "string1" 并保留剩余全部 
sed -n '1,5p;5q' example.txt 查看从第一行到第5行内容 
sed -n '5p;5q' example.txt 查看第5行 
sed -e 's/00*/0/g' example.txt 用单个零替换多个零 
cat -n file1 标示文件的行数 
cat example.txt | awk 'NR%2==1' 删除example.txt文件中的所有偶数行 
echo a b c | awk '{print $1}' 查看一行第一栏 
echo a b c | awk '{print $1,$3}' 查看一行的第一和第三栏 
paste file1 file2 合并两个文件或两栏的内容 
paste -d '+' file1 file2 合并两个文件或两栏的内容，中间用"+"区分 
sort file1 file2 排序两个文件的内容 
sort file1 file2 | uniq 取出两个文件的并集(重复的行只保留一份) 
sort file1 file2 | uniq -u 删除交集，留下其他的行 
sort file1 file2 | uniq -d 取出两个文件的交集(只留下同时存在于两个文件中的文件) 
comm -1 file1 file2 比较两个文件的内容只删除 'file1' 所包含的内容 
comm -2 file1 file2 比较两个文件的内容只删除 'file2' 所包含的内容 
comm -3 file1 file2 比较两个文件的内容只删除两个文件共有的部分 




字符设置和文件格式转换 
dos2unix filedos.txt fileunix.txt 将一个文本文件的格式从MSDOS转换成UNIX 
unix2dos fileunix.txt filedos.txt 将一个文本文件的格式从UNIX转换成MSDOS 
recode ..HTML < page.txt > page.html 将一个文本文件转换成html 
recode -l | more 显示所有允许的转换格式 



文件系统分析 
badblocks -v /dev/hda1 检查磁盘hda1上的坏磁块 
fsck /dev/hda1 修复/检查hda1磁盘上linux文件系统的完整性 
fsck.ext2 /dev/hda1 修复/检查hda1磁盘上ext2文件系统的完整性 
e2fsck /dev/hda1 修复/检查hda1磁盘上ext2文件系统的完整性 
e2fsck -j /dev/hda1 修复/检查hda1磁盘上ext3文件系统的完整性 
fsck.ext3 /dev/hda1 修复/检查hda1磁盘上ext3文件系统的完整性 
fsck.vfat /dev/hda1 修复/检查hda1磁盘上fat文件系统的完整性 
fsck.msdos /dev/hda1 修复/检查hda1磁盘上dos文件系统的完整性 
dosfsck /dev/hda1 修复/检查hda1磁盘上dos文件系统的完整性 



初始化一个文件系统 
mkfs /dev/hda1 在hda1分区创建一个文件系统 
mke2fs /dev/hda1 在hda1分区创建一个linux ext2的文件系统 
mke2fs -j /dev/hda1 在hda1分区创建一个linux ext3(日志型)的文件系统 
mkfs -t vfat 32 -F /dev/hda1 创建一个 FAT32 文件系统 
fdformat -n /dev/fd0 格式化一个软盘 
mkswap /dev/hda3 创建一个swap文件系统 



SWAP文件系统 
mkswap /dev/hda3 创建一个swap文件系统 
swapon /dev/hda3 启用一个新的swap文件系统 
swapon /dev/hda2 /dev/hdb3 启用两个swap分区 



备份 
dump -0aj -f /tmp/home0.bak /home 制作一个 '/home' 目录的完整备份 
dump -1aj -f /tmp/home0.bak /home 制作一个 '/home' 目录的交互式备份 
restore -if /tmp/home0.bak 还原一个交互式备份 
rsync -rogpav --delete /home /tmp 同步两边的目录 
rsync -rogpav -e ssh --delete /home ip_address:/tmp 通过SSH通道rsync 
rsync -az -e ssh --delete ip_addr:/home/public /home/local 通过ssh和压缩将一个远程目录同步到本地目录 
rsync -az -e ssh --delete /home/local ip_addr:/home/public 通过ssh和压缩将本地目录同步到远程目录 
dd bs=1M if=/dev/hda | gzip | ssh user@ip_addr 'dd of=hda.gz' 通过ssh在远程主机上执行一次备份本地磁盘的操作 
dd if=/dev/sda of=/tmp/file1 备份磁盘内容到一个文件 
tar -Puf backup.tar /home/user 执行一次对 '/home/user' 目录的交互式备份操作 
( cd /tmp/local/ && tar c . ) | ssh -C user@ip_addr 'cd /home/share/ && tar x -p' 通过ssh在远程目录中复制一个目录内容 
( tar c /home ) | ssh -C user@ip_addr 'cd /home/backup-home && tar x -p' 通过ssh在远程目录中复制一个本地目录 
tar cf - . | (cd /tmp/backup ; tar xf - ) 本地将一个目录复制到另一个地方，保留原有权限及链接 
find /home/user1 -name '*.txt' | xargs cp -av --target-directory=/home/backup/ --parents 从一个目录查找并复制所有以 '.txt' 结尾的文件到另一个目录 
find /var/log -name '*.log' | tar cv --files-from=- | bzip2 > log.tar.bz2 查找所有以 '.log' 结尾的文件并做成一个bzip包 
dd if=/dev/hda of=/dev/fd0 bs=512 count=1 做一个将 MBR (Master Boot Record)内容复制到软盘的动作 
dd if=/dev/fd0 of=/dev/hda bs=512 count=1 从已经保存到软盘的备份中恢复MBR内容 



光盘 
cdrecord -v gracetime=2 dev=/dev/cdrom -eject blank=fast -force 清空一个可复写的光盘内容 
mkisofs /dev/cdrom > cd.iso 在磁盘上创建一个光盘的iso镜像文件 
mkisofs /dev/cdrom | gzip > cd_iso.gz 在磁盘上创建一个压缩了的光盘iso镜像文件 
mkisofs -J -allow-leading-dots -R -V "Label CD" -iso-level 4 -o ./cd.iso data_cd 创建一个目录的iso镜像文件 
cdrecord -v dev=/dev/cdrom cd.iso 刻录一个ISO镜像文件 
gzip -dc cd_iso.gz | cdrecord dev=/dev/cdrom - 刻录一个压缩了的ISO镜像文件 
mount -o loop cd.iso /mnt/iso 挂载一个ISO镜像文件 
cd-paranoia -B 从一个CD光盘转录音轨到 wav 文件中 
cd-paranoia -- "-3" 从一个CD光盘转录音轨到 wav 文件中（参数-3） 
cdrecord --scanbus 扫描总线以识别scsi通道 
dd if=/dev/hdc | md5sum 校验一个设备的md5sum编码，例如一张 CD 



网络 - （以太网和WIFI无线） 
ifconfig eth0 显示一个以太网卡的配置 
ifup eth0 启用一个 'eth0' 网络设备 
ifdown eth0 禁用一个 'eth0' 网络设备 
ifconfig eth0 192.168.1.1 netmask 255.255.255.0 控制IP地址 
ifconfig eth0 promisc 设置 'eth0' 成混杂模式以嗅探数据包 (sniffing) 
dhclient eth0 以dhcp模式启用 'eth0' 
route -n show routing table 
route add -net 0/0 gw IP_Gateway configura default gateway 
route add -net 192.168.0.0 netmask 255.255.0.0 gw 192.168.1.1 configure static route to reach network '192.168.0.0/16' 
route del 0/0 gw IP_gateway remove static route 
echo "1" > /proc/sys/net/ipv4/ip_forward activate ip routing 
hostname show hostname of system 
host www.example.com lookup hostname to resolve name to ip address and viceversa(1) 
nslookup www.example.com lookup hostname to resolve name to ip address and viceversa(2) 
ip link show show link status of all interfaces 
mii-tool eth0 show link status of 'eth0' 
ethtool eth0 show statistics of network card 'eth0' 
netstat -tup show all active network connections and their PID 
netstat -tupl show all network services listening on the system and their PID 
tcpdump tcp port 80 show all HTTP traffic 
iwlist scan show wireless networks 
iwconfig eth1 show configuration of a wireless network card 
hostname show hostname 
host www.example.com lookup hostname to resolve name to ip address and viceversa 
nslookup www.example.com lookup hostname to resolve name to ip address and viceversa 



显示时间

```shell
# -3 显示前一月，当前月，后一月三个月的日历
# -m 显示星期一为第一列
# -j 显示在当前年第几天
# -y 显示当前年份的日历

date #显示系统日期
cal 9 2012 #显示指定年月日期
cal -y 2013 #显示2013年每个月日历
cal 2019 #显示2019年的日历表 
```



遇到的问题

```
1. 由于某种原因,生成了.swp的文件,每次vi或者vim进去的时候都会有一段提示,又因为某种原因,按照提示删除无效
比如你编辑test.php时留下了个.swp文件,又因为上述原因怎么也删除不了,只需在rm-rf.test.php.swp就行了,注意test前面有个“.” 
```



nginx -s reload
service php-fpm restart

