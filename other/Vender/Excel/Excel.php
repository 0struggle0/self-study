<?php
require_once './PHPExcel.php';

class Excel
{
    /**
     * @function [通过Excel批量导入]
     */
    public function operationExcel()
    {
        try {
            //检查上传文件中是否有错误信息
            $this->getUploadFileErrMessage();

            // 检查文件是否有多个文件上传
            $this->checkUploadFile();

            $this->readExcel();
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @getUploadFileErrMessage [检查文件是否有多个文件上传]
     */
    private function getUploadFileErrMessage()
    {
        $str = '';
        $errorNumber = $_FILES["docxupload"]['error'][0];

        switch ($errorNumber) {  
            case 4: 
                $str = '请选择上传文件';
                Log::record('没有文件被上传');
                break;  
            case 3: 
                $str = '上传文件失败';
                Log::record('文件只有部分被上传');
                break;  
            case 2: 
                $str = '上传文件过大';
                Log::record('上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值');
                break;  
            case 1: 
                $str = '上传文件过大';
                Log::record('上传的文件超过了php.ini中upload_max_filesize选项限制的值');
                break;    
            case -2: 
                $str = '上传文件过大'; break;  
            case -3: 
                $str = '上传文件失败'; break;  
            case -4: 
                $str = '上传文件失败'; 
                Log::record('建立存放上传文件目录失败，请重新指定上传目录');
                break;  
            case -5: 
                $str = '上传文件失败';
                Log::record('必须指定上传文件的路径');
                break;
        } 

        if ($str) {
            throw new Exception($str);
        }
    }

    /**
     * @checkUploadFile [检查文件是否有多个文件上传]
     */
    private function checkUploadFile()
    {
        $fileInfomation = $_FILES["docxupload"];
        if (!empty($fileInfomation) && is_array($fileInfomation)) {
            if (count($fileInfomation['name']) > 1) {
                throw new Exception("一次只能上传一个文件");
            }
        }
    }

    /**
     * @readExcel [读取Excel文件内容]
     */
    private function readExcel()
    {
        $filename = $_FILES['file']['tmp_name'];
        $objReader = PHPExcel_IOFactory::createReaderForFile($filename);
        $objReader->setReadDataOnly(true);  
        $PHPExcel = PHPExcel_IOFactory::load($filename); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一个工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数

        /** 循环读取每个单元格的数据 */
        if ($highestRow >= 2) {
            for ($row = 2; $row <= $highestRow; $row++) {   //行号从2开始 
                $name = $this->clearTag($sheet->getCell('A'.$row)->getValue());
                $parentid = $this->clearTag($sheet->getCell('B'.$row)->getValue());
                $remark = $this->clearTag($sheet->getCell('C'.$row)->getValue());
            }
        } else {
            throw new Exception("请填写文件数据");
        }
    }

    /**
     * @function [通过Excel批量导入]
     */
    // public function excelRead()
    // {
    //     $errclass = array(); //导入失败错误信息数组
    //     $faildCount = 0;
    //     $excelHeaderOne = array(
    //         'clazzname'=>'班级名称',
    //         'parentid'=>'所属部门编号',
    //         'remark'=>'备注',
    //         'errorstring' => '错误原因'
    //     );

    //     // 成功数量， 失败数量。 
    //     if ($faildCount > 0) {
    //         array_unshift($errclass, $excelHeaderOne);
    //         $this->push($errclass, "导入失败({$faildCount}条)");
    //         unset($errclass);
    //     } else {
    //         echo '导入成功';
    //     }        
    // }

    /**
     * @function [导入失败的时候生成错误信息的excel]
     * @param [array] $data [excel文件中的内容]
     * @param [string]  $name [excel的文件名]
     */
    // public function push($data, $name = 'Excel')
    // {
    //     error_reporting(E_ALL);
    //     date_default_timezone_set('Europe/London');
    //     $objPHPExcel = new PHPExcel();

    //     // 设置作者、标题等
    //     $objPHPExcel->getProperties()
    //                 ->setCreator("ZZH")
    //                 ->setLastModifiedBy("ZZH")
    //                 ->setTitle("ZZH")
    //                 ->setSubject("ZZH")
    //                 ->setDescription("ZZH")
    //                 ->setKeywords("ZZH")
    //                 ->setCategory("result file");

    //     // 以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改
    //         foreach ($data as $k => $v) {
    //             $num = $k + 1;
    //             //从Excel的第一个sheet的第A列开始
    //             $objPHPExcel->setActiveSheetIndex(0)
    //                         ->setCellValueExplicit('A'.$num, $v['clazzname']) 
    //                         ->setCellValueExplicit('B'.$num, $v['parentid'])
    //                         ->setCellValueExplicit('C'.$num, $v['remark'])
    //                         ->setCellValueExplicit('D'.$num, $v['errorstring']);
    //         } 

    //     // 匹配IE浏览器的中文乱码
    //     $browser = $_SERVER['HTTP_USER_AGENT'];  
    //     if(preg_match('/MSIE/',$browser)) {  
    //         $name = str_replace('+','%20',urlencode($name));  
    //     }

    //     $objPHPExcel->getActiveSheet()->setTitle('User');
    //     $objPHPExcel->setActiveSheetIndex(0);

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    //     header('Cache-Control: max-age=0');
    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //     $objWriter->save('php://output');
    // }

    /**
     * @function [清除换行等符号]
     * @param [string] $str [导入的每个数据]
     */
    private function clearTag($str)
    {
        $tmp = trim($str);
        $tmp = preg_replace("/(\n)|(\t)|(\r')/" ,'' ,$str); 
        return $tmp;
    }
}

$testExcel = new Excel();
$testExcel->operationExcel();