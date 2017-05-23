<?php /* Smarty version Smarty-3.1.6, created on 2017-05-19 21:23:31
         compiled from "./Application/Home/View\StudentInfo\stuthesis.html" */ ?>
<?php /*%%SmartyHeaderCode:13507591ef1d3770ce9-07391827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbaa5856137f9785c897456907b9a20f486547ef' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\stuthesis.html',
      1 => 1495200197,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13507591ef1d3770ce9-07391827',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_591ef1d37e380',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591ef1d37e380')) {function content_591ef1d37e380($_smarty_tpl) {?><!--学生毕业论文情况-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>毕业论文情况</title>
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
    <div class="title-nav">毕业论文情况</div>
    <div class="go-back">
        <img src="__PUBLIC__/img/goback.png"/>
    </div>
</div>
<br>
<div class="weui-cells__title"></div>

<!--论文信息,如 未开题,所有信息显示为无-->
<div class="weui-cells">


    <div class="weui-cells">

        <!--论文开题-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>开题日期</p>
            </div>
            <div class="weui-cell__ft">2017-01-01</div>
        </div>

        <!--论文题目-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>论文题目</p>
            </div>
            <div class="weui-cell__ft">数据挖掘</div>
        </div>

        <!--其他关于论文信息-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>其他论文信息</p>
            </div>
            <div class="weui-cell__ft">暂时未想到</div>
        </div>



    </div>

</div>

</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/zepto.alert.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
</html><?php }} ?>