<?php

namespace Home\Controller;
//use Think\Controller;

/**
 * 工作量统计
 *
 * 综合实践工作量
 *
 */
class PracticeWorkController extends CommonController {

    public function index(){
        //获取学年列表 , 用于前端筛选条件
        $yearArr = getYearList();
        $this->assign('year',$yearArr);

        $this->display();

    }

    /**
     * 获取综合实践信息 (接收前端base.js中的ajax请求)
     */
    public function getPracticeInfo(){
        //获取信息接口token
        $token =  C('ACCESS_TOKEN');

        //获取教师id
        $teacherId = $_SESSION['userid'];
        //获取前端输入的筛选条件
        $year_name = $_POST['year_name'];

        //获取综合实践工作量json数据包(来源:老师给的接口)
        $url = 'https://api.mysspku.com/index.php/V2/TeacherInfo/getPractise?teacherid='.$teacherId.'&token='.$token;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //前端页面需要的综合实践数据
        $practiceArr = $arr['data']['practise'];

        //满足筛选条件(按学年)的综合实践信息
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