<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-07 15:30:34
 * @LastEditTime: 2023-04-11 09:39:14
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitMangerUser.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

use think\facade\Db;

trait TraitMangerUser
{
    public function userAdd()
    {
        try {
            $req = $this->req;
            $req['password'] = md5($req['password']);
            Db::name('admin')->strict(false)->insert($req);
            return sa('添加成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('添加失败');
        }
    }
    public function userDel()
    {
        try {
            Db::name('admin')->strict(false)->where('id', $this->req['id'])->delete();
            return sa(41);
        } catch (\Throwable $th) {
            //throw $th;
            return ea(41);
        }

        return sa('添加成功');
    }
    public function userMid()
    {
        try {
            Db::name('admin')->strict(false)->where('id', $this->req['id'])->update($this->req);
            return sa('修改成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('修改失败');
        }
    }
    public function userGet()
    {
        $data = [];
        $data['user'] = $this->_get_total();
        $data['role'] = $this->_get_level();
        return sa('获取成功', 200, $data);
    }
    public function _get_total(int $mode = 2)
    {
        if ($mode == 2) {
            $own_data = Db::name('admin')->select()->toArray();
        } else {
            $own_data = Db::name('admin')->where('status', $mode)->select()->toArray();
        }

        $data = Db::name('admin_role')->select()->toArray();;

        $new_data = [];
        array_walk($data, function ($v) use (&$new_data) {
            $new_data[$v['id']] = $v;
        });
        $data = $new_data;
        if (count($own_data) == 0) return [];
        $ret_data = [];
        array_walk($own_data, function ($v) use (&$ret_data, &$data) {
            $tmp = [];
            $tmp['ar_name'] = empty($data[$v['ar_id']]) ? '' : $data[$v['ar_id']]['name'];
            $tmp['auth'] = ($v['is_merge'] == 0) ? $v['auth'] : merge_auth([$v['auth'], $data[$v['ar_id']]['auth']]);
            $ret_data[] = array_merge($v, $tmp);
        });
        return $ret_data;
    }
    public function _get_level()
    {
        $data = Db::name('admin_role')->select()->toArray();
        $data = auto_category($data, 0);
        $res_data = [];
        array_walk($data, function ($v) use (&$res_data) {
            if ($v['level'] != 0) {
                $v['name'] = '|' . str_repeat('__', $v['level']) . $v['name'];
                $res_data[] = $v;
            } else {
                $res_data[] = $v;
            }
        });
        return $res_data;
    }
    public function authGet()
    {
        $res_data = [];
        $res_data['user'] = $this->_get_total(1);
        $data = Db::name('admin_nav')->select()->toArray();
        $action = Db::name('action')->select()->toArray();
        $res_data['navList'] = auto_category($data, 3, $action);
        return sa('获取成功', 200, $res_data);
    }
    public function authAdd()
    {
    }

    public function authDel()
    {
    }
    public function authMid()
    {
        try {
            Db::name('admin')->strict(false)->where('id', $this->post['id'])->update($this->post);
            return sa('更新成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('更新失败');
        }
    }
    public function groupGet()
    {
        $res_data = [];
        $data = Db::name('admin_role')->order('sort ASC')->select()->toArray();
        $res_data['oldData'] =  $this->_get_level();
        $res_data['newData'] = auto_category($data, 1);
        return sa('获取成功', 200, $res_data);
    }
    public function groupAdd()
    {
        try {
            Db::name('admin_role')->strict(false)->insert($this->post);
            return sa('添加成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('添加失败');
        }
    }
    public function groupDel()
    {
        try {
            Db::name('admin_role')->strict(false)->delete((int)$this->post['id']);
            return sa('添加成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('添加失败');
        }
    }
    public function groupMid()
    {
        try {
            Db::name('admin_role')->strict(false)->where('id', $this->post['id'])->update($this->post);
            return sa('修改成功');
        } catch (\Throwable $th) {
            return ea('修改失败');
        }
    }
    public function groupAuthGet()
    {
        $res_data = [];
        $data = Db::name('admin_role')->select()->toArray();
        $res_data['newData'] = auto_category($data, 1);
        $data = Db::name('admin_nav')->select()->toArray();
        $action = Db::name('action')->select()->toArray();
        $res_data['navList'] = auto_category($data, 3, $action);
        return sa('获取成功', 200, $res_data);
    }
    public function groupAuthDel()
    {
    }
    public function groupAuthMid()
    {
        try {
            Db::name('admin_role')->strict(false)->where('id', $this->post['id'])->update($this->post);
            return sa('更新成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('更新失败');
        }
    }
}
