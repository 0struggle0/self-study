<?php
/*
 * @Description: 
 * @Date: 2020-06-29 13:51:30
 * @LastEditTime: 2021-01-14 15:58:00
 */

class ToolFunction
{
    /**
     * @description: 获取系统类型
     * 
     * @return string
     */
    public static function getOS(): string
    {
        if (PATH_SEPARATOR == ':') {
            return 'Linux';
        } else {
            return 'Windows';
        }
    }

    /**
     * 系统函数 number_format() 也可以实现
     * @description: 保留小数(默认保留2位) 
     *
     * @param int $input 数值
     * @param int $number 小数位数
     *
     * @return string
     */
    public static function format(int $input, int $number = 2): string
    {
        return sprintf("%." . $number . "f", $input);
    }

    /**
     * @description: 二维数组去重
     *
     * @param array $array 数组
     * @param string $key 字段
     *
     * @return array
     */
    public static function arrayMultiUnique(array $array, string $key = 'id'): array
    {
        $result = [];

        foreach ($array as $value) {
            if (!isset($result[$value[$key]])) {
                $result[$value[$key]] = $value;
            }
        }

        return array_values($result);
    }

    /**
     * @description: 二维数组排序
     *
     * @param array $array 排序的数组
     * @param string $keys 要排序的key
     * @param string $sort 排序类型 ASC、DESC
     *
     * @return array
     */
    public static function arrayMultiSort(array $array, string $keys, string $sort = 'desc'): array
    {
        $keysValue = [];

        foreach ($array as $index => $value) {
            $keysValue[$index] = $value[$keys];
        }

        $orderSort = [
            'asc'  => SORT_ASC,
            'desc' => SORT_DESC,
        ];

        array_multisort($keysValue, $orderSort[$sort], $array);
        return $array;
    }

    /**
     * @description: XML转数组
     *
     * @param string $xml xml
     *
     * @return array
     */
    public static function xmlToArray(string $xml): array
    {
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result = json_decode(json_encode($xmlString), true);
        return $result;
    }

    /**
     * @description: curl 模拟发送post请求
     *
     * @param string $url 请求地址
     * @param string $data 发送的参数
     * @param string $headers 设置的请求头
     * 如： $headers = [
     *          "Content-type: application/json;charset='utf-8'",
     *          "X-oapp-access-id: " . self::ACCESSID,
     *          "X-oapp-sig: " . hash_hmac("sha1", $requestData, self::ACCESS_SECRET),
     *          "X-ts: " . $time,
     *          "X-user-oid: ",
     *      ];
     *
     * @return array
     */
    public static function sendPostRequest($url, $data, $headers = array())
    {
        // 初始化
        $ch = curl_init();

        // 请求地址
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        // tps协议需要以下两行，否则请求不成功
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // post方法所需要的参数
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @description: curl 模拟发送get请求
     *
     * @param string $url 请求地址
     * @param string $headers 设置的请求头
     * 如： $headers = [
     *          "Content-type: application/json;charset='utf-8'",
     *          "X-oapp-access-id: " . self::ACCESSID,
     *          "X-oapp-sig: " . hash_hmac("sha1", $requestData, self::ACCESS_SECRET),
     *          "X-ts: " . $time,
     *          "X-user-oid: ",
     *      ];
     *
     * @return array
     */
    public static function sendGetRequest($url, $headers = array())
    {
        // 初始化
        $ch = curl_init();

        // 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // 设置请求头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @description: 把stdclass类型的array转换为可用的array
     * 
     * @param {stdclass array} 需要转换格式的数组
     * 
     * @return: array
     */
    public static function objectToArray($array): array
    {
        if (is_object($array)) {
            $array = (array) $array;
        }

        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = self::objectToArray($value);
            }
        }

        return $array;
    }

    /**
     * @description: 文件打包下载

     * @param string $downloadZip 打包后下载的文件名
     * @param array $list 打包文件组

     * @return void
     */
    public static function addZip(string $downloadZip, array $list)
    {
        $zip = new ZipArchive();
        if ($zip->open($downloadZip, ZipArchive::CREATE) === true) {
            foreach ($list as $fileName) {
                $zip->addFile($fileName);
            }
            $zip->close();
        } else {
            echo 'create zip failed';
        }

        // 下载Zip包
        header('Cache-Control: max-age=0');
        header('Content-Description: File Transfer');
        header('Content-disposition: attachment; filename=' . basename($downloadZip));
        header('Content-Type: application/zip'); // zip格式的
        header('Content-Transfer-Encoding: binary'); // 二进制文件
        header('Content-Length: ' . filesize($downloadZip)); // 文件大小
        readfile($downloadZip);
        exit();
    }

    /**
     * @description: 解压压缩包
     * 
     * @param string $zipName 要解压的压缩包
     * @param string $dest 解压到指定目录
     * 
     * @return boolean
     */
    public static function unZip(string $zipName, string $dest): bool
    {
        // 检测要解压压缩包是否存在
        if (!is_file($zipName)) {
            return false;
        }

        // 检测目标路径是否存在
        if (!is_dir($dest)) {
            mkdir($dest, 0777, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipName) === TRUE) {
            // extractTo 方法解压缩文件,将压缩文件解压缩到指定的目录; 
            // 还可以有第二个参数，它接受一个解压缩文件名数组，只把压缩包中的与这些文件同名的解压出来。 
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }

        return false;
    }

    /**
     * @description: 文件下载
     * 
     * @param string $filename 要下载的文件
     * @param string $refilename 下载后的命名
     * 
     * @return void
     */
    public static function download(string $filename, $refilename = null)
    {
        // 验证文件
        if (!is_file($filename) || !is_readable($filename)) {
            return false;
        }

        // 重命名
        !isset($refilename) && ($refilename = $filename);

        // 获取文件大小
        $fileSize = filesize($filename);

        // 字节流
        header('Content-Type:application/octet-stream');
        header('Accept-Ranges: bytes');
        header('Accept-Length: ' . $fileSize);
        header('Content-Disposition: attachment;filename=' . basename($refilename));

        // 校验是否限速(超过1M自动限速,同时下载速度设为1M)
        $limit = 1 * 1024 * 1024;

        if ($fileSize <= $limit) {
            readfile($filename);
        } else {
            // 读取文件资源
            $file = fopen($filename, 'rb');

            // 强制结束缓冲并输出
            ob_end_clean();
            ob_implicit_flush();
            header('X-Accel-Buffering: no');

            // 读取位置标
            $count = 0;

            // 下载
            while (!feof($file) && $fileSize - $count > 0) {
                $res = fread($file, $limit);
                $count += $limit;
                echo $res;
                sleep(1);
            }

            fclose($file);
        }

        exit();
    }

    /**
     * @description: 只替换一次字符串
     * @param {string} needle 需要被替换掉的子串
     * @param {string} replace 需要替换为的子串
     * @param {string} haystack 整个字符串
     */
    public static function pregReplaceOnce($pattern, $haystack)
    {
        preg_match($pattern, $haystack, $matches);
        if (empty($matches)) {
            return false;
        }

        return preg_replace($pattern, '', $haystack, 1);
    }

    /**
     * @description: 只替换一次字符串
     * @param {string} needle 需要被替换掉的子串
     * @param {string} replace 需要替换为的子串
     * @param {string} haystack 整个字符串
     */
    public static function strReplaceOnce($needle, $replace, $haystack)
    {
        $index = strpos($haystack, $needle);
        if ($index === false) {
            return $haystack;
        }
        return substr_replace($haystack, $replace, $index, strlen($needle));
    }

    /**
     * @description: 保留键并打乱数组
     */
    public static function retainKeyShuffle(array &$arr)
    {
        if (!empty($arr)) {
            $key = array_keys($arr);
            shuffle($key);
            foreach ($key as $value) {
                $result[$value] = $arr[$value];
            }
            $arr = $result;
        }
    }

    /**
     * curl 程序上传文件
     * @param $filePath 文件地址
     * @param $params 请求参数
     * @param $url 请求地址
     */
    public static function curlUploadFile($filePath, $params, $url)
    {
        $ch = curl_init();
        $post_data = $params;
        $filePath = iconv("UTF-8", "GBK", realpath($filePath));
        $post_data['file'] = new \CURLFile($filePath);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // raw格式输出
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_exec($ch); // 执行并获取结果
        curl_close($ch); // 释放cURL句柄
    }
}
