<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-07 16:01:07
 * @LastEditTime: 2023-07-20 11:31:05
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitAdminAuth.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

use think\App;
use think\facade\Db;

trait TraitAdminAuth
{
    public $app;

    public $path;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->path = explode('/', $this->app->request->pathinfo());
    }

    public function handle($request, \Closure $next)
    {
        $data = $this->_auto_auth($request);
        if ($data['code'] != 200) {
            $data['path'] = 'admin';
            return json($data);
        }

        return $next($request);
    }

    public function _auto_auth(&$request)
    {
        if ($this->path[1] == 'common') {
            $token_data = $this->_encode_token($request);
            return $token_data;
        } else {
            $path_data = $this->_set_path();
            if ($path_data['code'] == 400) return $path_data;
            $token_data = $this->_encode_token($request);
            if ($token_data['code'] != 200) return $token_data;
            $user_data = $this->_user_auth($request);
            return $user_data;
        }
    }

    public function _set_path()
    {
        if (empty($this->path[2]) || empty($this->path[3])) return ea('路径有问题，没有权限使用');
        $this->app->request->setPathinfo($this->path[0] . '/' . $this->path[1] . '/' . $this->path[2] . ucfirst($this->path[3]));
        return sa('设置成功');
    }

    public function _encode_token(&$request)
    {
        if (!$request->header("authorization")) return ea("没有传输token", 500);
        $token_arr = jwt_de($request->header("authorization"), $this->path[0]);
        if (empty($token_arr) || $token_arr['code'] != 1) {
            return ea("用户登录已过期，请重新登录！", 500);
        }
        $request->user = $token_arr['data']['data'];
        return sa('解析成功');
    }

    public function _user_auth(&$request)
    {
        $user = Db::name('admin')->where('id', (int)$request->user->id)->find();
        if ($user == null) return ea('用户不存在');
        if ($user['ar_id'] == 1) {
            return sa('验证成功');
        } else {
            return $this->_path_auth($user);
        }
    }

    public function _path_auth(&$user)
    {
        $nav_data = $this->_merge_auth($user);
        $path = '/' . $this->path[0] . '/' . $this->path[1] . '/' . $this->path[2];
        $nav_one = Db::name('admin_nav')->where('admin_url', (string) $path)->find();
        if ($nav_one == null) return ea('没有使用权限！请联系管理员nav');
        $action_one = Db::name('action')->where('action', (string)$this->path[3])->find();
        if ($action_one == null) return ea('没有使用权限！请联系管理员action');
        $key = $nav_one['id'] . '|' . $action_one['id'];
        if (isset($nav_data[$key])) return sa(11);
        return ea('没有使用权限！请联系管理员end');
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
        return $new_auth;
    }
}
