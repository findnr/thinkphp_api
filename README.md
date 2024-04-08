<!--
 * @Author: 程英明
 * @Date: 2022-12-23 16:24:23
 * @LastEditTime: 2023-09-11 11:14:59
 * @LastEditors: 程英明
 * @Description: git remote set-url origin https://<你的令牌>@github.com/<你的git用户名>/<要修改的仓库名>.git
 * @FilePath: \thinkphp_api\README.md
 * QQ:504875043@qq.com
-->
### 测试地址
请大家不要更改管理员帐号和密码：帐号：admin 密码：123456
- 后台测试：https://demo.findbox.icu/#/auth/admin (github地址：https://github.com/findnr/vue-element-plus-temp)
- 前台测试：正在开中！！！
##### 具体操作
基于thinkphp6.1开发
```sh
#安装框架所须要的东西
composer install
#使用多应用模式和文件操作
composer require topthink/think-multi-app
composer require topthink/think-filesystem
#自己封装的库
composer require findnr/cym-aliyun
composer require findnr/cym-phptools
#UUID库
composer require ramsey/uuid
#图片验证码库
composer require gregwar/captcha
```
### 使用方法
- 第一步：git clone https://github.com/findnr/thinkphp_api.git
- 第二步：如果是linux 执行：sh install.sh ,如果是win就要复制上边的安装代码进行安装（composer install 和其它）
- 第三步：配制好数据库和多应用
##### 具体的步骤
1、创建一个应用（在app目录下）
2、在应用中创建一个配制文件（config）同时创建好数据库配制文件（database.php）
3、在应用创建一个控制器文件（controller）同时在创建一个安装文件（Install.php）
4、使用的是thinkphp多应用模式所以要在app创建一个应用名称，配制好数据库
5、本系统现暂支持mysql
- 第四步：在应用中控制器建一个安装类
##### 具体操作
```php
class Install
{
    use \app\common\install\TaritInit;
}
```
- 第五步：前台就可请求接口进行安装了，好后就可以使用了
```sh
#安装后台的接口地址
http://域名/应用名称/install/admin
#创建模型的接口地址
http://域名/应用名称/install/createModel
```
