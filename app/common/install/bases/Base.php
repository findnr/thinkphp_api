<?php
/*
 * @Author: 程英明
 * @Date: 2023-02-15 11:32:33
 * @LastEditTime: 2023-05-09 15:01:33
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\Base.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

use think\facade\Db;

class Base
{
    public static function databases()
    {
        $sql_arr = static::getSql();
        array_walk($sql_arr, function ($v) {
            echo $v;
            try {
                Db::query($v);
                echo '-------> <p style="color:green;">success</p><br/>';
            } catch (\Throwable $th) {
                //throw $th;
                echo '-------> <p style="color:red;">fail</p><br/>';
            }
        });
    }
    public static function create()
    {
        $app_path = app_path();
        $dir_name = static::dirName();
        $file_name = static::fileName();
        $file_content = static::fileContent();
        array_walk($dir_name, function ($v, $k) use ($app_path, $file_content, $file_name) {
            $path = $app_path . DIRECTORY_SEPARATOR . $v;
            if (!is_dir($path)) mkdir($path, 0777, true);
            $file =  $path . DIRECTORY_SEPARATOR . $file_name[$k];
            if (!is_file($file)) file_put_contents($file, $file_content[$k]);
        });
    }
    protected static function dirName()
    {
        return [];
    }
    protected static function fileName()
    {
        return [];
    }
    protected static function fileContent()
    {
        return [];
    }
    protected static function getSql()
    {
        return [];
    }
}
