<?php
/**
 * 记录日志     
 */

// defined('') or exit('Access Invalid!');  //防跳转

class Log
{
    const ERR = 'ERR';
    const SQL = 'SQL';
    const INFO = 'INFO';
    private static $log = array();

    /**
     * [record 记录日志]
     * @param [string] $message [要记录的信息]
     * @param [string] $level [记录方式]
     */
    public static function record($message, $level = self::ERR)
    {
        $now = @date('Y-m-d H:i:s',time());
        switch ($level) {
            case self::SQL:
               self::$log[] = "[{$now}] {$level}: {$message}\r\n";
               break;
            case self::ERR:
            case self::INFO:
                $log_file = BASE_DATA_PATH.'/log/'.date('Ymd',TIMESTAMP).'.log';
                $url = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
                // $url .= " ( act={$_GET['act']}&op={$_GET['op']} ) "; //获取类名、方法名
                // $content = "[{$now}] {$url}\r\n{$level}: {$message}\r\n";
                $content = "[{$now}] \r\n{$level}: {$message}\r\n";
                file_put_contents($log_file, $content, FILE_APPEND);
                break;
        }
    }

    /**
     * [record 读取运行时的日志(SQL日志)]
     */
    public static function read()
    {
    	return self::$log;
    }
}