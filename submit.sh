#!/bin/bash
###
 # @Author: 程英明
 # @Date: 2022-03-04 14:26:50
 # @LastEditTime: 2022-03-08 10:14:07
 # @LastEditors: 程英明
 # @Description: 
 # @FilePath: \api\submit.sh
 # QQ:504875043@qq.com
### 
time=$(date "+%Y-%m-%d %H:%M:%S")
git add .
git commit -m "$*=>$time"
git push
