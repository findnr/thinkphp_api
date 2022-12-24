<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-23 18:38:22
 * @LastEditTime: 2022-12-23 18:49:24
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_server\app\common\base\TraitController.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\base;

trait TraitController
{
    protected function getClass()
    {
        $class_path = explode('\\', __CLASS__);
        $path_arr = [$class_path[0], $class_path[1], 'server', lcfirst($class_path[3])];
        return implode('\\', $path_arr) . '\\';
    }
}
