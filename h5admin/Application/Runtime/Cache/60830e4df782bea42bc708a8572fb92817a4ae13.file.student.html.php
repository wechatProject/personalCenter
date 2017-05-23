<?php /* Smarty version Smarty-3.1.6, created on 2017-05-19 11:53:48
         compiled from "./Application/Home/View\StudentInfo\student.html" */ ?>
<?php /*%%SmartyHeaderCode:12970591e60465c0697-03034157%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60830e4df782bea42bc708a8572fb92817a4ae13' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\student.html',
      1 => 1495166025,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12970591e60465c0697-03034157',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_591e604665573',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591e604665573')) {function content_591e604665573($_smarty_tpl) {?><!--学生信息查询页面-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>我的学生</title>
    <link rel="stylesheet" href="__PUBLIC__/dist/style/weui.css"/>
    <link rel="stylesheet" href="__PUBLIC__/dist/example/example.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/my.css"/>
</head>
<body>
<!--查询标题-->
<div class="page__hd">
    <h1 class="page__title">学生信息查询</h1>
    <!--<p class="page__desc">查询</p>-->
</div>
<form id="searchStudent" method="post" action="__URL__/studentlist">
    <!--学生学号-->
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">学生学号</label></div>
        <div class="weui-cell__bd">
            <input class="stu-num weui-input" name="studentId" type="number" pattern="[0-9]*" placeholder="请输入学生学号"/>
        </div>
    </div>
    <!--学生姓名-->
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">学生姓名</label></div>
        <div class="weui-cell__bd">
            <input class="stu-name weui-input" name="studentName" placeholder="请输入学生姓名"/>
        </div>
    </div>

    <!--入学年份选择-->
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">入学年份</label>
        </div>
        <div class="weui-cell__bd">
            <select class="stu-grade weui-select" name="studentYear">
                <option value="0">全部</option>
                <option value="1">2016</option>
                <option value="2">2015</option>
                <option value="3">2014</option>
                <option value="4">2013</option>
            </select>
        </div>
    </div>

    <!--查询条件-->
    <!--状态选择-->
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">学习状态</label>
        </div>
        <div class="weui-cell__bd">
            <select class="stu-satus weui-select" name="studyStatus">
                <option value="0">全部</option>
                <option value="1">在读</option>
                <option value="2">毕业</option>
                <option value="3">休学</option>
            </select>
        </div>
    </div>
    <!--实习状态选择-->
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">实习状态</label>
        </div>
        <div class="weui-cell__bd">
            <select class="stu-practice weui-select" name="practiceStatus">
                <option value="0">全部</option>
                <option value="1">已经立项</option>
                <option value="2">已经结项</option>
            </select>
        </div>
    </div>
    <!--论文状态选择-->
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">论文状态</label>
        </div>
        <div class="weui-cell__bd">
            <select class="stu-thesis weui-select" name="paperStatus">
                <option value="0">全部</option>
                <option value="1">已经开题</option>
                <option value="2">已交初稿</option>
                <option value="3">已交终稿</option>
                <option value="4">已经送审</option>
            </select>
        </div>
    </div>

</form>

<!--查询按钮,点击跳转到studentlist.html页面-->
<div class="weui-btn-area">
    <button class="stuinfo-submit weui-btn weui-btn_primary" id="stuinfo-submit">查询</button>
</div>

</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script>
    $(function () {
        $('#stuinfo-submit').click(function () {
            $('#searchStudent').submit();
        });
    });
</script>
</html><?php }} ?>