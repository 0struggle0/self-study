<?php

/**
 * 利用阿里oss云存储来保存图片
 */

require_once './oss/autoload.php';

class UploadImages
{
    public function uploadImages()
    {
        try {
            // 验证上传过程中是否有错
            $this->validate();

            
        } catch (Exception $e) {
            
        }
    }

    /**
     * 验证图片上传过程中有没有错误
     */
    private function validate()
    {
        if (empty($_FILES['fileimage'])) {
            throw new Exception('没有文件上传');
        }

        $fileArray = $_FILES['fileimage']['error'];
        foreach ($fileArray as $errorNum) {
            $this->getUploadFileErrMessage($errorNum);
        }
    }

    /**
     * @checkUploadFile [检查文件是否有多个文件上传]
     * @param [string] $errorNumber [上传过程中的错误码]
     */
    private function getUploadFileErrMessage($errorNumber)
    {
        $str = '';

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
     * @function [批量上传照片]
     */
    public function importImage()
    {
        $fileArray = $_FILES['fileimage'];
        $names = array();
        $errors = array();
        if ($fileArray) {
            // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
            // $accessKeyId = 'oss.access_key_id'; 
            // $accessKeySecret = 'oss.access_key_secret'; 
            // $endpoint = 'oss.endpoint_inner'; // Endpoint以杭州为例，其它Region请按实际情况填写。
            // $bucket = 'oss.bucket.images'; // 存储空间名称
            // $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            // $address = 'oss.open';
            $InImages = array();
            $imageLength = count($fileArray['name']);

            if ($imageLength <= 200) {
                for ($key = 0; $key < $imageLength; $key++) {
                    $fileNamewithSuffix = $fileArray['name'][$key];
                    $tmp_name = $fileArray['tmp_name'][$key];
                    $fileNameTmp = explode('.',$fileNamewithSuffix);
                    $fileName = $fileNameTmp[0];

                    $file_name = $fileArray['name'][$key];
                    $file_name = iconv("UTF-8", "gbk", $file_name);
                    $local = BASE_UPLOAD_PATH.'/'.'teacherphotoes'.'/'.'school_'.0.'/'.'dept_'.0.'/';
                    $object = 'teacherphotoes/'.'school_'.0.'/'.'dept_'.0.'/'.sha1(microtime()). $file_name;
                    if ($address) {
                        $results= $ossClient->uploadFile($bucket, $object, $tmp_name);
                        if (!empty($avatar[$fileName])) {
                            if ($ossClient->doesObjectExist($bucket,$avatar[$fileName])) {
                                $ossClient->deleteObject($bucket,$avatar[$fileName]);
                            }
                        }

                    } else {
                        if (!is_dir($local)) {
                            mkdir($local,0777,true);
                        }
                        move_uploaded_file($tmp_name, BASE_UPLOAD_PATH.'/'.$object);
                        if (!empty($avatar[$fileName])) {

                            if (file_exists(BASE_UPLOAD_PATH.'/'.$avatar[$fileName])) {
                                unlink(BASE_UPLOAD_PATH.'/'.$avatar[$fileName]);
                            }
                        }
                    }

                    $InImages[] = $object;
                    // 如果库中有相应的guid， 那么上传完之后再删除原来的照片
                    $names[] = '("'.$adminid[$fileName].'","'.$fileName.'","'.$object.'","'.$schoolid.'")';
                    $updateArr[] = $adminid[$fileName];
                }
            }

            $succ = count($names);
            $fail = count($errors);
            
            if (!empty($names) && count($names) > 0) {
                $res = Model('admin')->updateAdminAvatar($names,$updateArr,$schoolid);
                if($res == false){
                    // 删除上传的照片
                    showMessage('导入教师照片失败');
                    if (is_array($InImages)&&count($InImages)>0) {
                        foreach ($InImages as $key => $value) {
                            if ($address) {
                                if ($ossClient->doesObjectExist($bucket,$value)) {
                                    $ossClient->deleteObject($bucket,$value);
                                }
                            } else {
                                if (file_exists(BASE_UPLOAD_PATH.'/'.$value)) {
                                    unlink(BASE_UPLOAD_PATH.'/'.$value);
                                }
                            }
                        }
                    }
                }
            }

            $this->log('批量导入教师照片成功'.$succ.'条;失败'.$fail.'条',1);

            if (count($errors) > 0) {
                $ress = $this->pushdown($errors,$this->admin_info['name']."未导入教师照片",'image');
            }

            showMessage('导入教师照片成功'.$succ.'条;失败'.$fail.'条');
        }
    }
}