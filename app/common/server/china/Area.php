<?php
/*
 * @Author: 程英明
 * @Date: 2023-07-26 15:07:44
 * @LastEditTime: 2023-07-26 15:20:26
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\server\china\Area.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\server\china;

use think\facade\Db;

class Area extends Base
{
    //省一级
    public function province()
    {
        $data = Db::name('province')->order('code ASE')->select()->toArray();
        return sa($data);
    }
    //市一级：city
    public function city()
    {
        $code = empty($this->req['provinceCode']) ? '' : $this->req['provinceCode'];
        if ($code) {
            $data = Db::name('city')->where('provinceCode', $code)->order('code ASE')->select()->toArray();
        } else {
            $data = Db::name('city')->where('provinceCode', '11')->order('code ASE')->select()->toArray();
        }
        return sa($data);
    }
    //区县一级：area
    public function area()
    {
        $code = empty($this->req['cityCode']) ? '' : $this->req['cityCode'];
        if ($code) {
            $data = Db::name('area')->where('cityCode', $code)->order('code ASE')->select()->toArray();
        } else {
            $data = Db::name('area')->where('cityCode', '1101')->order('code ASE')->select()->toArray();
        }
        return sa($data);
    }
    //街道：street
    public function street()
    {
        $code = empty($this->req['areaCode']) ? '' : $this->req['areaCode'];
        if ($code) {
            $data = Db::name('street')->where('areaCode', $code)->order('code ASE')->select()->toArray();
        } else {
            $data = Db::name('street')->where('areaCode', '110101')->order('code ASE')->select()->toArray();
        }
        return sa($data);
    }
    //居委会：village
    public function village()
    {
        $code = empty($this->req['streetCode']) ? '' : $this->req['streetCode'];
        if ($code) {
            $data = Db::name('village')->where('streetCode', $code)->order('code ASE')->select()->toArray();
        } else {
            $data = Db::name('village')->where('streetCode', '110101001')->order('code ASE')->select()->toArray();
        }
        return sa($data);
    }
}
