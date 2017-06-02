<?php /* Smarty version Smarty-3.1.6, created on 2017-05-28 20:54:10
         compiled from "./Application/Home/View/TeacherInfo/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1648050050592ac87262e9b4-85312194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a3ad07e586cbc7d752ee4b06220532b6ec5da3c9' => 
    array (
      0 => './Application/Home/View/TeacherInfo/index.html',
      1 => 1495975694,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1648050050592ac87262e9b4-85312194',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'imgurl' => 0,
    'name' => 0,
    'gender' => 0,
    'userid' => 0,
    'title' => 0,
    'telephone' => 0,
    'mail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_592ac87269ef9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_592ac87269ef9')) {function content_592ac87269ef9($_smarty_tpl) {?><!--教师个人信息-->

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>我的信息</title>
    <link rel="stylesheet" href="__PUBLIC__/css/normalize.css"/>
    <link rel="stylesheet" href="__PUBLIC__/css/base.css">
    <link rel="stylesheet" href="__PUBLIC__/css/zepto.alert.css">
    <link rel="stylesheet" href="__PUBLIC__/dist/style/weui.css"/>
    <link rel="stylesheet" href="__PUBLIC__/dist/example/example.css"/>
</head>
<body>
<div class="wrap">
    <!--头像-->
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd"><img src="<?php echo $_smarty_tpl->tpl_vars['imgurl']->value;?>
" alt="" style="width:60px;margin-right:15px;display:block"></div>
            <div class="weui-cell__bd">
                <p><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</p>
                <p><span><?php echo $_smarty_tpl->tpl_vars['gender']->value;?>
</span>
            </div>
        </div>
    </div>
    <div class="weui-cells">
        <!--教师id-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>工号</p>
            </div>
            <div class="weui-cell__ft"><?php echo $_smarty_tpl->tpl_vars['userid']->value;?>
</div>
        </div>
        <!--职称-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>职称</p>
            </div>
            <div class="weui-cell__ft"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</div>
        </div>

        <!--手机-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>手机</p>
            </div>
            <div class="weui-cell__ft"><?php echo $_smarty_tpl->tpl_vars['telephone']->value;?>
</div>
        </div>
        <!--E-mail-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>E-mail</p>
            </div>
            <div class="weui-cell__ft"><?php echo $_smarty_tpl->tpl_vars['mail']->value;?>
</div>
        </div>
    </div>


</div>

</div>
</body>
</html><?php }} ?>