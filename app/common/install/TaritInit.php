<?php
/*
 * @Author: 程英明
 * @Date: 2023-07-27 10:33:47
 * @LastEditTime: 2023-07-27 10:36:52
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\TaritInit.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install;

use app\common\install\Install as Ins;
use app\common\create\Model;

trait TaritInit
{
    public function admin()
    {
        Ins::bases();
        return json(['非法访问']);
    }
    public function createModel()
    {
        $tttobj = new Model();
        $tttobj->createAll();
        echo "model create success";
        return;
    }
}
