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
i=0
info=()
for rsync in `cat ../apigiteeautouserinfo`
do
    info[i]=$rsync
    ((i++))
done
expect -c "
    spawn git push
    expect {
        \"Username\" { send \"${info[0]}\r\";}
    }
    expect {
        \"Password\" { send \"${info[1]}\r\";}
    }
expect eof"
