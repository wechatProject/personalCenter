<?php
return array(
	//'配置项'=>'配置值'

    //获取软微企业号access_token的本地存放地址
    'TOKEN_FILEPATH'=>'/root/wx_token/token.txt',

    //学生信息、教师个人信息、工作量信息接口访问token
    'ACCESS_TOKEN'=>'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',

    'TMPL_ENGINE_TYPE'=>'Smarty',
    'TMPL_ENGINE_CONFIG'=>array(
        'left_delimiter' => '{%',
        'right_delimiter' => '%}',
        'plugins_dir'=>'./Application/Smarty/Plugins/',
    ),

);
