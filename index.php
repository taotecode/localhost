<?php
/**
 * ${NAME}
 * @project localhost
 * @copyright 院主网络科技
 * @author yuanzhumc
 * @version 1.0
 * @date: 2021/6/9
 * @createTime 17:10
 * @filename index.php
 * @product_name PhpStorm
 * @link https://github.com/yuanzhumc/localhost
 * @example
 */

error_reporting(E_ALL);

include "lib/Env.php";
include "app/common.php";
ProjectParamFile();

$app = $_GET['app'] ?: 'app/index';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include viewShow($app);
    exit();
}


include "template/view/include/header.php";

include viewShow($app);

include 'template/view/include/footer.php';