<?php

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class SystemConfig extends Base
{
    protected static function getSql()
    {
        $sql = [];
        try {
            Db::name('system_config')->where('1=1')->find();
        } catch (\Throwable $th) {
            $sql[] = <<<str
            CREATE TABLE `system_config` (
                `id` int(11) NOT NULL COMMENT '自增ID',
                `get_name` varchar(255) NOT NULL DEFAULT '' COMMENT '取值',
                `info` varchar(255) NOT NULL DEFAULT '' COMMENT '中文说明',
                `content` varchar(255) NOT NULL DEFAULT '' COMMENT '具体内容',
                `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态'
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='系统配制表'
        str;
            $sql[] = <<<str
            INSERT INTO `system_config` (`id`, `get_name`, `info`, `content`, `status`) VALUES
            (1, 'file_upload_path', '文件上传地址', 'test', 1)
        str;
            $sql[] = <<<str
            ALTER TABLE `system_config` ADD PRIMARY KEY (`id`)
        str;
            $sql[] = <<<str
            ALTER TABLE `system_config` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID', AUTO_INCREMENT=2
        str;
        }
        return $sql;
    }
}
