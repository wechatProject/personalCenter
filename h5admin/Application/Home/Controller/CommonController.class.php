<?php

namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller
{

    //微信网页授权,获取用户ID -- 本地调试可以先注释掉
    public function __construct()
    {
        parent::__construct();

        session('[start]');

        if (!IS_AJAX) {
            if (!session('?userid')) {
                if (isset($_GET['code'])) {
                    //step 1 --> 用户同意授权后,获取code
                    $code = $_GET['code'];

                    //step 2 --> 通过code换取网页授权access_token
                    //构造url
                    $filepath = "/home/ubuntu/wxPublic/token.txt";
                    $fp = fopen($filepath, "r");
                    $acc = fread($fp, filesize($filepath));
                    fclose($fp);

                    //step 3 --> 通过code和access_token换取userid
                    $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=' . $acc . '&code=' . $code;
                    //返回json数据包
                    $json = file_get_contents($url);
                    //将json格式转换为数组
                    $arr = json_decode($json, true);
                    //获取access_token和openid
                    $userid = $arr['UserId'];

                    if ($json == null) {
                        echo "access_token error!";
                        exit();
                    } else {
                        $_SESSION['userid'] = $userid;
                        //$_SESSION['access_token']=$acc;
                        //$_SESSION['openid'] = $openid;
                        //$this->redirect('/Index/index');
                    }

                } else {             //用户未同意授权
                    echo "no grant , please grant first";
                    exit();
                }
            }

        }
    }
}


?>
