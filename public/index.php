<?php
/*
 * @Author: 程英明
 * @Date: 2021-05-17 09:46:42
 * @LastEditTime: 2021-11-26 11:35:11
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\public\index.php
 * QQ:504875043@qq.com
 */

namespace think;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    return;
};
require __DIR__ . '/../vendor/autoload.php';


// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
