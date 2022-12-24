<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-23 16:43:24
 * @LastEditTime: 2022-12-24 08:16:21
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_server\app\common\base\ControllerBase.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\base;

use think\App;

require_once dirname(__DIR__) . "/common.php";

class ControllerBase
{
    protected $app;
    public function __construct(App $app)
    {
        $this->app = $app;
    }
    protected function getClass()
    {
    }
    public function __call($name, $argc)
    {
        $name = $this->getClass() . ucfirst($this->app->request->action());
        $method = explode('/', $this->app->request->pathinfo())[2];
        if (class_exists($name)) {
            $obj = $this->app->make($name, [], false);
        } else {
            $obj = false;
        }
        if ($obj === false) return e('没有' . $name . '类');
        if (empty($method)) return e('必须传参数method');
        $res_data = call_user_func_array([$obj, $method], [&$argc]);
        if (!$res_data) return e($name . "类中没有些方法:" . $method);
        //判断如没有数据就是返回错误信息
        if (empty($res_data['data'])) {
            return e($res_data['msg'], $res_data['code']);
        } else {
            return s($res_data['msg'], $res_data['code'], $res_data['data']);
        }
    }
}
