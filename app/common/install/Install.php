<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-15 11:14:17
 * @LastEditTime: 2023-05-09 15:08:04
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\Install.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install;

use app\common\install\bases\Install as Bases;

class Install
{
    public static function bases()
    {
        Bases::run();
    }
}
