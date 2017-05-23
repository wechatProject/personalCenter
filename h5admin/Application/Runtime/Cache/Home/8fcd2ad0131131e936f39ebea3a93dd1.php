<?php if (!defined('THINK_PATH')) exit();?><!--学生的详细信息-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>学生详细信息</title>
    <link rel="stylesheet" href="/personalCenter/h5admin/Public/css/normalize.css"/>
    <link rel="stylesheet" href="/personalCenter/h5admin/Public/css/base.css">
    <link rel="stylesheet" href="/personalCenter/h5admin/Public/css/zepto.alert.css">
    <link rel="stylesheet" href="/personalCenter/h5admin/Public/dist/style/weui.css"/>
    <link rel="stylesheet" href="/personalCenter/h5admin/Public/dist/example/example.css"/>
</head>
<body>
<!--顶部导航条-->
<div class="head">
    <div class="title-nav">学生详细信息</div>
    <div class="go-back">
        <img src="/personalCenter/h5admin/Public/img/goback.png"/>
    </div>
</div>

<!--信息介绍-->
<br>
<div class="weui-cells__title"></div>


<!--学生信息-->
<div class="weui-cells">


    <div class="weui-cells">

        <div class="weui-cell">
            <div class="weui-cell__hd"><img src="./images/head.jpg" alt="" style="width:60px;margin-right:15px;display:block"></div>
            <div class="weui-cell__bd">
                <p>徐凯文</p>
                <p>男</p>
            </div>
            <div class="weui-cell__ft">已经立项</div>
        </div>

        '/personalCenter/h5admin/Public'
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
        <a class="weui-cell weui-cell_access" href="stupractice.html">
            <div class="weui-cell__bd">
                <p>实习立项情况</p>
            </div>
            <div class="weui-cell__ft">已立项</div>
        </a>
        <!--毕业论文情况-->
        <a class="weui-cell weui-cell_access" href="stuthesis.html">
            <div class="weui-cell__bd">
                <p>毕业论文情况</p>
            </div>
            <div class="weui-cell__ft">已开题</div>
        </a>
        <!--申请答辩情况-->
        <a class="weui-cell weui-cell_access" href="thesisdefense.html">
            <div class="weui-cell__bd">
                <p>申请答辩情况</p>
            </div>
            <div class="weui-cell__ft">已申请</div>
        </a>
    </div>


</div>

</div>
</body>
<script type="text/javascript" src="js/zepto.min.js"></script>
<script type="text/javascript" src="js/zepto.alert.js"></script>
<script type="text/javascript" src="js/base.js"></script>
</html>