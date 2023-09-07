#!/bin/bash
###
 # @Author: 程英明
 # @Date: 2023-07-27 13:22:32
 # @LastEditTime: 2023-09-07 09:54:58
 # @LastEditors: 程英明
 # @Description: 
 # @FilePath: \thinkphp_api\install.sh
 # QQ:504875043@qq.com
### 
composer install
composer require topthink/think-multi-app
composer require topthink/think-filesystem
composer require findnr/cym-aliyun
composer require findnr/cym-phptools
composer require ramsey/uuid
composer require gregwar/captcha