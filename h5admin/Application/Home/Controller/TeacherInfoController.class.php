<?php

namespace Home\Controller;


/**
 * 教师个人信息
 */
class TeacherInfoController extends CommonController{
    public function index(){
        //获取信息接口token
        $acc = C('ACCESS_TOKEN');
//        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        //获取教师ID
        $userid = $_SESSION['userid'];

        //用api获取前端状态信息
        $url = "https://api.mysspku.com/index.php/V2/TeacherInfo/getDetail?teacherid=".$userid."&token=".$acc;

        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //前端需要显示的状态信息
        $userid = $_SESSION['userid']?$_SESSION['userid']:"无";
        $name = $arr['data']['name']?$arr['data']['name']:"";
        $gender = $arr['data']['gender']?$arr['data']['gender']:"";
        $title = $arr['data']['title']?$arr['data']['title']:"无";
        $telephone = $arr['data']['telephone']?$arr['data']['telephone']:"无";
        $mail = $arr['data']['mail']?$arr['data']['mail']:"无";
        $imgurl = $arr['data']['imgurl']?$arr['data']['imgurl']:"";


        //将状态信息赋值到前端
        $this->assign('userid',$userid);
        $this->assign('name',$name);
        $this->assign('gender',$gender);
        $this->assign('title',$title);
        $this->assign('telephone',$telephone);
        $this->assign('mail',$mail);
        $this->assign('imgurl',$imgurl);

        $this->display();
    }
}

?>
