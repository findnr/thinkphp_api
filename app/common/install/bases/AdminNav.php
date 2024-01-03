<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-11 15:04:37
 * @LastEditTime: 2024-01-03 16:19:53
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\AdminNav.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class AdminNav extends Base
{
    protected static function getSql()
    {
        $sql = [];
        try {
            Db::name('admin_nav')->where('1=1')->find();
        } catch (\Throwable $th) {
            //throw $th;
            $sql[] = <<<str
        CREATE TABLE `admin_nav` (
            `id` int(11) NOT NULL COMMENT '自增ID',
            `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
            `index_url` varchar(255) NOT NULL DEFAULT '' COMMENT '前台url',
            `admin_url` varchar(255) NOT NULL DEFAULT '' COMMENT '后台url',
            `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
            `nav_type_id` smallint(255) NOT NULL DEFAULT 0 COMMENT '导航类型ID',
            `action_id` varchar(255) NOT NULL DEFAULT '' COMMENT '操作ID',
            `sort` smallint(255) NOT NULL DEFAULT 0 COMMENT '排序',
            `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
            `parent_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '父ID',
            `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态'
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='后台导航表信息'
        str;
            $sql[] = <<<str
            INSERT INTO `admin_nav` (`id`, `name`, `index_url`, `admin_url`, `icon`, `nav_type_id`, `action_id`, `sort`, `remark`, `parent_id`, `status`) VALUES
            (1, '系统首页', '/admin/home/home', '/admin/home/home', 'house', 1, '', 0, '', 0, 0),
            (2, '系统设置', '', '', 'tools', 1, '', 9, '', 0, 0),
            (3, '后台导航', '/admin/system/nav', '/admin/nav/nav', '', 1, '1,2,3,4', 100, '', 2, 0),
            (4, '导航类型', '/admin/system/navtype', '/admin/system/navtype', '', 1, '1,2,3,4', 100, '', 2, 0),
            (5, '操作动作', '/admin/system/action', '/admin/system/action', '', 1, '1,2,3,4', 100, '', 2, 0),
            (6, '个人中心', '', '', 'user-filled', 1, '', 10, '', 0, 0),
            (7, '个人信息', '/admin/user/info', '/admin/user/info', '', 1, '1,2,3,4', 100, '', 6, 0),
            (8, '修改密码', '/admin/user/password', '/admin/user/password', '', 1, '1,2,3,4', 100, '', 6, 0),
            (9, '退出系统', '/admin/user/loginout', '/admin/user/loginout', '', 1, '', 100, '', 6, 0),
            (10, '管理员管理', '', '', 'avatar', 1, '0', 8, '', 0, 0),
            (11, '添加管理员', '/admin/mangeruser/user', '/admin/mangerUser/user', '', 1, '1,2,3,4', 100, '', 10, 0),
            (12, '管理员权限管理', '/admin/mangeruser/auth', '/admin/mangerUser/auth', '', 1, '1,2,3,4', 100, '', 10, 0),
            (13, '组管理', '/admin/mangeruser/group', '/admin/mangerUser/group', '', 1, '1,2,3,4', 100, '', 10, 0),
            (14, '组权限管理', '/admin/mangeruser/groupauth', '/admin/mangerUser/groupAuth', '', 1, '1,2,3,4', 100, '', 10, 0),
            (15, '文件管理', '', '', 'Folder', 1, '', 0, '', 0, 0),
            (16, '文件上传', '/admin/upload/list', '/admin/upload/list', '', 1, '1,2,3,4', 0, '', 15, 0),
            (17, '文件分类管理', '/admin/upload/type', '/admin/upload/type', '', 1, '1,2,3,4', 0, '', 15, 0),
            (18, '系统配制', '/admin/system/config', '/admin/system/config', '', 1, '1,2,3,4', 100, '', 2, 0);
        str;
            $sql[] = <<<str
        ALTER TABLE `admin_nav` ADD PRIMARY KEY (`id`)
        str;
            $sql[] = <<<str
        ALTER TABLE `admin_nav` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=19
        str;
        }

        return $sql;
    }
}
