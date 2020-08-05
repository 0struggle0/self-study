<?php

#对多维数组进行排序
/**
 * @param array $arr 需要排序的数组
 * @param array $keys 排序的键名数组
 * @param array $order 排序的键名对应的排序规则
 * @return bool|mixed
 */
function sort_array_multi(array &$arr, array $keys, array $order)
{
    //校验参数
    if ( count($keys) == ($times = count($order)) ) {
        for ( $i = 0, $j = 0; $j < $times; $i += 2, $j++ ) {
            foreach ( $arr as $k => $v ) {
                //原数组是否存在该字段
                if ( isset($v[$keys[$j]]) ) {
                    $params[$i][] = $v[$keys[$j]];    //TODO 中文排序支持
                } else {
                    return false;
                }
            }
            if ( strtoupper($order[$j]) == 'ASC' ) {
                $params[$i + 1] = SORT_ASC;
            } else {
                $params[$i + 1] = SORT_DESC;
            }
        }
        $params[] = &$arr;
        return call_user_func_array('array_multisort', $params);
    } else {
        return false;
    }
}


$data = [
    ['name' => 1, 'score' => 2.2],
    ['name' => 2, 'score' => 3.3],
    ['name' => 4, 'score' => 2.5],
    ['name' => 1, 'score' => 1.1],
    ['name' => 0, 'score' => 4],
];

//调用方法
sort_array_multi($data, ['name', 'score'], ['asc', 'desc']);


// 第二步
// 通过call_user_func_array方法将array_multisort的不定参数参数以数组的方式注入到方法中，省去了每次都要手动的拼接参数,最后排序成功返回true，失败返回false
// $n = count($order);
// $params数组说明：
// $params[0]是需要排列的数组keys的第0项在原数组二维$data中的全部的name字段的值，等价于array_column($data, 'name')；
// $params[1]是需要排列的数组keys的第0项对应排序规则$order中的升降序；
// $params[3]是需要排列的数组keys的第1项在原数组二维$data中的全部的score字段的值 等价于array_column($data, 'score')；
// $params[4]是需要排列的数组keys的第1项对应排序规则$order中的升降序；
// ......
// $params[2*$n+1]是需要排列的原数组$data的引用；

// 第三步  中文排序的支持
//刚才的代码中对中文utf-8排序的支持显然是不够好的，这里稍微改造一下将uft-8转为gbk编码就能很好的支持中文排序了
// $params[$i][] = iconv('UTF-8', 'GBK', $v[$keys[$j]]);