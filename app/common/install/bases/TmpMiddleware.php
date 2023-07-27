<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 15:54:29
 * @LastEditTime: 2023-05-09 15:02:51
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\TmpMiddleware.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

class TmpMiddleware extends Base
{
    protected static function dirName()
    {
        return ['middleware'];
    }
    protected static function fileName()
    {
        return ['Auth.php'];
    }
    protected static function fileContent()
    {
        $content = [];
        $content[] = self::_auth();
        return $content;
    }
    private static function _auth()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\middleware;
        
class Auth
{
    use \app\common\serveradmin\TraitAdminAuth;
}';
        return $str;
    }
}
