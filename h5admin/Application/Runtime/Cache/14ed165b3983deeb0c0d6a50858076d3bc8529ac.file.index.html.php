<?php /* Smarty version Smarty-3.1.6, created on 2017-06-16 23:18:03
         compiled from "./Application/Home/View\StudentInfo\index.html" */ ?>
<?php /*%%SmartyHeaderCode:1507159360fe53a02d3-32112729%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14ed165b3983deeb0c0d6a50858076d3bc8529ac' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\index.html',
      1 => 1497624044,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1507159360fe53a02d3-32112729',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_59360fe54861f',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59360fe54861f')) {function content_59360fe54861f($_smarty_tpl) {?><!--学生信息主页:查询+学生信息列表-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>我的学生</title>
    <link rel="stylesheet" href="__PUBLIC__/css/normalize.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/base.css">
    <link rel="stylesheet" href="__PUBLIC__/dist/style/weui.css"/>
    <link rel="stylesheet" href="__PUBLIC__/dist/example/example.css"/>
</head>
<body>

<div class="wrap">

    <!--flex四列布局-->
    <div class="mweui-cells2">
        <div class="mweui-flex">
            <div class="mweui-flex__item">
                <div class="placeholder">
                    <!--入学年份选择,默认为当前学年(研一的新生)-->
                    <select id="graSelect" class="mweui-select graSelect" name="graSelect">
                        <option value="0">入学年份</option>
                    </select>
                </div>
            </div>
            <div class="mweui-flex__item">
                <div class="placeholder">
                    <!--实习状态选择,默认为全部-->
                    <select id="inerSelect" class="mweui-select staSelect" name="inerSelect">
                        <option value="0">实习状态</option>
                        <option value="1">未立项</option>
                        <option value="2">已立项</option>
                        <option value="3">已结项</option>
                    </select>
                </div>
            </div>
            <div class="mweui-flex__item">
                <div class="placeholder">
                    <!--开题状态选择,默认为全部-->
                    <select id="thesisSelect" class="mweui-select staSelect" name="thesisSelect">
                        <option value="0">开题状态</option>
                        <option value="1">未开题</option>
                        <option value="2">已开题</option>
                    </select>
                </div>
            </div>
            <div class="mweui-flex__item">
                <div class="placeholder">
                    <!--答辩状态选择,默认为全部-->
                    <select id="passSelect" class="mweui-select staSelect" name="passSelect">
                        <option value="0">答辩状态</option>
                        <option value="5">未通过答辩</option>
                        <option value="6">已通过答辩</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!--条件查询结果统计-->
    <div class="mweui-cells__res">满足当前筛选条件的学生人数为<span id="total-num" class="total-num">1</span>人</div>

    <!--动态加载符合条件的学生列表,base.js-->
    <div class="mweui-cells" id="students">


    </div>
</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/config.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">

    Basicinfo.queryStuInfo();//条件查询该导师指导的学生列表
</script>
</html><?php }} ?>