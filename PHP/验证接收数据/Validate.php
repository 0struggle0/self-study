<?php

/**
 * 用户输入规则验证类
 * author   zzh
 */

class Validate
{ 
    // 验证规则
    private $ruleName = array(
        'requird', //是否为空
        'ifset', //是否存在
        'ifnull', //是否为null
        'ifnan', //是否为nan
        'ifint', // 是否为整型
        'ifstring', //是否为字符串型
        'iffloat', //是否为浮点型
        'ifboolean', //是否为布尔型
        'ifarray', //是否为数组
        'ifobject', //是否为对象
        'email',  // 匹配邮箱
        'judgecourse',  // 验证题库是否存在
    );
 
    /**
     * verify  [验证函数]
     * @param  [array] $data [验证的数据]
     * @param  [array] $validateRule [验证规则]
     * @param  [array] $validateErrorMessage [错误信息提示]
     * @return [bool] [成功返回true, 失败返回错误信息]
     */ 
    public function verify($data, $validateRule, $validateErrorMessage = '')
    { 
        if (empty($data) || !is_array($data)) return false;
        if (empty($validateRule)  || !is_array($validateRule)) return false;

        foreach ($data as $filedName => $fieldValue) {
            if (!empty($validateRule[$filedName])) {
                $correspondingRule = $validateRule[$filedName]; //如果有对应字段的验证规则，则走对应验证

                foreach ($correspondingRule as $validateRuleName => $isValidate) {
                    if (!in_array($validateRuleName, $this->ruleName)) {
                        return array('code' => 500, 'msg' => '验证失败');
                    } else {
                        if ($isValidate == true) {
                            if (!$this->$validateRuleName($fieldValue)) {
                                if (empty($validateErrorMessage[$filedName][$validateRuleName])) {
                                    return array('code' => 500, 'msg' => '数据为空或者格式不正确');
                                } else {
                                    return array('code' => 500, 'msg' => $validateErrorMessage[$filedName][$validateRuleName]); 
                                }
                            } 
                        }
                    }
                }
            }
        } 

        return array('code' => 200, 'msg' => '');
    }
 
    // 获取规则数组  
    public function getRuleName()
    { 
        return $this->ruleName; 
    }
 
    // 验证是否为空
    public function requird($parameter)
    { 
        if (empty($parameter)) {
            return false; 
        } else {
            return true;
        }
    }

    // 验证是否为null
    public function ifnull($parameter)
    {
        if (is_null($parameter)) {
            return false;
        } else {
            return true;
        }
    }

    // 验证是否存在
    public function ifset($parameter)
    {
        if (isset($parameter)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证是否为nan
    public function ifnan($parameter)
    {
        if (is_nan($parameter)) {
            return false;
        } else {
            return true;
        }
    }

    // 验证是否为整型
    public function ifint($number)
    {
        if (is_int($number)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证是否为字符串
    public function ifstring($string)
    {
        if (is_string($string)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证是否为浮点型
    public function iffloat($number)
    {
        if (is_float($number)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证是否为布尔型
    public function ifboolean($parameter)
    {
        if (is_bool($parameter)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证是否为数组
    public function ifarray($array)
    {
        if (is_array($array)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证是否为对象
    public function ifobject($array)
    {
        if (is_object($array)) {
            return true;
        } else {
            return false;
        }
    }

    // 验证邮件格式
    public function email($string)
    { 
        if (!is_string($string)) return false;

        if (preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $string)) {
            return true; 
        } else {
            return false;
        }
    } 
    
    // 验证题库是否存在
    public function judgecourse($courseId)
    { 
        if (!is_int($courseId)) return false;

        
    }
    
}