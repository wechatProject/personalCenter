<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 工作量统计
 *
 * 综合实践工作量 -- 没完成(没有给接口)
 *
 */
class PracticeWorkController extends Controller {

    public function index(){

        session('[start]');
        $_SESSION['userid'] = '1601210606';  //用于在网页进行测试

        $this->display();
//        $this->display('index-v2');

    }

}

?>