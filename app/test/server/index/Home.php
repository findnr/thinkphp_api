<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-23 18:32:45
 * @LastEditTime: 2022-12-24 08:16:55
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_server\app\test\server\index\Home.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\test\server\index;

use app\test\model\facade\User;

class Home extends Base
{
    public function ttt()
    {
        $data = User::find(1)->toArray();
        return ea('这是一个测试');
    }
}
