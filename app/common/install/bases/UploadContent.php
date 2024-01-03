<?php

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class UploadContent extends Base
{
    protected static function getSql()
    {
        $sql = [];
        try {
            Db::name('upload_content')->where('1=1')->find();
        } catch (\Throwable $th) {
            $sql[] = <<<str
            CREATE TABLE `upload_content` (
                `id` int(11) NOT NULL COMMENT '自增尖',
                `parent_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '父ID',
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
                `path` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
                `ext` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展名',
                `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
                `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态'
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='文件列表'
        str;
            $sql[] = <<<str
            ALTER TABLE `upload_content` ADD PRIMARY KEY (`id`)
        str;
            $sql[] = <<<str
            ALTER TABLE `upload_content` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID'
        str;
        }
        return $sql;
    }
}
