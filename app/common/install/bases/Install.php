<?php
/*
 * @Author: 程英明
 * @Date: 2023-05-09 15:03:42
 * @LastEditTime: 2023-05-09 15:06:38
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\Install.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class Install
{
    public static function run()
    {
        /** 创建数据库中的表------------------------------------------- */
        Admin::databases();
        Action::databases();
        AdminNav::databases();
        AdminRole::databases();
        NavType::databases();
        /** 创建模型控制器和中间件------------------------------------------- */
        TmpController::create();
        TmpServerAdmin::create();
        TmpServerLogin::create();
        TmpMiddleware::create();
        /** 创建模型 ---------------------------------------------------- */
        self::_create_model();
    }
    private static function _create_model()
    {
        $data = Db::query('show tables');
        $str = array_keys($data[0])[0];
        $model_obj = new \app\common\create\Model();
        array_walk($data, function ($v, $k) use ($model_obj, $str) {
            $name = parse_name($v[$str], 1, true);
            if ($name) {
                $model_obj->setName($name);
                $model_obj->run();
            }
        });
    }
}
