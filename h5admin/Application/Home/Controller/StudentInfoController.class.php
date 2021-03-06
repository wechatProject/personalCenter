<?php

namespace Home\Controller;
use Think\Controller;
use Think\Log;

/**
 * 学生信息
 * 包括:
 * 指导学列表     index
 * 学生详细信息   stuinfo
 * 实习信息      inerinfo
 * 开题信息      thesisinfo
 * 就业信息      jobinfo
 * 答辩信息      defense
 */
class StudentInfoController extends CommonController  {

    public function index(){

        //session('[start]');//启动session
        //$_SESSION['userid'] = '1601210606';  //用于在网页进行测试

        //获取学年列表 , 用于前端筛选条件
        $yearArr = getYearList();
        $this->assign('year',$yearArr);

        $this->display();
    }

    //获取该导师指导下的学生信息列表(接收前端StudentInfo/index.html的ajax请求)
    public function getAllStduentlist() {

        //api token
        $acc =  C('ACCESS_TOKEN');

        //使用上述查询条件调用api获取学生列表
        $teacherid = $_SESSION['userid'];

        //构造学生信息接口url
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

        //当前状态(6种):未立项、已立项、已结项、未开题、已开题、未通过答辩、已通过答辩
        //实习状态(3种):未立项(lxConfirm=null)、已立项(lxConfirm=1&jxConfirm=null)、已结项(jxConfirm=1)
        //开题状态(2种):未开题(ktconfirm=null)、已开题(ktconfirm=1)
        //答辩状态(2种):未通过答辩(包括未申请答辩和已经答辩未通过)(paperPass=null)、已通过答辩(paperPass=1)

        //为每个学生设置当前状态
        foreach($stuArr as $key=>$value){

            //学号存入状态列表
            $staArr[$key]['stuid']=$stuArr[$key]["stuid"];
            //将stuid存入session
            $_SESSION['stuids'][$key] = $stuArr[$key]["stuid"];

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

        //获取信息接口token
        $acc =  C('ACCESS_TOKEN');

        //获取学生学号
        $stuId = $_GET['stuId'];


        //判断当前查询学号是否合法
        $legal = false;
        foreach($_SESSION['stuids'] as $key=>$value){
            if($_SESSION['stuids'][$key] == $stuId)
            {
                $legal = true;
                break;
            }
        }
        //如果当前查询学号不合法，返回查询异常
        if($legal == false) {
            $result['meta'] = array('code' => "49999", 'error' => "illegal access", 'info' => "error");
            $this->ajaxReturn($result);
        }

        //获取当前学生的状态
        //$stuSta = $_GET['stuSta'];//当前状态
        $stuInerSta = $_GET['stuInerSta'];//实习状态
        $stuThesisSta= $_GET['stuThesisSta'];//开题状态
        $stuPassSta = $_GET['stuPassSta'];//通过答辩状态

        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getDetail?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        $name = $arr['data']['name']?$arr['data']['name']:"";
        $gender = $arr['data']['gender']?$arr['data']['gender']:"";
        $researcharea = $arr['data']['researcharea']?$arr['data']['researcharea']:"无";
        $major = $arr['data']['major_name']?$arr['data']['major_name']:"无";
        $mail = $arr['data']['mail']?$arr['data']['mail']:"无";
        $telephone = $arr['data']['telephone']?$arr['data']['telephone']:"无";
        $grade = $arr['data']['grade']?$arr['data']['grade']:"无";
        $imgurl = $arr['data']['imgurl']?$arr['data']['imgurl']:"无";
        $location = $arr['data']['location']?$arr['data']['location']:"无";     //校区
        $type_name = $arr['data']['type_name']?$arr['data']['type_name']:"无";   //培养方式,如双证

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
        //获取信息接口token
        $acc =  C('ACCESS_TOKEN');

        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生实习信息
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getInternInfo?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //实习信息 - 若取出结果为null,显示无
        $lxDate = $arr['data']['internstarttime']?:"无";    //立项日期
        $jxDate = $arr['data']['internendtime']?$arr['data']['internendtime']:"无";  //结项日期
        $company = $arr['data']['company']?$arr['data']['company']:"无";      //实习公司
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
        //获取信息接口token
        $acc =  C('ACCESS_TOKEN');

        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生开题信息
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getPaperProposal?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //开题信息 - 若取出结果为null,显示无
        $ktDate = $arr['data']['confirmtime']?$arr['data']['confirmtime']:"无";  //审核时间
        $topic = $arr['data']['title']?$arr['data']['title']:"无";         //开题题目
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
        //获取信息接口token
        $acc =  C('ACCESS_TOKEN');
        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生就业信息
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getJobInfo?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //就业信息 - 若取出结果为null,显示无
        $jobSta = $arr['data']['type']?$arr['data']['type']:"无";             //就业类型
        $company = $arr['data']['company']?$arr['data']['company']:"无";         //公司名称
        $position = $arr['data']['position']?$arr['data']['position']:"无";       //职位
        $industry = $arr['data']['industry']?$arr['data']['industry']:"无";       //所属行业
        $location = $arr['data']['location']?$arr['data']['location']:"无";
        $salary = $arr['data']['salary']?$arr['data']['salary']:"无";

        $this->assign('jobSta',$jobSta);
        $this->assign('company',$company);
        $this->assign('position',$position);
        $this->assign('industry',$industry);
        $this->assign('location',$location);
        $this->assign('salary',$salary);

        $this->display();
    }

    //答辩信息
    public function defense(){
        //获取信息接口token
        $acc =  C('ACCESS_TOKEN');

        //获取学生学号
        $stuId = $_GET['stuId'];
        //获取该学生答辩信息
        $url = "https://api.mysspku.com/index.php/V2/StudentInfo/getPaperProcess?stuid=".$stuId."&token=".$acc;
        //返回json数据包
        $json = file_get_contents($url);
        //将json格式转换为数组
        $arr = json_decode($json,true);

        //获取前端需要的字段
        $title = $arr['data']['title']?$arr['data']['title']:"无";
        $assistor = $arr['data']['assistor']?$arr['data']['assistor']:"无";
        $assistormail = $arr['data']['assistormail']?$arr['data']['assistormail']:"无";
        $isdraftsubmit = $arr['data']['isdraftsubmit'] == '1' ? '已提交' : '未提交';
        $isteacheragree = $arr['data']['isteacheragree'] == '1' ? '审核通过' : '未审核或审核未通过';
        $eFinalStatus = $arr['data']['eFinalStatus'] == '1' ? '提交成功' : '提交失败或未提交';
        $printFinalStatus = $arr['data']['printFinalStatus'] == '1' ? '提交成功' : '提交失败或未提交';

        //赋值给前端
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
