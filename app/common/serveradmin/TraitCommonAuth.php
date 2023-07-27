<?php
/*
 * @Author: 程英明
 * @Date: 2023-06-26 13:50:57
 * @LastEditTime: 2023-06-26 14:06:25
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\serveradmin\TraitCommonAuth.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\serveradmin;

trait TraitCommonAuth
{
    public function handle($request, \Closure $next)
    {
        $code = empty($this->code) ? 500 : $this->code;
        $type = empty($this->type) ? 'admin' : $this->type;
        if (!$request->header("authorization")) return e("用户登录已过期，请重新登录！", $code);
        $token_arr = jwt_de($request->header("authorization"), $type);
        if (empty($token_arr) || $token_arr['code'] != 1) {
            return e("用户登录已过期，请重新登录！", $code);
        }
        $request->user = $token_arr['data']['data'];
        return $next($request);
    }
}
