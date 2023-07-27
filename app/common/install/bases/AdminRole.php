<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-11 15:09:58
 * @LastEditTime: 2023-05-09 15:01:36
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\AdminRole.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class AdminRole extends Base
{
    protected static function getSql()
    {
        $sql = [];
        try {
            Db::name('admin_role')->where('1=1')->find();

            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $sql[] = <<<str
        CREATE TABLE `admin_role` (
            `id` int(11) NOT NULL COMMENT '自增ID',
            `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
            `parent_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '父ID',
            `auth` text NOT NULL DEFAULT '' COMMENT '权限列表',
            `auth_other` text NOT NULL DEFAULT '' COMMENT '半选状态的ID',
            `sort` tinyint(4) NOT NULL DEFAULT 100 COMMENT '排序',
            `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态'
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='后台角色表'
        str;
            $sql[] = <<<str
        INSERT INTO `admin_role` (`id`, `name`, `parent_id`, `auth`, `auth_other`, `sort`, `status`) VALUES (1, '超级管理员', 0, '', '', 1, 0)
        str;
            $sql[] = <<<str
        ALTER TABLE `admin_role` ADD PRIMARY KEY (`id`)
        str;
            $sql[] = <<<str
        ALTER TABLE `admin_role` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=2
        str;
        }

        return $sql;
    }
}
