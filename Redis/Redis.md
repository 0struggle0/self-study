## Redis

**01**

**前言**

**显而易见，如今的 Redis 已经进入了成熟期，但依旧存在很多疑难杂症。**数以千计的开发者都在开发和使用这个数据库，它拥有非常完善的文档。

我记得第一次使用 Redis，是为了在保存有数百万用户的关系数据库里对某个条件进行查询。在不断优化后每次操作可以控制在 **1 秒钟甚至更短**，带给我相当大的震撼。

**02**

**关于 Redis 特性**

在 Redis 之前，很多互联网公司会使用 MySQL + Memcached 架构，这个架构虽然适合于海量数据存储，但随着业务的增加，会出现很多问题。

Redis 就在这种时代背景中产生，你会发现 Memcached 遇到的问题都被 Redis 给解决了。

那么 Redis 有哪些具体特性呢？大致可分为如下八大特性。

**速度极快。**官方给出的数据是 10 万次 ops 的读写，这主要归功于这些数据都存在于内存中。由于 Redis 是开源的，当你打开源代码，就会发现 Redis 都是用 C 语言写的，C 语言是最接近计算机语言的代码，而且只有区区 5 万行，保证了 Redis 的速度。同时一个 Redis 只是一个单线程，其真正的原因还是因为单线程在内存中是效率最高的。**持久化。**Redis 的持久化可以保证将内存中的数据每隔一段时间就保存于磁盘中，重启的时候会再次加载到内存。持久化方式是 RDB 和 AOF。**支持多种数据结构。**分别支持哈希、集合、BitMaps，还有位图（多用于活跃用户数等统计）、HyperLogLog（超小内存唯一值计数，由于只有 12K，是有一定误差范围的）、GEO（地理信息定位）。**支持多种编程语言。**支持 Java、PHP、Python、Ruby、Lua、Node.js。**功能丰富。**如发布订阅、Lua 脚本、事务、Pipeline（管道，即当指令到达一定数量后，客户端才会执行）。**简单。**不依赖外部库、单线程、只有 23000 行 Code。**主从复制。**主节点的数据做副本，这是做高可用的基石。**高可用和分布式。**Redis-Sentinel（v2.8）支持高可用，Redis-Cluster（v3.0）支持分布式。上面是一些 Redis 介绍性的内容，如果你还没有接触过 Redis，但又对此有兴趣的话，这里有适合**工作实战的教程**。

**扫码订阅 Redis**

**▼**

如果已经开始用到 Redis，那么你在应用过程中是否也遇到过下面的这些问题？

**03**

**关于 Redis 疑难问题**

在各种场景中，无论是什么架构，你都可以将 Redis 融入项目中来，这可以解决很多关系数据库无法解决的问题。

比如，现有数据库处理缓慢的任务，或者在原有的基础上开发新的功能，都可以使用 Redis。但大家在实践中总会遇到难题，下面我们盘点一下：

Redis 持久化问题？Redis 实际应用场景里怎么使用？1000 个线程压测时 Redis Incr 出现错误，就是 Timeout，怎么排查？有什么好的经验分享？批量查寻是用 MGET 好还是 Hash 更好，Hash 的性能瓶颈是多少，达到多少个 Key 或者多大容量后性能急剧下降？如果需要大批量的查例如 1000 个 Key，用什么方案更好？MGET 在集群模式下的实现方式是什么，怎么知道某个 Key 在哪个集群分片上？Redis 最大并发大约支持 5~10 万并发，假设现在有 20 万或者 50 万并发该怎么办？Redis 分布式集群的几种解决方案，哨兵等方案结合生产环境经验的区别、优劣是什么？jedispool 链接对象无法释放，这个怎么办？代码写了在 finally 里面也执行了，然后看客户端连接数越来越多，最后项目挂了怎么办？Redis 和数据库同步、缓冲穿透、雪崩问题、hyperloglog slowqery 实现原理？无论是 Win 或 Linux 都有此现象，服务器 Redis 3.x，客户端 Hiredis，在客户机与服务器间网络不稳定的情况下，客户机可能收不到服务器推送来的消息，以及客户机发布消息时会塞死。是否能提供相关解决经验？Redis 的连接数用什么命令监测？Redis 的配置要主要哪些参数调优？登录 Redis 出现提示，要求密码 NOAUTH Authentication required 有什么办法可以免密登录？有没有在生产环境下用 Redis 做持久化存储的例子？一般怎么配置 AOF 和 RDB？在高并发并且尽量少数据丢失的情况下有哪些优化手段？哨兵模式下 Client 是随机挑选其中一个哨兵发送 Request 吗？那么如果这个哨兵 Process 挂了会怎样？Redis 集群很多个 Redis 的话，是把多个 IP 全部写到代码里面，那会不会导致压力不均衡？要开始使用 Redis 的时候，如何预估生产环境需要多少计算资源（Cluster 机器数量、内存、CPU、硬盘空间、Slave 数量等）？有没有一些通用的经验？AOF 和 RDB 配合着用，恢复数据哪个为主？假如内存 8G 的话，Redis 既然是运行在内存中，那 Redis 最大能存多大数据？熟练使用和运维 Redis 已经成为开发人员的一个必备技能。

国外使用 Redis 的公司包括 Twitter、Instagram 等互联网巨头，而国内对 Redis 的使用更有后来者居上之势，除 BAT 外，新浪微博已成为 Redis 全球最大的使用者。