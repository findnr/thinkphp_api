<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-07 15:49:30
 * @LastEditTime: 2023-12-29 09:53:20
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitSystem.php
 * QQ:504875043@qq.com
 */
/*
 * @Author: 程英明
 * @Date: 2023-02-07 15:49:30
 * @LastEditTime: 2023-03-05 09:17:34
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitSystem.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

use think\facade\Db;

trait TraitSystem
{
    public function actionGet()
    {
        $data = Db::name('action')->select();
        $data = $data->toArray();
        return sa(11, $data);
    }
    public function actionAdd()
    {
        try {
            Db::name('action')->strict(false)->insert($this->post);
            return sa(21);
        } catch (\Throwable $th) {
            return ea(21);
        }
    }
    public function actionMid()
    {
        try {
            Db::name('action')->strict(false)->where('id', (int)$this->post['id'])->update($this->post);
            return sa(31);
        } catch (\Throwable $th) {
            return ea(31);
        }
    }
    public function actionDel()
    {
        try {
            Db::name('action')->where('id', (int)$this->req['id'])->delete();
            return sa(41);
        } catch (\Throwable $th) {
            return ea(41);
        }
    }
    public function navtypeGet()
    {
        $data = Db::name('nav_type')->select();
        $data = $data->toArray();
        return sa(11, $data);
    }
    public function navtypeAdd()
    {
        try {
            Db::name('nav_type')->strict(false)->insert($this->req);
            return sa(21);
        } catch (\Throwable $th) {
            return ea(21);
        }
    }
    public function navtypeMid()
    {
        try {
            Db::name('nav_type')->strict(false)->where('id', (int)$this->post['id'])->update($this->post);
            return sa(31);
        } catch (\Throwable $th) {
            return ea(31);
        }
    }
    public function navtypeDel()
    {
        try {
            Db::name('nav_type')->where('id', (int)$this->req['id'])->delete();
            return sa(41);
        } catch (\Throwable $th) {
            return ea(41);
        }
    }
    public function configAdd()
    {
        try {
            Db::name('system_config')->strict(false)->insert($this->req);
            return sa(21);
        } catch (\Throwable $th) {
            return ea(21);
        }
    }
    public function configDel()
    {
        try {
            Db::name('system_config')->where('id', (int)$this->req['id'])->delete();
            return sa(41);
        } catch (\Throwable $th) {
            return ea(41);
        }
    }
    public function configGet()
    {
        $data = Db::name('system_config')->select();
        $data = $data->toArray();
        return sa(11, $data);
    }
    public function configMid()
    {
        try {
            Db::name('system_config')->strict(false)->where('id', (int)$this->post['id'])->update($this->post);
            return sa(31);
        } catch (\Throwable $th) {
            return ea(31);
        }
    }
}
