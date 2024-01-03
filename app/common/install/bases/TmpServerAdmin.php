<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 15:11:10
 * @LastEditTime: 2024-01-03 08:59:27
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\install\bases\TmpServerAdmin.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\install\bases;

class TmpServerAdmin extends Base
{
    protected static function dirName()
    {
        $name = 'server' . DIRECTORY_SEPARATOR . 'admin';
        return [$name, $name, $name, $name, $name, $name, $name];
    }
    protected static function fileName()
    {
        return ['Base.php', 'Common.php', 'MangerUser.php', 'User.php', 'Nav.php', 'System.php', 'Upload.php'];
    }
    protected static function fileContent()
    {
        $content = [];
        $content[] = self::_base();
        $content[] = self::_common();
        $content[] = self::_manger_user();
        $content[] = self::_user();
        $content[] = self::_nav();
        $content[] = self::_system();
        $content[] = self::_upload();
        return $content;
    }
    private static function _system()
    {
        $app = app('http')->getName();
        $str = '<?php
declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
class System extends Base
{
    use \app\common\serveradmin\TraitSystem;
}';
        return $str;
    }
    private static function _nav()
    {
        $app = app('http')->getName();
        $str = '<?php
declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
class Nav extends Base
{
    use \app\common\serveradmin\TraitNav;
}';
        return $str;
    }
    private static function _user()
    {
        $app = app('http')->getName();
        $str = '<?php
declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
class User extends Base
{
    use \app\common\serveradmin\TraitUser;
}';
        return $str;
    }
    private static function _manger_user()
    {
        $app = app('http')->getName();
        $str = '<?php
declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
class MangerUser extends Base
{
    use \app\common\serveradmin\TraitMangerUser;
}';
        return $str;
    }
    private static function _base()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
use app\common\base\ServerBase;
use think\App;
        
class Base extends ServerBase
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }
}';
        return $str;
    }
    private static function _common()
    {
        $app = app('http')->getName();
        $str = '<?php
declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
class Common extends Base
{
    use \app\common\serveradmin\TraitCommon;
}';
        return $str;
    }
    private static function _upload()
    {
        $app = app('http')->getName();
        $str = '<?php
declare(strict_types=1);
        
namespace app\\' . $app . '\server\admin;
        
class Common extends Base
{
    use \app\common\serveradmin\TraitUpload;
}';
        return $str;
    }
}
