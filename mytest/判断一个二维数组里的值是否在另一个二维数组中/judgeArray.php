<?php

/**
 * @function[arrayInArray]   [判断一个二维数组里的值是否在另一个二维数组中]
 * @param        [array] $datas [一个二维数组]
 * @param        [array] $data  [另一个二维数组的值]
 * @return       [boolean] [是否在这个数组中]
 */
private function arrayInArray($datas, $data, $index)
{
    $result = false;

    if (!empty($datas) && empty($data) && empty($index)) {
    	$strData = $data[$index];
	    foreach ($datas as $key => $value) {
	        $strValue = $value[$index];

	        if ($strData == $strValue) {
	            $result = true;
	            break;
	        }
	    }
    }

    return $result;
}