<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-23 17:07:25
 * @LastEditTime: 2022-12-24 08:10:15
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_server\app\common\base\TraitModelFacade.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\base;

trait TraitModelFacade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        $class_path = explode('\\', __CLASS__);
        $path_arr = [$class_path[0], $class_path[1], $class_path[2], $class_path[4]];
        return implode('\\', $path_arr);
    }
}
