<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-11 14:44:30
 * @LastEditTime: 2023-05-09 15:00:48
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\Action.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class Action extends Base
{
  protected static function getSql()
  {
    $sql = [];
    try {

      Db::name('action')->where('1=1')->find();
    } catch (\Throwable $th) {
      echo 1231232;
      //throw $th;
      $sql[] = <<<str
         CREATE TABLE `action` (
            `id` int(11) NOT NULL COMMENT '自增ID',
            `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
            `action` varchar(255) NOT NULL DEFAULT '' COMMENT '操作的动作',
            `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标'
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='后台操作名称表'
        str;
      $sql[] = <<<str
        INSERT INTO `action` (`id`, `name`, `action`, `icon`) VALUES
        (1, '添加', 'add', ''),
        (2, '修改', 'mid', ''),
        (3, '删除', 'mid', ''),
        (4, '查询', 'get', '')
        str;
      $sql[] = <<<str
        ALTER TABLE `action` ADD PRIMARY KEY (`id`)
        str;
      $sql[] = <<<str
        ALTER TABLE `action` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=5
        str;
    }
    return $sql;
  }
}
