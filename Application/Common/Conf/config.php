<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '121.42.139.74', // 服务器地址
    'DB_NAME'   => 'map', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'map_', // 数据库表前缀

    'FILE_UPLOAD_TYPE'    =>    'Upyun',
    'UPLOAD_TYPE_CONFIG'  => array(
        // 又拍云服务器，根据自己的实际情况，选择一个即可
        // v0.api.upyun.com(自动判断)  v1.api.upyun.com(电信)
        // v2.api.upyun.com(联通网通)  v3.api.upyun.com (移动铁通)
        'host' => 'v0.api.upyun.com',

        // 空间名称
        'bucket' => 'my-traveling',

        // 操作员名称
        'username' => 'root',

        // 超时时间
        'timeout'  => 300,

        // 密码
        'password' => 'future!go8'
    ),

    'IMG_ROOT' => 'http://img.ericwwww.me/map/',

);