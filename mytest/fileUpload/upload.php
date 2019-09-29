<?php

/**
 * 文件上传类
 */
class FileUpload
{
	private $oldName; //上传文件原名
	private $newName; //重命名后的文件名
	private $suffix; //上传文件后缀
	private $fileSize; //上传文件大小
	private $limitFileSize; //设置允许上传文件的大小
	private $fileType; //上传文件类型
	private $allowType = array(); //设置允许上传文件的类型
	private $errorMessage = ''; //错误信息
	private $error; //上传文件数组中的error代码
	private $filePath; //设置上传文件的路径
	private $tmpFileName; //上传文件临时文件名
	private $upload; //上传文件移动到指定路径

	/**
	 * @function[__construct]     [构造函数，初始化文件大小及类型]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @param        [size][int or string][允许上传文件的大小]
	 * @param        [typearr][array or string][允许上传文件的类型]
	 */
	public function __construct($size, $typearr, $path)
	{
		if ($size > 0 && !empty($typearr) && !empty($path)) {
			$this->limitFileSize = $size;
			$this->filePath = $path;
			$this->allowType = $this->getAllowType($typearr);
		} else {
			exit('请正确设置上传文件的大小、类型及路径');
		}
	}

	/**
	 * @function[upload]     [上传文件函数]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @param        [file][array][超全局数组_FILE里的信息]
	 * @return       [type][上传文件的信息]
	 */
	public function upload($file)
	{
		if (empty($file)) {
			return '上传文件失败';
		}
		var_dump($file);
		$fileNum = count($file['name']); //获取上传文件的数量
		// if ($fileNum == 1) {
		// 	$this->tmpFileName = $file['tmp_name'];
		// 	$this->oldName = $file['name'];
		// 	$this->suffix = $this->getFileInfo($this->oldName,PATHINFO_EXTENSION);
		// 	$this->fileSize = $file['size'];
		// 	$this->error = $file['error'];
		// 	$this->getError($this->error);
		// 	if (!empty($this->errorMessage)) {
		// 		return $this->errorMessage;
		// 	}

		// 	// is_uploaded_file — 判断文件是否是通过 HTTP POST 上传的；可以用来确保恶意的用户无法欺骗脚本去访问本不能访问的文件
		// 	if (!is_uploaded_file($this->tmpFileName)) {
		// 		return '上传文件失败';
		// 	}

		// 	if ($this->fileSize > $this->limitFileSize) {
		// 		return '上传文件过大';
		// 	}

		// 	if (!in_array($this->suffix, $this->allowType)) {
		// 		return '上传文件类型不符合要求';
		// 	}
		// 	$this->setNewFile(); //设置新的文件名
		// 	$this->$upload = $this->filePath.$this->newName;
		// 	if(move_uploaded_file($this->tmpFileName, $this->upload)){
		//         return array('name' => $this->newName, 'oldname' => $this->oldName,'url'=>$this->$upload,'suffix' => $this->suffix, 'size' => $this->fileSize);;
		//     } else {
		//         return '移动文件失败';
		//     }
		// } else {
		$errorArray = array(); 
		for ($i = 0; $i < $fileNum; $i++) { 
			$this->tmpFileName = $file['tmp_name'][$i];
			$this->oldName = $file['name'][$i];
			$this->suffix = $this->getFileInfo($this->oldName);
			$this->suffix = '.'.$this->suffix;
			$this->fileSize = $file['size'][$i];
			$this->error = $file['error'][$i];
			$this->getError($this->error);
			if (!empty($this->errorMessage)) {
				$errorArray[] = $this->errorMessage;
			}

			// is_uploaded_file — 判断文件是否是通过 HTTP POST 上传的；可以用来确保恶意的用户无法欺骗脚本去访问本不能访问的文件
			if (!is_uploaded_file($this->tmpFileName)) {
				$errorArray[] = '上传文件失败';
			}

			if ($this->fileSize > $this->limitFileSize) {
				$errorArray[] = '上传文件过大';
			}

			if (!in_array($this->suffix, $this->allowType)) {
				$errorArray[] = '上传文件类型不符合要求';
			}
			$this->setNewFile('guid'); //设置新的文件名
			$this->upload = $this->filePath.'/'.$this->newName.$this->suffix;
			if(move_uploaded_file($this->tmpFileName, $this->upload)){
		        $fileUploadArray[] = array('name' => $this->newName, 'oldname' => $this->oldName,'url'=>$this->upload,'suffix' => $this->suffix, 'size' => $this->fileSize);;
		    } else {
		        $errorArray[] = '移动文件失败';
		    }
		}

		// if (!empty($errorArray)) {
		// 	return $errorArray;
		// }
		return $fileUploadArray;
		// }
	}

	/**
	 * @function[getError]   [获取上传文件的错误信息]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @param        [error][int][上传文件数组中的错误代码]
	 */
	private function getError($error)
	{
		switch ($error) {
			case 0:
				$this->errorMessage = '';
				break;
			case 1:
				$this->errorMessage = '上传的文件超过了php.ini中upload_max_filesize选项限制的值';
				break;
			case 2:
				$this->errorMessage = '上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值';
				break;
			case 3:
				$this->errorMessage = '文件只有部分被上传';
				break;
			case 4:
				$this->errorMessage = '没有文件被上传';
				break;
			case 5:
				$this->errorMessage = '上传文件大小为0';
				break;
			default:
				$this->errorMessage = '上传文件失败';
				break;
		}
	}

	/**
	 * @function[getAllowType]   [把设置允许上传文件的类型组成数组]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @param        [type][array or string][设置允许上传文件的类型]
	 * @return       [array][允许上传文件的类型的数组]
	 */
	private function getAllowType($type)
	{	
		if (is_array($type)) {
			foreach ($type as $key => $value) {
				$allowType[] = $value;
			}
		} elseif (is_string($type)) {
			$allowType = preg_split("/[\s,|;]+/", $allow_type); //通过正则函数把字符串变为数组
		} else {
			return '请正确设置上传类型';
		}
		return $allowType;
	}

	/**
	 * @function[getFileInfo]   [获取文件路径的信息]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @param        [fileName][string][上传文件的name]
	 * @return       [pathInfo][路径信息]
	 */
	private function getFileInfo($fileName)
	{
		$pathInfo = pathinfo($fileName,PATHINFO_EXTENSION);
		return $pathInfo;
	}

	/**
	 * @function[setNewFile]   [重命名文件]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @param        [type][string][重命名的方式]
	 */
	private function setNewFile($type)
	{
		if ($type == 'guid') {
			$this->newName = trim($this->guid(),'{}');
		} elseif ($type == 'ymd') {
			$this->newName = $this->ymdName();
		}
	}

	/**
	 * @function[guid]   [生成guid唯一码]
	 * @author [zzh]
	 * @creationtime [2018-06-04]
	 * @updator      [zzh]
	 * @updatetime   [2018-06-04]
	 * @return       [string][guid唯一码]
	 */
	public function guid()
    {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            mt_srand((double) microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid   = chr(123)
            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12)
            . chr(125);
            return $uuid;
        }
    }

    /**
     * @function[ymdName]   [生成年月日加随机数的文件名]
     * @author [zzh]
     * @creationtime [2018-06-04]
     * @updator      [zzh]
     * @updatetime   [2018-06-04]
     * @return       [string][年月日加随机数的文件名]
     */
    private function ymdName()
    {
    	$date = date('Y-m-d H:i:s',time());
    	$random = mt_rand(100000, 999999);
    	return $date.':'.$random;
    }
}