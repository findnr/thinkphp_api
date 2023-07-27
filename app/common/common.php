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
function jwt_en(?array $data, ?string $mode = ''): string
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
function jwt_de(?string $token, ?string $mode = ''): array
{
    $config['key'] = get_key($mode);
    $config['token'] = $token;
    $data = CymJwt::token_decode($config);
    return $data;
}
function get_key(?string $mode = ''): string
{
    $key = '';
    switch ($mode) {
        case 'admin':
            $key = Config::get('key.admin_token_key');
            break;
        case 'user':
            $key = Config::get('key.user_token_key');
            break;
        case 'unit':
            $key = Config::get('key.unit_token_key');
            break;
        case 'person':
            $key = Config::get('key.person_token_key');
            break;
        case 'man':
            $key = Config::get('key.man_token_key');
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
function e(?string $msg = '成功信息', ?int $code = 400, ?array $datas = []): Json
{
    $data['code'] = $code;
    $data['msg'] = $msg;
    $data['data'] = $datas;
    return json($data);
}

/**
 * 错误返回的信息
 *
 * @param   string  $msg   [$msg description]
 * @param   int     $code  [$code description]
 *
 * @return  array           [return description]
 */
define('EA_DE_ARR', [11 => '获取失败', 21 => '添加失败', 31 => '修改失败', 41 => '删除失败']);
function ea($msg = '错误信息', $code = 400, $datas = []): array
{
    if (is_array($msg)) {
        return ['msg' => '错误', 'code' => 400, 'data' => $msg];
    }
    $data = ['msg' => $msg, 'code' => $code, 'data' => $datas];
    if (is_int($msg) && isset(EA_DE_ARR[$msg])) {
        $data['msg'] = EA_DE_ARR[$msg];
    }
    if (is_array($code)) {
        $data['data'] = $code;
        $data['code'] = 400;
    }
    return $data;
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
function s(?string $msg = '成功信息', ?int $code = 200, $datas = ''): Json
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
define('SA_DE_ARR', [11 => '获取成功', 21 => '添加成功', 31 => '修改成功', 41 => '删除成功']);
function sa($msg = '成功信息', $code = 200, $datas = ''): array
{
    if (is_array($msg)) {
        return ['msg' => '成功', 'code' => 200, 'data' => $msg];
    }
    $data = ['msg' => $msg, 'code' => $code, 'data' => $datas];
    if (is_int($msg) && isset(SA_DE_ARR[$msg])) {
        $data['msg'] = SA_DE_ARR[$msg];
    }
    if (is_array($code)) {
        $data['data'] = $code;
        $data['code'] = 200;
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
            $action_arr = $action_arr[0] == 0 ? [] : $action_arr;
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
                if (isset($val['action_id']) && $val['action_id'] != '') {
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
/**
 * 检验身份证号的合性，使用身份号国家标准算法
 *
 * @param   string  $id_car  [$id_car description]
 *
 * @return  [type]           [return description]
 */
function person_id_car_validate(string $id_car)
{
    // 校验身份证长度和格式
    if (!preg_match('/^\d{17}[\dX]$/', $id_car)) {
        return false;
    }
    // 校验身份证最后一位校验码
    $idCardWi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
    $idCardCheckDigit = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
    $sigma = 0;
    for ($i = 0; $i < 17; $i++) {
        $sigma += intval($id_car[$i]) * $idCardWi[$i];
    }
    $mod = $sigma % 11;
    $checkDigit = $idCardCheckDigit[$mod];
    if ($checkDigit != $id_car[17]) {
        return false;
    }
    return true;
}
/**
 * 检验统一信用代码的合性，使用身份号国家标准算法
 *
 * @return  [type]  [return description]
 */
function unit_id_car_validate($id_car)
{
    // 校验统一信用代码长度和格式
    if (!preg_match('/^[0-9A-Z]{18}$/', $id_car)) {
        return false;
    }
    // 校验统一信用代码校验位
    $creditCodeWi = [1, 3, 9, 27, 19, 26, 16, 17, 20, 29, 25, 13, 8, 24, 10, 30, 28];
    $creditCodeCheckDigit = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'W', 'X', 'Y'];
    $sigma = 0;
    for ($i = 0; $i < 17; $i++) {
        $codeChar = $id_car[$i];
        $codeValue = array_search($codeChar, $creditCodeCheckDigit);
        $sigma += $codeValue * $creditCodeWi[$i];
    }
    $mod = $sigma % 31;
    $checkDigit = $creditCodeCheckDigit[$mod];
    if ($checkDigit != $id_car[17]) {
        return false;
    }
    return true;
}
