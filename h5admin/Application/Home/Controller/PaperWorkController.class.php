<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 工作量统计
 *
 * 指导论文工作量
 *
 */
class PaperWorkController extends Controller {

    public function index(){
        //获取学年列表 , 用于前端筛选条件
        $yearArr = getYearList();
        $this->assign('year',$yearArr);

        $this->display();
    }

    /**
     * 获取论文工作量数据 (接收前端base.js中的ajax请求)
     */
    public function getPaperInfo(){

        //获取教师id
        $teacherId = $_SESSION['userid'];

        //获取前端输入的筛选条件
        $yearId = $_POST['yearPara'];

        //获取论文工作量json数据包(来源:老师给的接口)
        $token = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = 'https://api.mysspku.com/index.php/V2/TeacherInfo/getPaper?teacherid='.$teacherId.'&yearid='.$yearId.'&token='.$token;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);
        //前端页面需要的数据
        $paperArr = $arr['data']['paper'];

        //错误代码:0 - 无错误
        $error_code = $arr['errcode'];

        //返回给前端的数据
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