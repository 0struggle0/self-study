<?php

class ConbertCode
{
    /**
	 * 转码函数
	 * @param [mixed] $content
	 * @param [string] $from
	 * @param [string] $to
	 * @return [mixed]
	 */
    public function charset($content, $from = 'gbk', $to = 'utf-8')
    {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;

        if (strtoupper($from) === strtoupper($to) || empty($content)) {
            return $content; //如果编码相同则不转换
        }

        if (function_exists('mb_convert_encoding')) {
 			if (is_array($content)){
				$content = var_export($content, true); //输出或返回一个变量的字符串表示
				$content = mb_convert_encoding($content, $to, $from); //转换字符的编码, mb可以转换中文
                eval("\$content = $content;"); //把字符串作为PHP代码执行, 把转换为字符串的数组重新变为数组
                return $content;
			} else {
				return mb_convert_encoding($content, $to, $from);
			}
        } else if (function_exists('iconv')) {
 			if (is_array($content)){
				$content = var_export($content, true);
				$content = iconv($from, $to, $content);
                eval("\$content = $content;");
                return $content;
			} else {
				return iconv($from,$to,$content);
			}
        } else {
            return $content;
        }
    }
}
    