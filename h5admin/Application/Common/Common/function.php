<?php

//将取到的导师下学生信息(二维数组)根据$row(学号)进行排序
function array_sort($array,$row){
    $array_temp = array();
    foreach($array as $v){
        $array_temp[$v[$row]] = $v;
    }
    krsort($array_temp);
    $new_array = array();

    $num = 0;
    foreach($array_temp as $v){
        $new_array[$num] = $v;
        $num = $num+1;
    }

    return $new_array;
}

//获取学年列表
function getYearList(){
    $token = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
    $url = 'https://api.mysspku.com/index.php/V2/Public/getYearList?token='.$token;
    //返回json数据包
    $json = file_get_contents($url);
    //将json格式转换为数组
    $arr = json_decode($json,true);

    if($arr['errcode'] == 0){
        $sortArr = array_sort($arr['data'],'order');
        return $sortArr;
    }
    return $arr;

}

//获取学期列表
function getTermList(){
    $token = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
    $url = 'https://api.mysspku.com/index.php/V2/Public/getTermList?token='.$token;
    //返回json数据包
    $json = file_get_contents($url);
    //将json格式转换为数组
    $arr = json_decode($json,true);

    return $arr;

}


?>