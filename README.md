<!--
 * @Author: 程英明
 * @Date: 2022-12-23 16:24:23
 * @LastEditTime: 2023-07-27 10:41:51
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_php6_server\README.md
 * QQ:504875043@qq.com
-->
基于thinkphp6.1开发
使用多应用模式
```sh
composer require topthink/think-multi-app
```
自己封装的库
```sh
composer require findnr/cym-aliyun
composer require findnr/cym-phptools
```
UUID库
```sh
composer require ramsey/uuid
```
图片验证码库
```sh
composer require gregwar/captcha
```
### 使用方法
- 使用的是thinkphp多应用模式所以要在app创建一个应用名称，配制好数据库
- 本系统现使用的sqlit作为测试数据，可使用thinkphp支持的其它数据（例如mysql,mariadb,pgsql等数据库）
##### 具体的步骤
- 1、创建一个应用（在app目录下）
- 2、在应用中创建一个配制文件（config）同时创建好数据库配制文件（database.php）
- 3、在应用创建一个控制器文件（controller）同时在创建一个安装文件（Install.php）
```php
class Install
{
    use \app\common\install\TaritInit;
}
```
- 4、前台就可请求接口进行安装了，好后就可以使用了
```sh
#安装后台的接口地址
http://域名/应用名称/install/admin
#创建模型的接口地址
http://域名/应用名称/install/createModel
```
