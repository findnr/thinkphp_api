<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-15 11:21:03
 * @LastEditTime: 2024-01-03 08:45:20
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\Admin.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class Admin extends Base
{
    protected static function getSql()
    {
        $sql = [];
        try {
            Db::name('admin')->where('1=1')->find();
        } catch (\Throwable $th) {
            //throw $th;
            $sql[] = <<<str
            CREATE TABLE `admin` (
                `id` int(11) NOT NULL COMMENT '自增ID',
                `uuid` varchar(255) NOT NULL DEFAULT '' COMMENT 'UUID',
                `name_login` varchar(255) NOT NULL DEFAULT '' COMMENT '登录名',
                `name_real` varchar(255) NOT NULL DEFAULT '' COMMENT '真实名',
                `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
                `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '电话',
                `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
                `wx_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信ID',
                `zfb_id` varchar(255) NOT NULL DEFAULT '' COMMENT '支付宝ID',
                `is_merge` tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否合并权限',
                `ar_id` mediumint(9) NOT NULL DEFAULT 0 COMMENT '分组ID',
                `auth` text NOT NULL DEFAULT '' COMMENT '权限列表',
                `auth_other` text NOT NULL DEFAULT '' COMMENT '半选状态的ID',
                `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态'
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='后台用户登录表'
            str;
            $sql[] = <<<str
            INSERT INTO `admin` (`id`, `uuid`, `name_login`, `name_real`, `password`, `phone`, `email`, `wx_id`, `zfb_id`, `is_merge`, `ar_id`, `auth`, `status`) VALUES
            (1, '', 'admin', '超级管理员', 'e10adc3949ba59abbe56e057f20f883e', '18085274020', '504875043@qq.com', '', '', 1, 1, '', 1)
            str;
            $sql[] = <<<str
            ALTER TABLE `admin` ADD PRIMARY KEY (`id`)
            str;
            $sql[] = <<<str
            ALTER TABLE `admin` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=2
            str;
        }
        return $sql;
    }
}
