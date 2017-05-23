<?php /* Smarty version Smarty-3.1.6, created on 2017-05-19 21:13:54
         compiled from "./Application/Home/View\StudentInfo\studentlist.html" */ ?>
<?php /*%%SmartyHeaderCode:32411591e618b454133-41355230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52e455b534089883ab1565dbd72e238d35d717dd' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\studentlist.html',
      1 => 1495199631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32411591e618b454133-41355230',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_591e618b4dee3',
  'variables' => 
  array (
    'stuId' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591e618b4dee3')) {function content_591e618b4dee3($_smarty_tpl) {?><!--学生列表-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>我的学生</title>
    <link rel="stylesheet" href="__PUBLIC__/css/normalize.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/base.css">
    <link rel="stylesheet" href="__PUBLIC__/css/zepto.alert.css">
    <link rel="stylesheet" href="__PUBLIC__/dist/style/weui.css"/>
    <link rel="stylesheet" href="__PUBLIC__/dist/example/example.css"/>
</head>

<body>
<!--顶部导航条-->
<div class="head">
    <div class="title-nav">我的学生</div>
    <div class="go-back">
        <img src="__PUBLIC__/img/goback.png"/>
    </div>
</div>

<div class="wrap">
    <!--条件查询结果-->
    <div class="weui-cells__title">已经实习立项的学生人数为<span class="total-num">1</span>人</div>
    <p></p>
    <!--学生列表-->
    <div class="weui-cells">
        <!--学生1-->
        <a class="weui-cell weui-cell_access" href="__URL__/studentinfo?stuId=<?php echo $_smarty_tpl->tpl_vars['stuId']->value;?>
">
            <!--学生头像(微信头像)-->
            <div class="weui-cell__hd">
                <img src="__PUBLIC__/images/default.png" alt="" style="width:40px;margin-right:15px;display:block">
            </div>
            <!--学生学号和姓名-->
            <div class="weui-cell__bd">
                <span class="stu-num">1601210001</span>&nbsp;&nbsp;<span class="stu-name">徐凯文</span>
            </div>
            <!--学生状态:已经立项,已经结项,已经开题,已交初稿,已交终稿,已经送审,申请答辩-->
            <div class="stu-status weui-cell__ft">已交初稿</div>
        </a>
    </div>
</div>
</div>

</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/zepto.alert.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
</html><?php }} ?>