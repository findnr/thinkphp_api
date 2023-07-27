<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 16:07:36
 * @LastEditTime: 2023-04-12 16:07:43
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\create\Base.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\create;

class Base
{
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
}
