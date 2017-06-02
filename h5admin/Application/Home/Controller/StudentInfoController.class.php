<?php

namespace Home\Controller;
//use Think\Controller;
use Think\Log;

/**
 * 学生信息
 * 包括:
 * 指导学列表index     -- 已经完成
 * 学生详细信息stuinfo -- 已经完成
 * 实习信息inerinfo    --没完成(没有给接口)
 * 开题信息thesisinfo  --没完成(没有给接口)
 * 就业信息jobinfo     --没完成(没有给接口)
 */
class StudentInfoController extends CommonController  {

    public function index(){

        $this->display();

    }

    //获取该导师指导下的学生信息列表(接收前端StudentInfo/index.html的ajax请求)
    public function getAllStduentlist() {

        Log::write("hello in there",LOG_INFO);
//        $this->allowMethod(self::GET);
        //使用上述查询条件调用api获取学生列表
        //$teacherid = $_SESSION['userid'];
		$teacherid = "1601210606";
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        $url = "https://api.mysspku.com/index.php/V2/TeacherInfo/getStudents?teacherid=".$teacherid."&token=".$acc;

        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);





        //所有学生列表
        $stuArr = $arr['data']['students'];

        $staArr = array();

        //是否实习立项  lxConfirm     0或null - 未立项 , 1 -已立项
        //是否实习结项  jxConfirm     0或null - 未结项 , 1 -已结项
        //是否开题      ktconfirm     0或null - 未开题 , 1 -已开题
        //是否通过答辩   paperPass     0或null - 未通过 , 1 -已通过

        //当前状态(6种):未实习、实习中、实习结束(未开题)、已开题、未通过答辩、已通过答辩
        //实习状态(3种):未实习(lxConfirm=null)、实习中(lxConfirm=1&jxConfirm=null)、实习结束实习中(lxConfirm=1&jxConfirm=1)
        //开题状态(2种):未开题(ktconfirm=null)、已开题(lxConfirm=1 & jxConfirm=1 & ktconfirm=1)
        //答辩状态(3种):无(未申请答辩)(paperPass=null)、未通过答辩(paperPass=null)、已通过答辩(lxConfirm=1 & jxConfirm=1 & ktconfirm=1 & paperPass=1)
        foreach($stuArr as $key=>$value){

            //学号存入状态列表
            $staArr[$key]['stuid']=$stuArr[$key]["stuid"];

            if($value["lxConfirm"] == null){                  //未立项

                $stuArr[$key]["status"] = "未实习";            //当前状态, 默认未实习
                $stuArr[$key]["inerStatus"] = "未实习";       //实习状态, 默认未实习
                $stuArr[$key]["thesisStatus"] = "未开题";     //开题状态, 默认未开题
                $stuArr[$key]["passStatus"] = "无";          //答辩状态, 默认无

            }else if($value["jxConfirm"] == null){             //已立项,未结项

                $stuArr[$key]["status"] = "实习中";
                $stuArr[$key]["inerStatus"] = "实习中";        //实习状态
                $stuArr[$key]["thesisStatus"] = "未开题";      //开题状态
                $stuArr[$key]["passStatus"] = "无";           //答辩状态

            }else if($value["ktconfirm"] == null){             //未开题

                $stuArr[$key]["status"] = "实习结束";
                $stuArr[$key]["inerStatus"] = "实习结束";      //实习状态
                $stuArr[$key]["thesisStatus"] = "未开题";      //开题状态
                $stuArr[$key]["passStatus"] = "无";           //答辩状态

            }else if($value["paperPass"] == null){             //未申请或未通过答辩
                $stuArr[$key]["status"] = "已开题";
                $stuArr[$key]["inerStatus"] = "实习结束";      //实习状态
                $stuArr[$key]["thesisStatus"] = "已开题";     //开题状态
                $stuArr[$key]["passStatus"] = "无";           //答辩状态
            }else{//通过答辩
                $stuArr[$key]["status"] = "已通过答辩";         //当前状态
                $stuArr[$key]["inerStatus"] = "实习结束";      //当前状态
                $stuArr[$key]["thesisStatus"] = "已开题";     //开题状态
                $stuArr[$key]["passStatus"] = "已通过答辩";    //答辩状态
            }

            //存入状态列表
            $staArr[$key]['status']=$stuArr[$key]["status"];
            $staArr[$key]['inerStatus']=$stuArr[$key]["inerStatus"];
            $staArr[$key]['thesisStatus']=$stuArr[$key]["thesisStatus"];
            $staArr[$key]['passStatus']=$stuArr[$key]["passStatus"];
        }

        //错误代码:0 - 无错误
        $error_code = $arr['errcode'];
        if($error_code == 0){//无错误
            $result['meta']=array('code'=> "0");
            $result['stuData']=$stuArr;//所有学生信息列表
            $result['staData']=$staArr;//所有学生状态信息列表:当前状态、当前状态、开题状态、答辩状态
        }else if($error_code == 40901){//token不正确
            $result['meta']=array('code' => "40901", 'error' => "error", 'info' => "error");
        } else{//其他错误
            $result['meta']=array('code' => "49999", 'error' => "error", 'info' => "error");
        }
        $test = json_encode($result);
        Log::write("hello in there!!! $test ",LOG_INFO);

        $this->ajaxReturn($result);

    }

    //获取该导师指导下的学生信息列表(display方式)
//    public function index(){
//        $userid = $_SESSION['userid'];
//
//        //用api获取前端状态信息
//        //将状态信息赋值到前端
//        $this->assign('id',$userid);
//
////        $studentId      = $_POST['studentId'];
////        $studentName    = $_POST['studentName'];
////        $studentYear    = $_POST['studentYear'];
////        $studyStatus    = $_POST['studyStatus'];
////        $practiceStatus = $_POST['practiceStatus'];
////        $paperStatus    = $_POST['paperStatus'];
//
//        //使用上述查询条件调用api获取学生列表
//        $teacherid = $_SESSION['userid'];
//        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
//
//        $url = "https://api.mysspku.com/index.php/V2/TeacherInfo/getStudents?teacherid=".$teacherid."&token=".$acc;
//        //返回json数据包
//        $json = file_get_contents($url);
//        //将json格式转换为数组
//        $arr = json_decode($json,true);
//
//        $stuArr = $arr['data']['students'];
//        $staArr = array();
//
//        //是否实习立项  lxConfirm     0或null - 未立项 , 1 -已立项
//        //是否实习结项  jxConfirm     0或null - 未结项 , 1 -已结项
//        //是否开题      ktconfirm     0或null - 未开题 , 1 -已开题
//        //是否通过答辩   paperPass     0或null - 未通过 , 1 -已通过
//
//        //当前状态(6种):未实习、实习中、实习结束(未开题)、已开题、未通过答辩、已通过答辩
//        //实习状态(3种):未实习(lxConfirm=null)、实习中(lxConfirm=1&jxConfirm=null)、实习结束实习中(lxConfirm=1&jxConfirm=1)
//        //开题状态(2种):未开题(ktconfirm=null)、已开题(lxConfirm=1 & jxConfirm=1 & ktconfirm=1)
//        //答辩状态(3种):无(未申请答辩)(paperPass=null)、未通过答辩(paperPass=null)、已通过答辩(lxConfirm=1 & jxConfirm=1 & ktconfirm=1 & paperPass=1)
//        foreach($stuArr as $key=>$value){
//
//            //学号存入状态列表
//            $staArr[$key]['stuid']=$stuArr[$key]["stuid"];
//
//            if($value["lxConfirm"] == null){                  //未立项
//
//                $stuArr[$key]["status"] = "未实习";            //当前状态, 默认未实习
//                $stuArr[$key]["inerStatus"] = "未实习";       //实习状态, 默认未实习
//                $stuArr[$key]["thesisStatus"] = "未开题";     //开题状态, 默认未开题
//                $stuArr[$key]["passStatus"] = "无";          //答辩状态, 默认无
//
//            }else if($value["jxConfirm"] == null){             //已立项,未结项
//
//                $stuArr[$key]["status"] = "实习中";
//                $stuArr[$key]["inerStatus"] = "实习中";        //实习状态
//                $stuArr[$key]["thesisStatus"] = "未开题";      //开题状态
//                $stuArr[$key]["passStatus"] = "无";           //答辩状态
//
//            }else if($value["ktconfirm"] == null){             //未开题
//
//                $stuArr[$key]["status"] = "实习结束";
//                $stuArr[$key]["inerStatus"] = "实习结束";      //实习状态
//                $stuArr[$key]["thesisStatus"] = "未开题";      //开题状态
//                $stuArr[$key]["passStatus"] = "无";           //答辩状态
//
//            }else if($value["paperPass"] == null){             //未申请或未通过答辩
//                $stuArr[$key]["status"] = "已开题";
//                $stuArr[$key]["inerStatus"] = "实习结束";      //实习状态
//                $stuArr[$key]["thesisStatus"] = "已开题";     //开题状态
//                $stuArr[$key]["passStatus"] = "无";           //答辩状态
//            }else{//通过答辩
//                $stuArr[$key]["status"] = "已通过答辩";         //当前状态
//                $stuArr[$key]["inerStatus"] = "实习结束";      //实习状态
//                $stuArr[$key]["thesisStatus"] = "已开题";     //开题状态
//                $stuArr[$key]["passStatus"] = "已通过答辩";    //答辩状态
//            }
//
//            //存入状态列表
//            $staArr[$key]['status']=$stuArr[$key]["status"];
//            $staArr[$key]['inerStatus']=$stuArr[$key]["inerStatus"];
//            $staArr[$key]['thesisStatus']=$stuArr[$key]["thesisStatus"];
//            $staArr[$key]['passStatus']=$stuArr[$key]["passStatus"];
//        }
//        //将学生列表赋值到前端foreach 打印出来
//        $this->assign('stu',$stuArr);
//        $this->assign('sta',$staArr);
//        $this->display();
//    }

    //查看学生详细信息
    public function stuinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取当前学生的状态
        $stuSta = $_GET['stuSta'];//当前状态
        $stuInerSta = $_GET['stuInerSta'];//实习状态
        $stuThesisSta= $_GET['stuThesisSta'];//开题状态
        $stuPassSta = $_GET['stuPassSta'];//通过答辩状态

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
        $type_name = $arr['data']['type_name'];   //培养方式,如双证

        $this->assign('name' , $name);
        $this->assign('gender', $gender);
        $this->assign('researcharea', $researcharea);
        $this->assign('major', $major);
        $this->assign('mail',$mail);
        $this->assign('telephone',$telephone);
        $this->assign('grade',$grade);
        $this->assign('imgurl',$imgurl);
        $this->assign('location',$location);
        $this->assign('type_name',$type_name);

        //学生状态
        $this->assign('stuId', $stuId);
        $this->assign('stuSta',$stuSta);
        $this->assign('stuInerSta',$stuInerSta);
        $this->assign('stuThesisSta',$stuThesisSta);
        $this->assign('stuPassSta',$stuPassSta);

        $this->display();
    }

    //实习信息 -- 接口没给(模拟接口数据)
    public function inerinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生实习信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/InerInfo/getDetail?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //实习信息 - 若取出结果为null,显示无
        $lxDate = "2017-03-01";//立项日期
        $jxDate = "2017-10-01";//结项日期
        $company = "腾讯";      //实习公司

        $this->assign('lxDate', $lxDate);
        $this->assign('jxDate', $jxDate);
        $this->assign('company',$company);

        $this->display();
    }

    //开题信息 -- 接口没给(模拟接口数据)
    public function thesisinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生开题信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/ThesisInfo/getDetail?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //开题信息 - 若取出结果为null,显示无
        $ktDate = "2017-06-01";//开题日期
        $topic = "数据挖掘应用";//开题题目

        $this->assign('ktDate', $ktDate);
        $this->assign('topic', $topic);

        $this->display();
    }

    //就业信息 -- 接口没给(模拟接口数据)
    public function jobinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生就业信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/JobInfo/getDetail?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //就业信息 - 若取出结果为null,显示无
        $jobSta = "已经签约";      //状况
        $company = "腾讯";        //单位
        $position = "算法工程师";  //岗位
        $industry = "互联网";     //行业

        $this->assign('jobSta',$jobSta);
        $this->assign('company',$company);
        $this->assign('position',$position);
        $this->assign('industry',$industry);

        $this->display();
    }
}

?>
