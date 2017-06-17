<?php

namespace Home\Controller;


/**
 * 教师个人信息
 */
class TeacherInfoController extends CommonController{
    public function index(){
        $userid = $_SESSION['userid'];

        $acc = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        //用api获取前端状态信息
        $url = "https://api.mysspku.com/index.php/V2/TeacherInfo/getDetail?teacherid=".$userid."&token=".$acc;

        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);


        $userid = $_SESSION['userid']?$_SESSION['userid']:"无";
        $name = $arr['data']['name'];
        $gender = $arr['data']['gender'];
        $title = $arr['data']['title'];
        $telephone = $arr['data']['telephone'];
        $mail = $arr['data']['mail'];
        $imgurl = $arr['data']['imgurl'];


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
