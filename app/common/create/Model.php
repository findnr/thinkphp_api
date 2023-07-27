<?php
/*
 * @Author: 程英明
 * @Date: 2023-04-12 16:08:23
 * @LastEditTime: 2023-04-26 13:41:19
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\create\Model.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\create;

use think\facade\Db;

class Model
{
    private $table_name;
    public function __construct(string $name = '')
    {
        $this->table_name = $name;
    }
    public function run()
    {
        if ($this->table_name == '') return;
        $app_path = app_path();
        $dir_name = $this->_dir_name();
        $file_name = $this->_file_name();
        $file_content = $this->_file_content();
        array_walk($dir_name, function ($v, $k) use ($app_path, $file_content, $file_name) {
            $path = $app_path . DIRECTORY_SEPARATOR . $v;
            if (!is_dir($path)) mkdir($path, 0777, true);
            $file =  $path . DIRECTORY_SEPARATOR . $file_name[$k];
            if (!is_file($file)) file_put_contents($file, $file_content[$k]);
        });
    }
    public function createAll()
    {
        $data = Db::query('show tables');
        $str = array_keys($data[0])[0];
        array_walk($data, function ($v, $k) use ($str) {
            $name = parse_name($v[$str], 1, true);
            if ($name) {
                $this->setName($name);
                $this->run();
            }
        });
    }
    public function setName(string $name)
    {
        $this->table_name = $name;
    }
    private function _dir_name()
    {
        return ['model', 'model' . DIRECTORY_SEPARATOR . 'facade', 'model', 'model' . DIRECTORY_SEPARATOR . 'facade'];
    }
    private function _file_name()
    {
        return [$this->table_name . '.php', $this->table_name . '.php', 'Base.php', 'Base.php'];
    }
    private function _file_content()
    {
        $content = [];
        $content[] = $this->_table();
        $content[] = $this->_facade_table();
        $content[] = $this->_table_base();
        $content[] = $this->_facade_table_base();
        return $content;
    }
    private function _table()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\model;
        
class ' . $this->table_name . ' extends Base
{
}';
        return $str;
    }
    private function _facade_table()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\model\facade;
        
class ' . $this->table_name . ' extends Base
{
    use \app\common\base\TraitModelFacade;
}';
        return $str;
    }
    private function _table_base()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\model;
        
use app\common\base\ModelBase;
        
class Base extends ModelBase
{
}';
        return $str;
    }
    private function _facade_table_base()
    {
        $app = app('http')->getName();
        $str = '<?php

declare(strict_types=1);
        
namespace app\\' . $app . '\model\facade;
        
use app\common\base\ModelFacadeBase;
        
class Base extends ModelFacadeBase
{
}';
        return $str;
    }
}
