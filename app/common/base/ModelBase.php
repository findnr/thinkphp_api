<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-23 16:54:00
 * @LastEditTime: 2022-12-23 16:54:09
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_server\app\common\base\ModelBase.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\base;

use think\Model;

class ModelBase extends Model
{
    protected $autoWriteTimestamp = false;

    public function getIndex(array $where = [], string $withoutField = ''): array
    {
        if (count($where) == 0) {
            $data = $this->withoutField($withoutField)->select()->toArray();
        } else {
            $data = $this->withoutField($withoutField)->whereIn('id', $where)->select()->toArray();
        }
        if (count($data) == 0) return [];
        $new_data = [];
        array_walk($data, function ($v) use (&$new_data) {
            $new_data[$v['id']] = $v;
        });
        return $new_data;
    }
}
