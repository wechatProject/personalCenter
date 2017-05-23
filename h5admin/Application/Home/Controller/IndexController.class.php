<?php

namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function index(){
        $s = "瓜皮harper！";
        $arr = [];
        for($i=0;$i<10;$i++){
            $arr[] = $i;
        }
        $this->assign('hello',$arr);
        $this->display();

//        if($_SESSION['openid']!=null){
//            $openid = $_SESSION['openid'];
//
//            $map['openid'] = array('eq', intval($openid));
//            $teacher = M('teacher');
//            $trow = $teacher->where($map)->find();
//            $department = $trow['department'];
//            $gender = $trow['gender'];
//            $name = $trow['name'];
//            $major = $trow['major'];
//            $email = $trow['email'];
//            $this->assign('id',$openid);
//            $this->assign('name',$name);
//            $this->assign('gender',$gender);
//            $this->assign('department',$department);
//            $this->assign('email',$email);
//            $this->assign('major',$major);
//            $this->display();
//        }else{
//            $this->redirect('/Home/Oauth/index');
//        }
    }
    public function test(){
        echo 'guapi';
    }
}