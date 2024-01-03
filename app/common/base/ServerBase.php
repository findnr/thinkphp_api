<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-23 16:45:41
 * @LastEditTime: 2023-07-19 09:23:19
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\base\ServerBase.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\base;

use think\App;
use think\facade\Filesystem;
use think\facade\Db;

class ServerBase
{
    protected $app;
    protected $bind;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->bind = [];
    }
    /**
     * 获取请参数
     *
     * @return  [type]  [return description]
     */
    private function req()
    {
        $this->bind['req'] = $this->app->request->param();
        return $this->bind['req'];
    }
    /**
     * 获取post信息
     *
     * @return  [type]  [return description]
     */
    private function post()
    {
        $this->bind['post'] = $this->app->request->post();
        return $this->bind['post'];
    }
    /**
     * token获取用户信息
     *
     * @return  [type]  [return description]
     */
    private function user()
    {
        $this->bind['user'] = $this->app->request->user;
        return $this->bind['user'];
    }
    /**
     * 获取文件
     *
     * @return  [type]  [return think\file\UploadedFile]
     */
    private function file()
    {
        $this->bind['file'] = $this->app->request->file();
        return $this->bind['file'];
    }
    private function fileTxt()
    {
        $this->bind['fileTxt'] = [];
        $tmp_path = $this->app->request->file()['file'][0]->getPathName();
        if (is_file($tmp_path)) {
            $str = file_get_contents($tmp_path);
            $this->bind['fileTxt']['arr'] = txt_to_arr($str);
            $this->bind['fileTxt']['str'] = $str;
        }
        return $this->bind['fileTxt'];
    }
    /**
     * 单个文件
     *
     * @param   string  $name  [$name description]
     * @param   array   $file  [$file description]
     *
     * @return  []             [return description]
     */
    public function fileOne(string $name = '', array $file = [])
    {
        $sys_config = null;
        if ($name == '') {
            try {
                $sys_config = Db::name('system_config')->where('status', 1)->where('get_name', 'file_upload_path')->find();
            } catch (\Throwable $th) {
            }
        }
        if ($sys_config) {
            $name = $sys_config['content'];
        }
        $file = count($file) == 0 ? $this->file['file'][0] : $file;
        return Filesystem::disk('public')->putFile($name, $file);
    }
    /**
     * 多个文件
     *
     * @param   string  $name   [$name description]
     * @param   array   $files  [$files description]
     *
     * @return  []              [return description]
     */
    public function fileMore(string $name = '', array $files = [])
    {
        $sys_config = null;
        if ($name == '') {
            try {
                $sys_config = Db::name('system_config')->where('status', 1)->where('get_name', 'file_upload_path')->find();
            } catch (\Throwable $th) {
            }
        }
        if ($sys_config) {
            $name = $sys_config['content'];
        }
        $savename = [];
        $files = count($files) == 0 ? $this->file['file'] : $files;
        foreach ($files as $file) {
            $savename[] = Filesystem::disk('public')->putFile($name, $file);
        }
        return $savename;
    }
    public function get($name)
    {
        if (isset($this->bind[$name])) return $this->bind[$name];
        try {
            return call_user_func_array([$this, $name], []);
        } catch (\Throwable $th) {
            //throw $th;
            return ea('没有对应的方法，请写对应的方法实现。');
        }
    }
    public function __get($name)
    {
        return $this->get($name);
    }
    public function set($name, $argc)
    {
        $this->bind[$name] = $argc;
    }
    public function __set($name, $argc)
    {
        return $this->set($name, $argc);
    }
    public function __call($name, $argc)
    {
        return ea(static::class . '此类中没有方法' . $name);
    }
}
