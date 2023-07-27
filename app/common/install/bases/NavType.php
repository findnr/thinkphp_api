<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-11 15:12:18
 * @LastEditTime: 2023-05-09 15:01:31
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\NavType.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class NavType extends Base
{
    protected static function getSql()
    {
        $sql = [];

        try {
            Db::name('nav_type')->where('1=1')->find();
        } catch (\Throwable $th) {
            echo 213421;
            //throw $th;
            $sql[] = <<<str
        CREATE TABLE `nav_type` (
            `id` int(11) NOT NULL COMMENT '自增ID',
            `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称'
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='导航类型表'
        str;
            $sql[] = <<<str
        INSERT INTO `nav_type` (`id`, `name`) VALUES
        (1, '纵向'),
        (2, '横向')
        str;
            $sql[] = <<<str
        ALTER TABLE `nav_type` ADD PRIMARY KEY (`id`)
        str;
            $sql[] = <<<str
        ALTER TABLE `nav_type` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=3
        str;
        }
        return $sql;
    }
}
