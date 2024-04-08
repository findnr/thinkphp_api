<?php
/*
 * @Author: 程英明
 * @Date: 2023-07-26 15:11:55
 * @LastEditTime: 2024-04-08 14:47:25
 * @LastEditors: findnr
 * @Description: 
 * @FilePath: \thinkphp_api\app\test\config\database.php
 * QQ:504875043@qq.com
 */

return [
    // 默认使用的数据库连接配置
    'default'         => env('database.driver', 'mysql'),

    // 自定义时间查询规则
    'time_query_rule' => [],

    // 自动写入时间戳字段
    // true为自动识别类型 false关闭
    // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
    'auto_timestamp'  => true,

    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',

    // 时间字段配置 配置格式：create_time,update_time
    'datetime_field'  => '',

    // 数据库连接配置信息
    'connections'     => [
        'mysql' => [
            // 数据库类型
            'type'            => env('database.type', 'mysql'),
            // 服务器地址
            'hostname'        => env('database.hostname', '127.0.0.1'),
            // 数据库名
            'database'        => env('database.database', 'test'),
            // 用户名
            'username'        => env('database.username', 'test'),
            // 密码
            'password'        => env('database.password', 'test,1234'),
            // 端口
            'hostport'        => env('database.hostport', '3306'),
            // 数据库连接参数
            'params'          => [],
            // 数据库编码默认采用utf8
            'charset'         => env('database.charset', 'utf8'),
            // 数据库表前缀
            'prefix'          => env('database.prefix', ''),

        ],

        // 更多的数据库配置信息
    ],
];
