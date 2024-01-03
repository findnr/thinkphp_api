<?php

declare(strict_types=1);

namespace app\common\serveradmin;

use think\facade\Db;
use think\facade\Config;

trait TraitUpload
{
    public function listGet()
    {
        $data = Db::name('upload_type')->select()->toArray();
        $res_data['oldData'] =  $this->_get_level($data);
        $num = 10;
        $where = $this->post;
        $page = empty($where['page']) ? 0 : $where['page'] - 1;
        $num = 10;
        $obj = Db::name('upload_content');
        if ($where['parent_id'] != 0) $obj = $obj->where('parent_id', $where['parent_id']);
        $res_data['total'] = $obj->count();
        $res_data['list'] = $obj->limit($page * $num, $num)->order('id DESC')->select()->toArray();
        return sa('获取成功', 200, $res_data);
    }
    public function listAdd()
    {
        $post = $this->post;
        $post['path'] = $this->fileOne();
        $post['create_time'] = time();
        try {
            Db::name('upload_content')->strict(false)->insert($post);
            return sa('添加成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('添加失败');
        }
    }
    public function listMid()
    {
        try {
            Db::name('upload_content')->strict(false)->where('id', $this->post['id'])->update($this->post);
            return sa('修改成功');
        } catch (\Throwable $th) {
            return ea('修改失败');
        }
    }
    public function listDel()
    {
        $file_config = Config::get('filesystem');
        $file = Db::name('upload_content')->where('id', (int)$this->post['id'])->find();
        if (!$file) return ea("没有可删除的内容");
        unlink($file_config['disks']['public']['root'] . '/' . $file['path']);
        try {
            Db::name('upload_content')->strict(false)->delete((int)$this->post['id']);
            return sa('删除成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('删除失败');
        }
    }
    public function typeGet()
    {
        $res_data = [];
        $data = Db::name('upload_type')->select()->toArray();
        $res_data['oldData'] =  $this->_get_level($data);
        $res_data['newData'] = auto_category($data, 1);
        return sa('获取成功', 200, $res_data);
    }
    public function typeAdd()
    {
        try {
            Db::name('upload_type')->strict(false)->insert(array_merge(['create_time' => time()], $this->post));
            return sa('添加成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('添加失败');
        }
    }
    public function typeMid()
    {
        try {
            Db::name('upload_type')->strict(false)->where('id', $this->post['id'])->update($this->post);
            return sa('修改成功');
        } catch (\Throwable $th) {
            return ea('修改失败');
        }
    }
    public function typeDel()
    {
        try {
            Db::name('upload_type')->strict(false)->delete((int)$this->post['id']);
            return sa('添加成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('添加失败');
        }
    }
    public function _get_level($data)
    {
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
}
