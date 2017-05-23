<?php

namespace Home\Controller;


class StudentInfoController extends CommonController  {
    public function index(){
        $userid = $_SESSION['userid'];

        //用api获取前端状态信息
        //将状态信息赋值到前端
        $this->assign('id',$userid);

        $this->display();
    }

    public function studentlist(){
        $studentId      = $_POST['studentId'];
        $studentName    = $_POST['studentName'];
        $studentYear    = $_POST['studentYear'];
        $studyStatus    = $_POST['studyStatus'];
        $practiceStatus = $_POST['practiceStatus'];
        $paperStatus    = $_POST['paperStatus'];

        //使用上述查询条件调用api获取学生列表
        //将学生列表赋值到前端foreach 打印出来
        $stuId = '1601210606';
        $this->assign('stuId',$stuId);

        trace($studentId,'呱？=');
        $this->display();
    }

    public function studentinfo(){
        $stuId = $_GET['stuId'];
        trace($stuId,'哈？=');
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
