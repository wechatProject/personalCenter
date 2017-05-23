<?php

namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller {

    public function __construct(){
		parent::__construct();

        session('[start]');

        if (isset($_GET['code'])){
            //step 1 --> 用户同意授权后,获取code
            $code =  $_GET['code'];


            //step 2 --> 通过code换取网页授权access_token
            //$appid = 'wx4a056b3e16bf1037';
            //$secret = 'c8f431ffc5d2fb5a1a7504e3181d06fa';
            //构造url

            $filepath = "/home/ubuntu/wxPublic/token.txt";
            $fp = fopen($filepath,"r");
            $acc = fread($fp,filesize($filepath));
            fclose($fp);


            //step 3 --> 通过code和access_token换取userid
            $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token='.$acc.'&code='.$code;
            //返回json数据包
            $json = file_get_contents($url);
            //将json格式转换为数组
            $arr = json_decode($json,true);
            //获取access_token和openid
            $userid = $arr['UserId'];


//            $dat = array ("userid" => strval($userid));
//            $data = json_encode($dat);
//
//            $opts = array (
//                'http' => array (
//                    'method' => 'POST',
//                    'header'=> "Content-type: application/x-www-form-urlencodedrn" . "Content-Length: " . strlen($data) . "rn",
//                    'content' => $data
//                )
//            );
//
//            $context = stream_context_create($opts);
//            $html = file_get_contents('https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token='.$acc, false, $context);
//            $htmlarr = json_decode($html,true);
//            $openid = $htmlarr['openid'];

            if($json == null){
                echo "access_token error!";
                exit();
            }else{
                $_SESSION['userid'] = $userid;
                //$_SESSION['access_token']=$acc;
                //$_SESSION['openid'] = $openid;
                //$this->redirect('/Index/index');
            }


//            //step 3 --> 拉取用户信息
//            $url2 = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
//            echo $url2;
//            //返回json数据包
//            $json2 = file_get_contents($url2);
//            //测试 -- 输出用户信息
//            echo "<br />用户信息:";
//            var_dump($json2);
//            //将json格式转换为数组
//            $arr = json_decode($json2,true);
//            $name = $arr['nickname'];//昵称
//            $imgURL = $arr['headimgurl'];//头像地址
//            $sex = $arr['sex'];//性别
//            $province = $arr['province'];//用户个人资料填写的省份
//            $city= $arr['city'];//普通用户个人资料填写的城市
//            $country= $arr['country'];//国家，如中国为CN
//            //测试 -- 解析后输出
//            echo "<br/>基本信息------>解析后";
//            echo "<br/>OpenID:".$openid;
//            echo "<br/>昵称：".$name;
//            echo "<br/>头像地址:".$imgURL;
//            echo "<br/>性别：".$sex;
//            echo "<br/>省份：".$province;
//            echo "<br/>城市：".$city;

        }else{             //用户未同意授权
            echo "no grant , please grant first";
            exit();
        }
    }
}

?>
