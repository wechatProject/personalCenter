<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 工作量统计
 *
 * 综合实践工作量 -- 没完成(没有给接口)
 *
 */
class PracticeWorkController extends Controller {

    public function index(){

        session('[start]');
        $_SESSION['userid'] = '1601210606';  //用于在网页进行测试

        $yearArr = getYearList();
        $this->assign('year',$yearArr);


        $this->display();


    }

    public function getPracticeInfo(){

        $teacherId = $_SESSION['userid'];
        //获取筛选条件
        $year_name = $_POST['year_name'];


        $token = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = 'https://api.mysspku.com/index.php/V2/TeacherInfo/getPractise?teacherid='.$teacherId.'&token='.$token;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        $practiceArr = $arr['data']['practise'];

        $currentArr = array();
        foreach($practiceArr as $key => $value){
            if($value['year_name'] == $year_name){
                $currentArr[] = $value;
            }
        }


        //错误代码:0 - 无错误
        $error_code = $arr['errcode'];

        if($error_code == 0){ //无错误
            $result['meta']=array('code'=>"0");
            //保存综合事件信息
            $currentSortArr = array_sort($currentArr,'class','ascend');
            $result['practiceInfo']=$currentSortArr;
        }else if($error_code == 40901){ //token不正确
            $result['meta']=array('code' => "40901", 'error' => "error", 'info' => "error");
        }else{ //其他错误
            $result['meta']=array('code' => "49999", 'error' => "error", 'info' => "error");
        }


        $this->ajaxReturn($result);
    }

}

?>