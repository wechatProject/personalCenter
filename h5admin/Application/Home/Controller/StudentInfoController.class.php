<?php

namespace Home\Controller;
use Think\Controller;
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
class StudentInfoController extends Controller  {

    public function index(){

        session('[start]');
        $_SESSION['userid'] = '1601210606';  //用于在网页进行测试

        $yearArr = getYearList();
        $this->assign('year',$yearArr);

        $this->display();

    }

    //获取该导师指导下的学生信息列表(接收前端StudentInfo/index.html的ajax请求)
    public function getAllStduentlist() {

        //使用上述查询条件调用api获取学生列表
        $teacherid = $_SESSION['userid'];

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

                $stuArr[$key]["inerStatus"] = "未立项";       //实习状态, 默认未实习

            }else if($value["jxConfirm"] == null){

                $stuArr[$key]["inerStatus"] = "已立项";

            }else{

                $stuArr[$key]["inerStatus"] = "已结项";
            }

            if($value["ktconfirm"] == null){             //未开题

                $stuArr[$key]["thesisStatus"] = "未开题";      //开题状态

            }else{

                $stuArr[$key]["thesisStatus"] = "已开题";      //开题状态
            }

            if($value["paperPass"] == null){             //未申请或未通过答辩

                $stuArr[$key]["passStatus"] = "未通过答辩";           //答辩状态

            }else{//通过答辩

                $stuArr[$key]["passStatus"] = "已通过答辩";    //答辩状态
            }

            //存入状态列表
            $staArr[$key]['inerStatus']=$stuArr[$key]["inerStatus"];
            $staArr[$key]['thesisStatus']=$stuArr[$key]["thesisStatus"];
            $staArr[$key]['passStatus']=$stuArr[$key]["passStatus"];
        }

        //需要对$stuArr数组排序
        $sortArr = array_sort($stuArr, 'stuid','descend');


        //错误代码:0 - 无错误
        $error_code = $arr['errcode'];
        if($error_code == 0){ //无错误
            $result['meta']=array('code'=>"0");
            $result['stuData']=$sortArr;//所有学生信息列表
            $result['staData']=$staArr;//所有学生状态信息列表:当前状态、当前状态、开题状态、答辩状态
        }else if($error_code == 40901){ //token不正确
            $result['meta']=array('code' => "40901", 'error' => "error", 'info' => "error");
        } else{ //其他错误
            $result['meta']=array('code' => "49999", 'error' => "error", 'info' => "error");
        }
//        $test = json_encode($result);
//        Log::write("hello in there!!! $test ",LOG_INFO);

        $this->ajaxReturn($result);

    }


    //查看学生详细信息
    public function stuinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取当前学生的状态
        //$stuSta = $_GET['stuSta'];//当前状态
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
        //$this->assign('stuSta',$stuSta);
        $this->assign('stuInerSta',$stuInerSta);
        $this->assign('stuThesisSta',$stuThesisSta);
        $this->assign('stuPassSta',$stuPassSta);

        $this->display();
    }

    //实习信息
    public function inerinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生实习信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getInternInfo?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //实习信息 - 若取出结果为null,显示无
        $lxDate = $arr['data']['internstarttime'];    //立项日期
        $jxDate = $arr['data']['internendtime'];  //结项日期
        $company = $arr['data']['company'];      //实习公司
        $teacherconfirm = $arr['data']['teacherconfirm'] == '1' ? '审核通过' : '未审核或未通过';
        $libraryconfirm = $arr['data']['libraryconfirm'] == '1' ? '审核通过' : '未审核或未通过';
        $hqconfirm = $arr['data']['hqconfirm'] == '1' ? '审核通过' : '未审核或未通过';
        $cwconfirm = $arr['data']['cwconfirm'] == '1' ? '审核通过' : '未审核或未通过';
        $xgbconfirm = $arr['data']['xgbconfirm'] == '1' ? '审核通过' : '未审核或未通过';
        $sxbconfirm = $arr['data']['sxbconfirm'] == '1' ? '审核通过' : '未审核或未通过';
        $endconfirm = $arr['data']['endconfirm'] == '1' ? '审核通过' : '未审核或未通过';



        $this->assign('lxDate', $lxDate);
        $this->assign('jxDate', $jxDate);
        $this->assign('company',$company);

        $this->assign('teacherconfirm',$teacherconfirm);
        $this->assign('libraryconfirm',$libraryconfirm);
        $this->assign('hqconfirm',$hqconfirm);
        $this->assign('cwconfirm',$cwconfirm);
        $this->assign('xgbconfirm',$xgbconfirm);
        $this->assign('sxbconfirm',$sxbconfirm);
        $this->assign('endconfirm',$endconfirm);

        $this->display();
    }

    //开题信息
    public function thesisinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生开题信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getPaperProposal?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //开题信息 - 若取出结果为null,显示无
        $ktDate = $arr['data']['confirmtime'];  //审核时间
        $topic = $arr['data']['title'];         //开题题目
        $tjStatus = $arr['data']['status'] == '1' ? '已提交': '未提交';
        $shStatus = $arr['data']['confirm'] == '1' ? '审核通过' : '未审核或审核未通过';

        $this->assign('ktDate', $ktDate);
        $this->assign('topic', $topic);
        $this->assign('tjStatus', $tjStatus);
        $this->assign('shStatus', $shStatus);

        $this->display();
    }

    //就业信息
    public function jobinfo(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生就业信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getJobInfo?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //就业信息 - 若取出结果为null,显示无
        $jobSta = $arr['data']['type'];             //就业类型
        $company = $arr['data']['company'];         //公司名称
        $position = $arr['data']['position'];       //职位
        $industry = $arr['data']['industry'];       //所属行业
        $location = $arr['data']['location'];
        $salary = $arr['data']['salary'];

        $this->assign('jobSta',$jobSta);
        $this->assign('company',$company);
        $this->assign('position',$position);
        $this->assign('industry',$industry);
        $this->assign('location',$location);
        $this->assign('salary',$salary);

        $this->display();
    }

    public function defense(){
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生就业信息
        $acc = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getPaperProcess?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        $title = $arr['data']['title'];
        $assistor = $arr['data']['assistor'];
        $assistormail = $arr['data']['assistormail'];
        $isdraftsubmit = $arr['data']['isdraftsubmit'] == '1' ? '已提交' : '未提交';
        $isteacheragree = $arr['data']['isteacheragree'] == '1' ? '审核通过' : '未审核或审核未通过';
        $eFinalStatus = $arr['data']['eFinalStatus'] == '1' ? '提交成功' : '提交失败或未提交';
        $printFinalStatus = $arr['data']['printFinalStatus'] == '1' ? '提交成功' : '提交失败或未提交';

        $this->assign('title',$title);
        $this->assign('assistor',$assistor);
        $this->assign('assistormail',$assistormail);
        $this->assign('isdraftsubmit',$isdraftsubmit);
        $this->assign('isteacheragree',$isteacheragree);
        $this->assign('eFinalStatus',$eFinalStatus);
        $this->assign('printFinalStatus',$printFinalStatus);

        $this->display();
    }

}

?>
