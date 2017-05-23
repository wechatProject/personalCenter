<?php

namespace Home\Controller;


class StudentInfoController extends CommonController{
    public function index(){
        $userid = $_SESSION['userid'];

        //用api获取前端状态信息
        //将状态信息赋值到前端
        $this->assign('id',$userid);

        $this->display();
    }

    public function studentlist(){
        $studentId      = I('post.studentId',1601210606);
        $studentName    = $_POST['studentName'];
        $studentYear    = $_POST['studentYear'];
        $studyStatus    = $_POST['studyStatus'];
        $practiceStatus = $_POST['practiceStatus'];
        $paperStatus    = $_POST['paperStatus'];

        //使用上述查询条件调用api获取学生列表

        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getDetail?stuid=".$studentId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        $name = $arr['data']['name'];

        //将学生列表赋值到前端foreach 打印出来
        $stuId = '1601210606';
        $this->assign('stuId',$stuId);

//        trace($studentId,'呱？=');
        $this->display();
    }

    public function studentinfo(){
        $stuId = $_GET['stuId'];
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getDetail?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);
        $name = $arr['data']['name'];
        $gender = $arr['data']['gender'];
        $researcharea = $arr['data']['researcharea'];
        $major = $arr['data']['major_name'];
        $mail = $arr['data']['mail'];
        $telephone = $arr['data']['telephone'];
        $grade = $arr['data']['grade'];
        $imgurl = $arr['data']['imgurl'];
        $location = $arr['data']['location'];     //校区

        $this->assign('stuId', $stuId);
        $this->assign('name' , $name);
        $this->assign('gender', $gender);
        $this->assign('researcharea', $researcharea);
        $this->assign('major', $major);
        $this->assign('mail',$mail);
        $this->assign('telephone',$telephone);
        $this->assign('grade',$grade);
        $this->assign('imgurl',$imgurl);
        $this->assign('location',$location);

        $this->display();
    }

    //实习立项
    public function stupractice(){
        $this->display();
    }

    //论文
    public function stuthesis(){
        $this->display();
    }

    //答辩
    public function thesisdefense(){
        $this->display();
    }
}

?>
