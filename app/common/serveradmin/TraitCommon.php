<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-07 15:55:02
 * @LastEditTime: 2023-09-05 13:46:17
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitCommon.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

use think\facade\Db;

trait TraitCommon
{
    public function getNav()
    {
        $user = Db::name('admin')->where('id', (int) $this->user->id)->find();
        if (!$user) return ea('没有用户信息');
        if ($user['ar_id'] == 1) {
            $nav_data = Db::name('admin_nav')->order('sort AES')->select()->toArray();
        } else {
            $nav_data = [];
            $where_in = $this->_merge_auth($user);
            if (count($where_in) != 0) {
                $nav_data = Db::name('admin_nav')->whereIn('id', $where_in)->order('sort AES')->select()->toArray();
            }
        }
        return sa('成功', 200, auto_category($nav_data, 2));
    }
    private function _merge_auth(&$user)
    {
        if ($user['is_merge'] == 1) {
            $role_data = Db::name('admin_role')->where('id', $user['ar_id'])->find();
        }
        $new_auth = [];
        if (!empty($role_data['auth'])) {
            if (!empty($role_data['auth_other'])) $role_data['auth'] = $role_data['auth'] . ',' . $role_data['auth_other'];
            $role_auth = explode(',', $role_data['auth']);
            array_walk($role_auth, function ($v) use (&$new_auth) {
                $new_auth[$v] = 1;
            });
        }
        if (!empty($user['auth'])) {
            if (!empty($user['auth_other'])) $user['auth'] = $user['auth'] . ',' . $user['auth_other'];
            $user_auth = explode(',', $user['auth']);
            array_walk($user_auth, function ($v) use (&$new_auth) {
                $new_auth[$v] = 1;
            });
        }
        return array_keys($new_auth);
    }
}
