<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 15:06:49
 * @LastEditTime: 2023-05-09 15:02:07
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\TmpServerLogin.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

class TmpServerLogin extends Base
{
    protected static function dirName()
    {
        $name = 'server' . DIRECTORY_SEPARATOR . 'login';
        return [$name, $name];
    }
    protected static function fileName()
    {
        return ['Base.php', 'Admin.php'];
    }
    protected static function fileContent()
    {
        $content = [];
        $content[] = self::_base();
        $content[] = self::_admin();
        return $content;
    }
    private static function _base()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\server\login;
        
use app\common\base\ServerBase;
        
class Base extends ServerBase
{
}';
        return $str;
    }
    private static function _admin()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\server\login;
        
class Admin extends Base
{
    use \app\common\login\TraitAdmin;
}';
        return $str;
    }
}
