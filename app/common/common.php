<?php
// 这是系统自动生成的公共文件

use think\facade\Config;
use CymPhptools\CymJwt;

function id_car_sex($id_car)
{
    if ((substr($id_car, -2, 1) % 2 == 0)) return '女';
    return '男';
}
/**
 * token加密
 *
 * @param   array   $data  [$data description]
 * @param   int     $mode  [$mode description]
 *
 * @return  string         [return description]
 */
function jwt_en(?array $data, ?int $mode = 0): string
{
    $config['key'] = get_key($mode);
    $config['time'] = 60 * 60 * 8;
    $config['data'] = $data;
    return CymJwt::token_encode($config);
}
/**
 * token解密
 *
 * @param   string  $token  [$token description]
 * @param   int     $mode   [$mode description]
 *
 * @return  array           [return description]
 */
function jwt_de(?string $token, ?int $mode = 0): array
{
    $config['key'] = get_key($mode);
    $config['token'] = $token;
    $data = CymJwt::token_decode($config);
    return $data;
}
function get_key(?int $mode = 0): string
{
    $key = '';
    switch ($mode) {
        case 0:
            $key = Config::get('key.admin_token_key');
            break;
        case 1:
            $key = Config::get('key.user_token_key');
            break;
        default:
            $key = Config::get('key.user_token_key');
            break;
    }
    return $key;
}

use think\facade\Cache;
use think\response\Json;

/**
 * 比对验证码
 *
 * @return  [type]  [return description]
 */
function check_code(?string $key = '', ?string $str = '')
{
    $code = Cache::get($key);
    if (!$code || $code != $str) return false;
    return true;
}
/**
 * 错误返回的信息,使用json
 *
 * @param   string  $msg   [$msg description]
 * @param   int     $code  [$code description]
 *
 * @return  Json           [return description]
 */
function e(?string $msg = '错误信息', ?int $code = 400): Json
{
    return json(['code' => $code, 'msg' => $msg]);
}
/**
 * 错误返回的信息
 *
 * @param   string  $msg   [$msg description]
 * @param   int     $code  [$code description]
 *
 * @return  array           [return description]
 */
function ea(?string $msg = '错误信息', ?int $code = 400): array
{
    return ['code' => $code, 'msg' => $msg];
}
/**
 * 正确的返回的信息,JSON
 *
 * @param   string  $msg    [$msg description]
 * @param   int     $code   [$code description]
 * @param   array   $datas  [$datas description]
 *
 * @return  Json            [return description]
 */
function s(?string $msg = '成功信息', ?int $code = 200, ?array $datas = []): Json
{
    $data['code'] = $code;
    $data['msg'] = $msg;
    $data['data'] = $datas;
    return json($data);
}
/**
 * 正确的返回的信息
 *
 * @param   string  $msg    [$msg description]
 * @param   int     $code   [$code description]
 * @param   array   $datas  [$datas description]
 *
 * @return  array            [return description]
 */
function sa(string $msg = '成功信息', int|array $code = 200, ?array $datas = []): array
{
    $data = [];
    if (is_array($code)) {
        $data['code'] = 200;
        $data['msg'] = $msg;
        $data['data'] = $code;
    } else {
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['data'] = $datas;
    }
    return $data;
}
/**
 * 根据操作系统换路径
 *
 * @param   string  $path  [$path description]
 *
 * @return  [type]         [return description]
 */
function get_path(string $path): string
{
    if (substr(PHP_OS, 0, 3) === 'WIN') {
        $path = str_replace('/', '\\', $path);
    }
    return $path;
}
/**
 * 获取linux下的路径
 *
 * @param   string  $path  [$path description]
 *
 * @return  string         [return description]
 */
function get_linux(string $path): string
{
    return str_replace('\\', '/', $path);
}
/**
 * 合并权限
 *
 * @param   array   $arr  权限数组
 *
 * @return  string        返加合并好的字符串
 */
function merge_auth(array $arr): string
{
    $str = '';
    if (count($arr) == 0) return '';
    $new_arr = [];
    array_walk($arr, function ($v) use (&$new_arr) {
        if ($v != '') {
            $auth_arr = explode(',', $v);
            $new_arr = array_merge($new_arr, $auth_arr);
        }
    });
    $new_arr = array_flip($new_arr);
    $new_arr = array_keys($new_arr);
    $str = implode(',', $new_arr);
    return $str;
}
/**
 * 无限级栏目构建
 *
 * @param   array  $data    数组数据
 * @param   [type] $model   模式
 * @param   array  $action  操作动作数据
 *
 * @return  array           [return description]
 */
function auto_category(array &$data, $model = 1, array $action = []): array
{
    //正常模式
    if (!function_exists('gettree')) {
        function gettree($array)
        {
            $refer = array();
            $tree = array();
            foreach ($array as $key => $val) {
                $id = $val['id'];
                $array[$key]['id'] = strval($id);
                $refer[$id] = &$array[$key];
            }
            foreach ($array as $k => $v) {
                $pid = $v['parent_id']; //获取当前分类的父级id
                if ($pid == 0) {
                    $tree[] = &$array[$k]; //顶级栏目
                } else {
                    if (isset($refer[$pid])) {
                        $refer[$pid]['children'][] = &$array[$k]; //如果存在父级栏目，则添加进父级栏目的子栏目数组中
                    }
                }
            }
            return $tree;
        }
    }
    if (!function_exists('getAction')) {
        function getAction($id, $action_id, $action)
        {
            $action_arr = explode(',', $action_id);
            $res_arr = [];
            array_walk($action_arr, function ($v) use (&$res_arr, &$action, $id) {
                $res_arr[] = ['id' => $id . '|' . $v, 'name' => $action[$v]['name']];
            });
            return $res_arr;
        }
    }
    //添加操作模式
    if (!function_exists('gettreeAction')) {
        function gettreeAction($array, $action)
        {
            $refer = array();
            $tree = array();
            foreach ($array as $key => $val) {
                if ($val['action_id'] != '') {
                    $array[$key]['children'] = getAction($val['id'], $val['action_id'], $action);
                }
                $refer[$val['id']] = &$array[$key];
            }
            foreach ($array as $k => &$v) {
                $pid = $v['parent_id']; //获取当前分类的父级id
                if ($pid == 0) {
                    $tree[] = &$array[$k]; //顶级栏目
                } else {
                    if (isset($refer[$pid])) {
                        $refer[$pid]['children'][] = &$array[$k]; //如果存在父级栏目，则添加进父级栏目的子栏目数组中
                    }
                }
            }
            return $tree;
        }
    }
    //无限级栏目---列表模式
    if ($model == 0) {
        if (!function_exists('create')) {
            function create($datas, $pid = 0, $level = 0)
            {
                $tmp = [];
                foreach ($datas as $v) {
                    if ($v['parent_id'] == $pid) {
                        $v['level'] = $level;
                        $tmp[] = $v;
                        $res = create($datas, $v['id'], $level + 1);
                        $tmp = array_merge($tmp, $res);
                    }
                }
                return $tmp;
            }
        }
        return create($data);
    } else if ($model == 1) {
        return gettree($data);
    } else if ($model == 2) {
        $new_arr = [];
        foreach ($data as $k => $v) {
            $new_arr[$k]['id'] = $v['id'];
            $new_arr[$k]['menuId'] = strval($v['id']);
            $new_arr[$k]['menuName'] = $v['name'];
            $new_arr[$k]['icon'] = $v['icon'];
            $new_arr[$k]['parent_id'] = $v['parent_id'];
            $new_arr[$k]['path'] = $v['index_url'];
            $new_arr[$k]['children'] = [];
        }
        return gettree($new_arr);
    } else if ($model == 3) {
        $new_action = [];
        array_walk($action, function ($v) use (&$new_action) {
            $new_action[$v['id']] = $v;
        });
        return gettreeAction($data, $new_action);
    }
    return [];
}
/**
 * 改变json文件状态
 *
 * @param   string   $json    json字符串数据
 * @param   string  $uuid    uuid
 * @param   int     $status  改状态
 *
 * @return  string            
 */
function middify_json_status(string $json, string $uuid, int $status): string
{
    $data = json_decode($json, true);
    $is_mid = true;
    array_walk($data, function (&$v) use ($uuid, $status, &$is_mid) {
        if ($uuid == $v['uuid']) {
            $is_mid = false;
            $v['status'] = $status;
        }
    });
    if ($is_mid) return '';
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}
/**
 * 文本文件转数组
 *
 * @param   string  $str  [$str description]
 *
 * @return  array         [return description]
 */
function txt_to_arr(string $str): array
{
    $arr = explode(PHP_EOL, $str);
    $new_arr = [];
    array_walk($arr, function ($v) use (&$new_arr) {
        if ($v != "") {
            array_push($new_arr, explode("\t", $v));
        }
    });
    unset($new_arr[0]);
    return $new_arr;
}
/**
 * 获取值
 *
 * @param   array             [ ]
 * @param   string  $data     [$data 传入的数据]
 * @param   array             [ ]
 * @param   string  $default  [$default 默认值]
 *
 * @return  array             [return description]
 */
function get_empty_val(string $data, string $default = ''): string
{
    return empty($data) ?  $default : $data;
}
