<?php

declare(strict_types=1);

namespace devkeep\Tools;

class Tools
{
    /**
     * 获取系统类型
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
     * format 保留两位小数
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
     * 对象转数组
     *
     * @param object $object 对象
     * 
     * @return array
     */
    public static function toArray(object $object): array
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * 无限级归类
     *
     * @param array $list 归类的数组
     * @param string $id 父级ID
     * @param string $pid 父级PID
     * @param string $child key
     * @param string $root 顶级
     *
     * @return array
     */
    public static function tree(array $list, string $pk = 'id', string $pid = 'pid', string $child = 'child', int $root = 0): array
    {
        $tree = [];

        if (is_array($list)) {
            $refer = [];

            //基于数组的指针(引用) 并 同步改变数组
            foreach ($list as $key => $val) {
                $list[$key][$child] = [];
                $refer[$val[$pk]] = &$list[$key];
            }

            foreach ($list as $key => $val) {
                //是否存在parent
                $parentId = isset($val[$pid]) ? $val[$pid] : $root;

                if ($root == $parentId) {
                    $tree[$val[$pk]] = &$list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $refer[$parentId][$child][] = &$list[$key];
                    }
                }
            }
        }

        return array_values($tree);
    }

    /**
     * 根据子级找父顶级
     * 
     * @param array $input 需查找的二维数组
     * @param array $id 子级ID
     * @return array
     */
    public static function parentFind(array $input, $id, array $res = [], string $childField = 'id', string $parentField = 'pid'): array
    {
        $pid = -1;

        foreach ($input as $key => $val) {
            if ($val[$childField] == $id) {
                $pid = $val[$parentField];
                $res = $val;
                unset($input[$key]);
                break;
            }
        }

        foreach ($input as $key => $val) {
            if ($val[$childField] == $pid) {
                $res = self::parentFind($input, $val[$childField], $val, $childField, $parentField);
                break;
            }
        }

        return $res;
    }


    /**
     * 排列组合
     * 
     * @param array $input 排列的数组
     * 
     * @return array
     */
    public static function arrayArrange(array $input): array
    {
        $temp = [];
        $result = array_shift($input);

        while ($item = array_shift($input)) {
            $temp = $result;
            $result = [];

            foreach ($temp as $v) {
                foreach ($item as $val) {
                    $result[] = array_merge_recursive($v, $val);
                }
            }
        }

        return $result;
    }

    /**
     * 二维数组去重
     *
     * @param array $arr 数组
     * @param string $key 字段
     *
     * @return array
     */
    public static function arrayMultiUnique(array $arr, string $key = 'id'): array
    {
        $res = [];

        foreach ($arr as $value) {
            if (!isset($res[$value[$key]])) {
                $res[$value[$key]] = $value;
            }
        }

        return array_values($res);
    }

    /**
     * 二维数组排序
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

        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$keys];
        }

        $orderSort = [
            'asc'  => SORT_ASC,
            'desc' => SORT_DESC,
        ];

        array_multisort($keysValue, $orderSort[$sort], $array);

        return $array;
    }

    /**
     * XML转数组
     *
     * @param string $xml xml
     *
     * @return array
     */
    public static function xmlToArray(string $xml): array
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result = json_decode(json_encode($xmlString), true);
        return $result;
    }

    /**
     * 数组转XML
     *
     * @param array $input 数组
     *
     * @return string
     */
    public static function arrayToXml(array $input): string
    {
        $str = '<xml>';

        foreach ($input as $k => $v) {
            $str .= '<' . $k . '>' . $v . '</' . $k . '>';
        }

        $str .= '</xml>';

        return $str;
    }

    /**
     * get请求
     *
     * @param string $url URL地址
     * @param string $header header头
     *
     * @return mixed
     */
    public static function get(string $url, $header = null)
    {
        $ch = curl_init();

        if (isset($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Post请求
     *
     * @param string $url URL地址
     * @param string $param 参数
     * @param string $dataType 数据类型
     *
     * @return mixed
     */
    public static function post(string $url, $param = '', string $dataType = 'form')
    {
        $dataTypeArr = [
            'form' => ['content-type: application/x-www-form-urlencoded;charset=UTF-8'],
            'json' => ['Content-Type: application/json;charset=utf-8'],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $dataTypeArr[$dataType]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = trim($result, "\xEF\xBB\xBF");
        return $result;
    }

    /**
     * 文件打包下载

     * @param string $downloadZip 打包后下载的文件名
     * @param array $list 打包文件组

     * @return void
     */
    public static function addZip(string $downloadZip, array $list)
    {
        // 初始化Zip并打开
        $zip = new \ZipArchive();

        // 初始化
        $bool = $zip->open($downloadZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        if ($bool === TRUE) {
            foreach ($list as $key => $val) {
                // 把文件追加到Zip包并重命名  
                // $zip->addFile($val[0]);
                // $zip->renameName($val[0], $val[1]);

                // 把文件追加到Zip包
                $zip->addFile($val, basename($val));
            }
        } else {
            exit('ZipArchive打开失败，错误代码：' . $bool);
        }

        // 关闭Zip对象
        $zip->close();

        // 下载Zip包
        header('Cache-Control: max-age=0');
        header('Content-Description: File Transfer');
        header('Content-disposition: attachment; filename=' . basename($downloadZip));
        header('Content-Type: application/zip');                     // zip格式的
        header('Content-Transfer-Encoding: binary');                 // 二进制文件
        header('Content-Length: ' . filesize($downloadZip));          // 文件大小
        readfile($downloadZip);

        exit();
    }

    /**
     * 解压压缩包

     * @param string $zipName 要解压的压缩包
     * @param string $dest 解压到指定目录

     * @return boolean
     */
    public static function unZip(string $zipName, string $dest): bool
    {
        //检测要解压压缩包是否存在
        if (!is_file($zipName)) {
            return false;
        }

        //检测目标路径是否存在
        if (!is_dir($dest)) {
            mkdir($dest, 0777, true);
        }

        // 初始化Zip并打开
        $zip = new \ZipArchive();

        // 打开并解压
        if ($zip->open($zipName)) {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 文件下载

     * @param string $filename 要下载的文件
     * @param string $refilename 下载后的命名

     * @return void
     */
    public static function download(string $filename, $refilename = null)
    {
        // 验证文件
        if (!is_file($filename) || !is_readable($filename)) {
            return false;
        }

        // 获取文件大小
        $fileSize = filesize($filename);

        // 重命名
        !isset($refilename) && $refilename = $filename;

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
     * 导出excel表格

     * @param array   $columName  第一行的列名称
     * @param array   $list       二维数组
     * @param array   $fileName   文件名称
     * @param string  $setTitle   sheet名称
     * @param string  $table   表单元格，用于合并
     *
     * @return void
     */
    public static function exportExcel(array $columName, array $list, string $fileName = 'demo', string $setTitle = 'Sheet1', array $table = [])
    {
        if (empty($columName) || empty($list)) {
            return '列名或者内容不能为空';
        }

        if (count($list[0]) != count($columName)) {
            return '列名跟数据的列不一致';
        }

        //实例化PHPExcel类
        $PHPExcel = new \PHPExcel();

        //获得当前sheet对象
        $PHPSheet = $PHPExcel->getActiveSheet();

        //定义sheet名称
        $PHPSheet->setTitle($setTitle);

        //Excel列
        $letter = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK',
        ];

        // 设置字体大小
        $PHPSheet->getDefaultStyle()->getFont()->setSize(12);

        // 水平居中
        $PHPSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 垂直居中
        $PHPSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // 合并单元格
        if (count($table) > 0) {
            foreach ($table as $res) {
                $PHPSheet->mergeCells($res);
            }
        }

        //把列名写入第1行
        for ($i = 0; $i < count($list[0]); $i++) {
            //$letter[$i]1 = A1 B1 C1  $letter[$i] = 列1 列2 列3

            // 第一行加粗
            $PHPSheet->getStyle($letter[$i] . '1')->getFont()->setBold(true);

            // 设置值
            $PHPSheet->setCellValue("$letter[$i]1", "$columName[$i]");
        }

        //内容第2行开始
        foreach ($list as $key => $val) {
            //array_values 把一维数组的键转为0 1 2 ..
            foreach (array_values($val) as $key2 => $val2) {
                //$letter[$key2].($key+2) = A2 B2 C2 ……
                $PHPSheet->setCellValue($letter[$key2] . ($key + 2), $val2);

                // 自动换行
                $PHPSheet->getStyle($letter[$key2] . ($key + 2))->getAlignment()->setWrapText(true);
            }
        }

        //生成2007版本的xlsx
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        $PHPWriter->save("php://output");
    }

    /**
     * 发送邮件

     * @param array  $form 发件人信息
     * @param array  $data 收件人信息
     *
     * @return mixed
     */
    public static function sendMail(array $form, array $data)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);       // 实例化PHPMailer对象
        $mail->CharSet = 'UTF-8';                               // 设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->isSMTP();                                        // 设定使用SMTP服务
        $mail->SMTPDebug = 0;                                   // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
        $mail->SMTPAuth = true;                                 // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'ssl';                              // 使用安全协议
        $mail->isHTML(true);

        // 发件人信息
        $mail->Host = $form['host'];                            // SMTP 服务器
        $mail->Port = $form['port'];                            // SMTP服务器的端口号
        $mail->Username = $form['username'];                    // SMTP服务器用户名
        $mail->Password = $form['password'];                    // SMTP服务器密码
        $mail->SetFrom($form['address'], $form['title']);

        // 阿里云邮箱
        // $mail->Host = "smtp.aliyun.com";                          // SMTP 服务器
        // $mail->Port = 465;                                        // SMTP服务器的端口号
        // $mail->Username = "devkeep@aliyun.com";                   // SMTP服务器用户名
        // $mail->Password = "xxxxxxxxxxxx";                         // SMTP服务器密码
        // $mail->SetFrom('devkeep@aliyun.com', '项目完成通知');

        // 网易邮箱
        // $mail->Host = "smtp.163.com";                           // SMTP 服务器
        // $mail->Port = 465;                                      // SMTP服务器的端口号
        // $mail->Username = "devkeep@163.cc";                     // SMTP服务器用户名
        // $mail->Password = "xxxxxxxxx";                          // SMTP服务器密码
        // $mail->SetFrom('devkeep@163.cc', '系统通知');

        // QQ邮箱
        // $mail->Host = "smtp.qq.com";                            // SMTP 服务器
        // $mail->Port = 465;                                      // SMTP服务器的端口号
        // $mail->Username = "363927173@qq.com";                   // SMTP服务器用户名
        // $mail->Password = "xxxxxxxxxxxxxxxx";                   // SMTP服务器密码
        // $mail->SetFrom('devkeep@skeep.cc', '管理系统');

        // 收件人信息
        $mail->Subject = $data['subject'];
        $mail->MsgHTML($data['body']);
        $mail->AddAddress($data['mail'], $data['name']);

        // $mail->Subject = $subject;
        // $mail->MsgHTML($body);
        // $mail->AddAddress($tomail, $name);

        // 是否携带附件
        if (isset($data['attachment'])) {
            foreach ($attachment as $file) {
                is_file($file) && $mail->AddAttachment($file);
            }
        }


        return $mail->Send() ? true : $mail->ErrorInfo;
    }

    /**
     * 生成二维码

     * @param array  $text 二维码内容
     * @param array  $outfile 文件
     * @param array  $level 纠错级别
     * @param array  $size 二维码大小
     * @param array  $margin 边距
     * @param array  $saveandprint
     *
     * @return void
     */
    public static function qrcode(string $text, $outfile = false, string $level = QR_ECLEVEL_L, int $size = 6, int $margin = 2, bool $saveandprint = false)
    {
        QRcode::png($text, $outfile, $level, $size, $margin, $saveandprint);

        exit();
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
}
