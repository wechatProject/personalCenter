<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 工作量统计
 *
 * 指导论文工作量  -- 没完成(没有给接口)
 *
 */
class PaperWorkController extends Controller {

    public function index(){

        $yearArr = getYearList();
        $this->assign('year',$yearArr);


        $this->display();
    }

    public function getPaperInfo(){

        $teacherId = $_SESSION['userid'];
        //获取筛选条件
        $yearId = $_POST['yearPara'];


        $token = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = 'https://api.mysspku.com/index.php/V2/TeacherInfo/getPaper?teacherid='.$teacherId.'&yearid='.$yearId.'&token='.$token;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        $paperArr = $arr['data']['paper'];

        //错误代码:0 - 无错误
        $error_code = $arr['errcode'];

        if($error_code == 0){ //无错误
            $result['meta']=array('code'=>"0");
            //保存综合事件信息
            $result['paperInfo']=$paperArr;
        }else if($error_code == 40901){ //token不正确
            $result['meta']=array('code' => "40901", 'error' => "error", 'info' => "error");
        }else{ //其他错误
            $result['meta']=array('code' => "49999", 'error' => "error", 'info' => "error");
        }

        $this->ajaxReturn($result);
    }


}

?>