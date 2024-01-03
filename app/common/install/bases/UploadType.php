<?php

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class UploadType extends Base
{
    protected static function getSql()
    {
        $sql = [];
        try {
            Db::name('upload_type')->where('1=1')->find();
        } catch (\Throwable $th) {
            $sql[] = <<<str
            CREATE TABLE `upload_type` (
                `id` int(11) NOT NULL COMMENT '自增ID',
                `parent_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '父ID',
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
                `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
                `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态'
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='文件上传分类表'
        str;
            $sql[] = <<<str
            ALTER TABLE `upload_type` ADD PRIMARY KEY (`id`)
        str;
            $sql[] = <<<str
            ALTER TABLE `upload_type` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID'
        str;
        }
        return $sql;
    }
}
