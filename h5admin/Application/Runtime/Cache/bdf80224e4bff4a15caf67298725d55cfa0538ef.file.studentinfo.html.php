<?php /* Smarty version Smarty-3.1.6, created on 2017-05-19 21:23:25
         compiled from "./Application/Home/View\StudentInfo\studentinfo.html" */ ?>
<?php /*%%SmartyHeaderCode:28383591e5422814117-87087515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdf80224e4bff4a15caf67298725d55cfa0538ef' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\studentinfo.html',
      1 => 1495200197,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28383591e5422814117-87087515',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_591e54228b978',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591e54228b978')) {function content_591e54228b978($_smarty_tpl) {?><!--学生的详细信息-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>学生详细信息</title>
    <link rel="stylesheet" href="__PUBLIC__/css/normalize.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/base.css">
    <link rel="stylesheet" href="__PUBLIC__/css/zepto.alert.css">
    <link rel="stylesheet" href="__PUBLIC__/dist/style/weui.css"/>
    <link rel="stylesheet" href="__PUBLIC__/dist/example/example.css"/>
</head>
<body>
<!--顶部导航条-->
<div class="head">
    <div class="title-nav">学生详细信息</div>
    <div class="go-back">
        <img src="__PUBLIC__/img/goback.png"/>
    </div>
</div>

<!--信息介绍-->
<br>
<div class="weui-cells__title"></div>


<!--学生信息-->
<div class="weui-cells">


    <div class="weui-cells">

        <div class="weui-cell">
            <div class="weui-cell__hd"><img src="__PUBLIC__/images/head.jpg" alt="" style="width:60px;margin-right:15px;display:block"></div>
            <div class="weui-cell__bd">
                <p>徐凯文</p>
                <p>男</p>
            </div>
            <div class="weui-cell__ft">已经立项</div>
        </div>

        <!--学号-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>学号</p>
            </div>
            <div class="weui-cell__ft">1601210001</div>
        </div>

        <!--方向-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>方向</p>
            </div>
            <div class="weui-cell__ft">软件开发</div>
        </div>

        <!--手机-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>手机</p>
            </div>
            <div class="weui-cell__ft">13912345678</div>
        </div>

        <!--电子邮箱-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>E-mail</p>
            </div>
            <div class="weui-cell__ft">abc@pku.edu.cn</div>
        </div>

        <!--入学年份-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>入学年份</p>
            </div>
            <div class="weui-cell__ft">2016级</div>
        </div>

        <!--学习状态-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>学习状态</p>
            </div>
            <div class="weui-cell__ft">在读</div>
        </div>
        <!--实习立项情况-->
        <a class="weui-cell weui-cell_access" href="__URL__/stupractice">
            <div class="weui-cell__bd">
                <p>实习立项情况</p>
            </div>
            <div class="weui-cell__ft">已立项</div>
        </a>
        <!--毕业论文情况-->
        <a class="weui-cell weui-cell_access" href="__URL__/stuthesis">
            <div class="weui-cell__bd">
                <p>毕业论文情况</p>
            </div>
            <div class="weui-cell__ft">已开题</div>
        </a>
        <!--申请答辩情况-->
        <a class="weui-cell weui-cell_access" href="__URL__/thesisdefense">
            <div class="weui-cell__bd">
                <p>申请答辩情况</p>
            </div>
            <div class="weui-cell__ft">已申请</div>
        </a>
    </div>


</div>

</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/zepto.alert.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
</html><?php }} ?>