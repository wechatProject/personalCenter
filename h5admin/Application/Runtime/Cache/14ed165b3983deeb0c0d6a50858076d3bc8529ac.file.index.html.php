<?php /* Smarty version Smarty-3.1.6, created on 2017-05-31 21:57:00
         compiled from "./Application/Home/View\StudentInfo\index.html" */ ?>
<?php /*%%SmartyHeaderCode:25523592ebc6a2b30f1-49011880%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14ed165b3983deeb0c0d6a50858076d3bc8529ac' => 
    array (
      0 => './Application/Home/View\\StudentInfo\\index.html',
      1 => 1496239017,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25523592ebc6a2b30f1-49011880',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_592ebc6a35afd',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_592ebc6a35afd')) {function content_592ebc6a35afd($_smarty_tpl) {?><!--学生信息主页:查询+学生信息列表-->

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
    <!--查询条件,无标题-->
    <form id="searchStudent" method="post" action="__URL__/index">
        <div class="page__bd mpage__bd_spacing">
            <div class="mweui-flex">
                <div class="mweui-flex__item1 ">
                    <div class="placeholder">
                        <div class="placeholder">
                            <!--入学年份选择,默认为当前学年(研一的新生)-->
                            <select id="graSelect" class="mweui-select graSelect" name="graSelect">
                                <option value="0">所有年级</option>
                                <option value="1">2016</option>
                                <option value="2">2015</option>
                                <option value="3">2014</option>
                                <option value="4">2013</option>
                                <option value="5">2012</option>
                                <option value="6">2011</option>
                                <option value="7">2010</option>
                                <option value="8">2009</option>
                                <option value="9">2008</option>
                                <option value="10">2007</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mweui-flex__item2">
                    <div class="placeholder">
                        <!--状态选择,默认为全部-->
                        <select id="staSelect" class="mweui-select staSelect" name="staSelect">
                            <option value="0">所有状态</option>
                            <option value="1">未实习</option>
                            <option value="2">实习中</option>
                            <option value="3">实习结束</option>
                            <option value="4">已开题</option>
                            <option value="5">未通过答辩</option>
                            <option value="6">已通过答辩</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--条件查询结果统计-->
    <div class="weui-cells__title"><span id="sta-para" class="para">已开题</span>的<span id="grade-para" class="grade-para">2014</span>级学生人数为<span
            id="total-num" class="total-num">1</span>人
    </div>

    <!--动态加载符合条件的学生列表,base.js-->
    <div id="students"></div>
</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/zepto.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/config.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script>
<script type="text/javascript">
    Basicinfo.queryStuInfo();//条件查询该导师指导的学生列表
</script>
</html><?php }} ?>