<?php /* Smarty version Smarty-3.1.6, created on 2017-05-19 21:23:27
         compiled from "./Application/Home/View\StudentInfo\stupractice.html" */ ?>
<?php /*%%SmartyHeaderCode:11400591ef0c2ac0d20-79144625%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40285c96801625c051cc31e95ffc6411186a2a68' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\stupractice.html',
      1 => 1495200197,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11400591ef0c2ac0d20-79144625',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_591ef0c2b40c3',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591ef0c2b40c3')) {function content_591ef0c2b40c3($_smarty_tpl) {?><!--学生的实习情况-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>实习立项情况</title>
    <link rel="stylesheet" href="__PUBLIC__/css/normalize.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/base.css">
    <link rel="stylesheet" href="__PUBLIC__/css/zepto.alert.css">
    <link rel="stylesheet" href="__PUBLIC__/dist/style/weui.css"/>
    <link rel="stylesheet" href="__PUBLIC__/dist/example/example.css"/>
    <style type="text/css">
        @import url("css/student.css");

        .wrap .item-list.item-list-al {
            font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif;
        }
    </style>
</head>
<body>
<!--顶部导航条-->
<div class="head">
    <div class="title-nav">实习立项情况</div>
    <div class="go-back">
        <img src="__PUBLIC__/img/goback.png"/>
    </div>
</div>

<!--学生实习立项情况-->
<br>
<div class="weui-cells__title"></div>

<!--实习信息-->
<div class="weui-cells">


    <div class="weui-cells">

        <!--立项日期-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>立项日期</p>
            </div>
            <div class="weui-cell__ft">2017-01-01</div>
        </div>

        <!--结项日期-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>结项日期</p>
            </div>
            <div class="weui-cell__ft">2017-10-10</div>
        </div>

        <!--实习公司-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>实习公司</p>
            </div>
            <div class="weui-cell__ft">腾讯</div>
        </div>

        <!--实习职位-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>实习职位</p>
            </div>
            <div class="weui-cell__ft">web开发工程师</div>
        </div>


    </div>

</div>

</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/zepto.alert.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
</html><?php }} ?>