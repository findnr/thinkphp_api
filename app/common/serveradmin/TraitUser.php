<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-10 11:01:29
 * @LastEditTime: 2023-02-10 16:21:07
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitUser.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

use think\facade\Db;

trait TraitUser
{
    public function passwordGet()
    {
    }
    /**
     * 密码修改
     *
     * @return  [type]  [return description]
     */
    public function passwordMid()
    {
        $user = Db::name('admin')->where('id', (int) $this->user->id)->find();
        if ($user == null) return ea('没有此用户');
        if ($user['password'] != md5($this->req['passwordo'])) return ea('旧密码不一样，不能修改，请联系管理员');
        if ($this->req['passwordn'] != $this->req['passwordc']) return ea('两次输入密码不一样，无法修改');
        try {
            Db::name('admin')->where('id', (int) $this->user->id)->update(['password' => md5($this->req['passwordn'])]);
            return sa('密码更新成功');
        } catch (\Throwable $th) {
            //throw $th;
            return ea('密码更新失败');
        }
    }
    public function infoGet()
    {
        $user = Db::name('admin')->where('id', (int) $this->user->id)->find();
        if ($user == null) return ea('没有信息');
        return sa('获取成功', $user);
    }
}
