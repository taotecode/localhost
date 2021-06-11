<?php
/**
 * ${NAME}
 * @project aix
 * @copyright
 * @author chenjw
 * @version
 * @date: 2021/6/9
 * @createTime 17:11
 * @filename header.php
 * @product_name PhpStorm
 * @link
 * @example
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/template/asster/layui-v2.6.8/css/layui.css" />
    <title>陈江伟-本地环境信息</title>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="/template/asster/layui-v2.6.8/layui.js"></script>
    <style>
        .site-dir li{line-height: 26px; margin-left: 20px; overflow: visible; list-style-type: disc;}
        .site-dir li a{display: block;}
        .site-dir li a:active{color: #01AAED;}
        .site-dir li a.layui-this{color: #01AAED;}
        body .layui-layer-dir{box-shadow: none;border: 1px solid #d2d2d2;margin-left: -15px;}
        body .layui-layer-dir .layui-layer-content{padding: 10px;}
        .site-dir a em{padding-left: 5px; font-size: 12px; color: #c2c2c2; font-style: normal;}
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header layui-bg-blue">
        <ul class="layui-nav layui-bg-blue layui-nav-tree layui-nav-side" lay-filter="">
            <?php echo munu($app) ?>
        </ul>
    </div>
    <div class="layui-body" style="padding: 15px;margin-bottom: 44px">
        <!-- 内容主体区域 -->