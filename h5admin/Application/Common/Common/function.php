<?php

//将取到的导师下学生信息(二维数组)根据$row(学号)进行排序
function array_sort($array,$row){
    $array_temp = array();
    foreach($array as $v){
        $array_temp[$v[$row]] = $v;
    }
    ksort($array_temp);
    $new_array = array();

    $num = 0;
    foreach($array_temp as $v){
        $new_array[$num] = $v;
        $num = $num+1;
    }

    return $new_array;
}


?>