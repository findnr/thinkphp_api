<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-07 15:17:28
 * @LastEditTime: 2023-07-20 16:56:31
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitNav.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

use think\facade\Db;

trait TraitNav
{
    public function navAdd()
    {
        try {
            $req = $this->req;
            $req['action_id'] = empty($req['action_id']) ? '' : implode(',', $req['action_id']);
            Db::name('admin_nav')->strict(false)->insert($req);
            return sa('添加成功');
        } catch (\Throwable $th) {
            throw $th;
            return ea('添加失败');
        }
    }
    public function navMid()
    {
        $req = $this->post;
        if (!empty($req['action_id_arr'])) {
            if ($req['action_id_arr'][0] == 0) unset($req['action_id_arr'][0]);
            $req['action_id'] = implode(',', $req['action_id_arr']);
        } else {
            $req['action_id'] = '';
        }
        try {
            Db::name('admin_nav')->strict(false)->where('id', $req['id'])->update($req);
            return sa('修改成功');
        } catch (\Throwable $th) {
            return ea("修改失败");
        }
    }

    public function navGet()
    {
        $data = [];
        $data['navType'] = Db::name('nav_type')->select()->toArray();
        $data['action'] = Db::name('action')->select()->toArray();
        $cate_data = Db::name('admin_nav')->order('sort')->select()->toArray();
        $data['adminNav'] = auto_category($cate_data, 1);
        $cate_data = auto_category($cate_data, 0);
        $res_data = [];
        array_walk($cate_data, function ($v) use (&$res_data) {
            if ($v['level'] != 0) {
                $v['name'] = '|' . str_repeat('__', $v['level']) . $v['name'];
                $res_data[] = $v;
            } else {
                $res_data[] = $v;
            }
        });
        $data['selectData'] = $res_data;
        return sa('获取成功', 200, $data);
    }

    public function navDel()
    {
        try {
            Db::name('admin_nav')->delete((int)$this->req['id']);
            return sa('删除成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('删除失败');
        }
    }
}
