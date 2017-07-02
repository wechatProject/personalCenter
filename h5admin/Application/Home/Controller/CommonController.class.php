<?php

namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller
{

    //微信网页授权,获取用户ID -- 本地调试可以先注释掉
    public function __construct()
    {

        parent::__construct();//调用父类的构造函数

        session('[start]');//启动session

        //如果是AJAX请求的话,那么不需要进入该权限验证函数(没有必要)
        if (!IS_AJAX) {
            //判断session是否存了userid,若不存在userid则进入权限验证函数
            if (!session('?userid')) {
                //权限验证,接受微信公众平台回调的code,若接收不到code则代表该页面不是从微信公众号里打开的
                if (isset($_GET['code'])) {
                    //step 1 --> 用户同意授权后,获取code
                    $code = $_GET['code'];

                    //step 2 --> 获取access_token, 在服务器中通过nodejs的forever模块,每隔1个小时向微信平台获取一次access_token
                    //并存放到本地的token.txt文件中,每次使用access_token时都先从该文件中读取最新的access_token
//                    $filepath = "/root/wx_token/token.txt";
                    $filepath = C('TOKEN_FILEPATH');
                    $fp = fopen($filepath, "r");
                    $acc = fread($fp, filesize($filepath));
                    fclose($fp);

                    //step 3 --> 组合url,通过code和access_token换取userid
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

                } else {             //若不是从微信公众号内打开该网页,则不给与授权
                    echo "no grant , please grant first";
                    exit();
                }
            }

        }
    }
}


?>
