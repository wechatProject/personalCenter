<?php

namespace Home\Controller;
use Think\Controller;


/**
 * 工作量统计
 *
 * 授课课时工作量  -- 没完成(没有给接口)
 */
class TeachWorkController extends Controller {
    public function index(){

        session('[start]');
        $_SESSION['userid'] = '1601210606';  //用于在网页进行测试

        $yearArr = getYearList();
        $this->assign('year',$yearArr);

        $this->display();
    }


    //获取该导师指导下的学生信息列表(接收前端StudentInfo/index.html的ajax请求)
    public function getCourselist() {

        //使用上述查询条件调用api获取学生列表
        $teacherid = $_SESSION['userid'];

        //获取筛选条件
        $year_name = $_POST['year_name'];
        $term_name = $_POST['term_name'];


        //获取课程信息数据包
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/TeacherInfo/getCourse?teacherid=".$teacherid."&yearid=".$year_name."&termid=".$term_name."&token=".$acc;

        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);
        $courseArr = $arr['data']['course'];

        //错误代码:0 - 无错误
        $error_code = $arr['errcode'];
        if($error_code == 0){ //无错误
            $result['meta']=array('code'=>"0");
            //保存课程信息
            $result['courselist']=$courseArr;
        }else if($error_code == 40901){ //token不正确
            $result['meta']=array('code' => "40901", 'error' => "error", 'info' => "error");
        } else{ //其他错误
            $result['meta']=array('code' => "49999", 'error' => "error", 'info' => "error");
        }

        $this->ajaxReturn($result);

    }

}

?>