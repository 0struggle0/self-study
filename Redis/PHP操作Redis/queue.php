<?php

/**
 * 队列处理
 */

class QueueClient
{
    private static $queuedb;

    /**
     * 入列
     * @param string $key
     * @param array $value
     */
    public static function push($key, $value)
    {
        if (!C('queue.open')) {
            Logic('queue')->$key($value);
            return;
        }

        if (!is_object(self::$queuedb)) {
            self::$queuedb = new QueueDB();
        }

        return self::$queuedb->push(serialize(array($key => $value)));
    }

    public static function rpush($key, $value)
    {
        if (!C('queue.open')) {
            Logic('queue')->$key($value);
            return;
        }

        if (!is_object(self::$queuedb)) {
            self::$queuedb = new QueueDB();
        }

        return self::$queuedb->rpush($key, serialize($value));
    }
}

class QueueServer
{
    private $_queuedb;

    public function __construct()
    {
        $this->_queuedb = new QueueDB();
    }

    /**
     * 取出队列
     * @param unknown $key
     */
    public function pop($key, $time)
    {
        return unserialize($this->_queuedb->pop($key, $time));
    }

    public function scan()
    {
        return $this->_queuedb->scan();
    }

    public function keys($pattern)
    {
        return $this->_queuedb->keys($pattern);
    }

    public function lrange($key, $start, $stop)
    {
        return $this->_queuedb->lrange($key, $start, $stop);
    }

    public function ltrim($key, $start, $stop)
    {
        return $this->_queuedb->ltrim($key, $start, $stop);
    }

    public function llen($key)
    {
        return $this->_queuedb->llen($key);
    }

    public function lpop($key, $time)
    {
        return $this->_queuedb->lpop($key, $time);
    }
}

class QueueDB
{
    //定义对象
    private $_redis;

    //存储前缀
    private $_tb_prefix = 'QUEUE_';

    private $_redis_prefix = '';

    //存定义存储表的数量,系统会随机分配存储
    private $_tb_num = 2;

    //临时存储表
    private $_tb_tmp = 'TMP_TABLE';

    /**
     * 初始化
     */
    public function __construct()
    {
        if (!extension_loaded('redis')) {
            throw_exception('redis failed to load');
        }
        $this->_redis = new Redis();
        $this->_redis->connect(C('queue.host'), C('queue.port'));
        $auth = C('queue.auth');
        if (!empty($auth)) {
            $this->_redis->auth($auth);
        }
        $this->_tb_prefix = C('redis.prefix') . $this->_tb_prefix;
        $this->_redis_prefix = C('redis.prefix');
    }

    /**
     * 入列
     * @param unknown $value
     */
    public function push($value)
    {
        try {
            return $this->_redis->lPush($this->_tb_prefix . rand(1, $this->_tb_num), $value);
        } catch (Exception $e) {
            throw_exception($e->getMessage());
        }
    }

    public function rpush($key, $value)
    {
        try {
            return $this->_redis->rPush($this->_redis_prefix . $key, $value);
        } catch (Exception $e) {
            throw_exception($e->getMessage());
        }
    }

    /**
     * 取得所有的list key(表)
     */
    public function scan()
    {
        $list_key = array();
        for ($i = 1; $i <= $this->_tb_num; $i++) {
            $list_key[] = $this->_tb_prefix . $i;
        }
        return $list_key;
    }

    /**
     * 获取键列表
     * @param pattern
     */
    public function keys($pattern)
    {
        try {
            $pattern = $pattern;
            $result = $this->_redis->keys($pattern);
            return $result;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 出列
     * @param unknown $key
     */
    public function pop($key, $time)
    {
        try {
            if ($result = $this->_redis->brPop($key, $time)) {
                return $result[1];
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 出列
     * @param unknown $key
     */
    public function lpop($key, $time)
    {
        try {
            if ($result = $this->_redis->blPop($key, $time)) {
                return $result[1];
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 出列 按照范围出列
     * @param unknown $key
     */
    public function lrange($key, $start, $stop)
    {
        try {
            if ($result = $this->_redis->lrange($key, $start, $stop)) {
                return $result;
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 修剪队列（移除start到stop之外的值）
     * @param unknown $key
     */
    public function ltrim($key, $start, $stop)
    {
        try {
            if ($result = $this->_redis->ltrim($key, $start, $stop)) {
                return $result;
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function llen($key)
    {
        try {
            if ($result = $this->_redis->llen($key)) {
                return $result;
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 清空
     */
    public function clear()
    {
        $this->_redis->flushAll();
    }
}
