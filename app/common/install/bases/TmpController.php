<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 13:35:20
 * @LastEditTime: 2023-05-09 15:01:29
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\TmpController.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

class TmpController extends Base
{
    protected static function dirName()
    {
        return ['controller', 'controller', 'controller'];
    }
    protected static function fileName()
    {
        return ['Base.php', 'Admin.php', 'Login.php'];
    }
    protected static function fileContent()
    {
        $content = [];
        $content[] = self::_base();
        $content[] = self::_admin();
        $content[] = self::_login();
        return $content;
    }
    private static function _base()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);

namespace app\\' . $app . '\controller;

use app\common\base\ControllerBase;

class Base extends ControllerBase
{
}';
        return $str;
    }
    private static function _admin()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\controller;
        
class Admin extends Base
{
    use \app\common\base\TraitController;
    protected $middleware = [\app\\' . $app . '\middleware\Auth::class];
}';
        return $str;
    }
    private static function _login()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\controller;
        
class Login extends Base
{
    use \app\common\base\TraitController;
}';
        return $str;
    }
}
