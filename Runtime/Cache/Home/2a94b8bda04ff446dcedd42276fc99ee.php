<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>可能是相册( ・ˍ・)</title>
    <link rel="icon" href="/canvasMap/Public/static/img/logo.png">
<link rel="stylesheet" href="/canvasMap/Public/static/amazeui/css/amazeui.min.css">

    <style>
        .wrapper{
            position: relative;
        }
        .bg{
            background-image: url(<?php echo ($bingURL); ?>);
            background-size:cover;
            height:100vh;

        }
        .cover{
            height: 100vh;
            width: 100vw;
            background: rgba(0,0,0,0.3);
            position: absolute;
            top: 0;
            left: 0;
        }
        .info{
            position:fixed;
            bottom:0;
            height: 35px;
            width: 100vw;
            background: #333;
            padding-right: 10px;
        }
        .info ol{
            line-height: 17px;
            float: right;
        }
        .info ol a{
            color:#999
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="bg"></div>
    <div class="cover"></div>
    <div class="info">
        <ol class="am-breadcrumb am-breadcrumb-slash">
            <li><a href="#">浙ICP备16036525号</a></li>
            <li><a href="#">@Eric</a></li>
            <li><a href="#">管理</a></li>
        </ol>
    </div>
</div>
<script src="/canvasMap/Public/static/js/jquery-1.9.1.min.js"></script>
<script src="/canvasMap/Public/static/amazeui/js/amazeui.min.js"></script>
</body>
</html>