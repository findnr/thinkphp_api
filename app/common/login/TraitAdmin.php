<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 15:31:18
 * @LastEditTime: 2023-06-20 13:32:00
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\login\TraitAdmin.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\login;

use think\facade\Cache;
use think\facade\Db;

trait TraitAdmin
{
    public function login()
    {
        $code = $this->check($this->req['code_key'], $this->req['code']);
        if ($code['code'] == 400) return $code;
        $obj = Db::name('admin')->where('name_login', $this->req['name'])->find();
        if (!$obj || ($obj['password'] != md5($this->req['pwd']))) return ea('用户名和密码错误');
        $data['id'] = $obj['id'];
        $data['uuid'] = $obj['uuid'];
        $token = jwt_en($data, 'admin');
        return sa('登录成功', 200, array_merge(['adminToken' => $token], ['name_real' => $obj['name_real']]));
    }
    public function check(string $key, string $code): array
    {
        $cache_code = Cache::get($key);
        if (!$code) return ea('验证不能为空');
        if ($cache_code == $code) return sa('验证成功');
        return ea('验证码不正确');
    }
    public function checkToken()
    {
        $data = jwt_de($this->post['token'], 'admin');
        if ($data['code'] == 1) return sa('可用');
        return ea('不可用');
    }
}
