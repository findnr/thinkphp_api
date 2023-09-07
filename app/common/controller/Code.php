<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-24 17:30:55
 * @LastEditTime: 2023-04-12 16:05:18
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\controller\Code.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\controller;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use think\facade\Cache;
use Ramsey\Uuid\Uuid;

class Code extends Base
{
    use \app\common\base\TraitController;
    private $req;
    public function code()
    {
        $this->req = request()->param();
        $captcha = new CaptchaBuilder(null, new PhraseBuilder(4, '23456789abcdefghijkmnpqrstuvwxyz'));
        $captcha->build();
        if (empty($this->req['code_key']) || !Cache::get((string) $this->req['code_key'])) {
            $uuid_obj = Uuid::uuid4();
            $uuid = $uuid_obj->toString();
        } else {
            $uuid = (string) $this->req['code_key'];
        }
        $check_code = $captcha->getPhrase();
        Cache::set($uuid, $check_code, 300);
        $img_base64 = $captcha->inline();
        $res_data = [
            'code' => 200,
            'code_key' => $uuid,
            'img_base64' => $img_base64,
            'msg' => '验证码获取成功',
        ];
        return json($res_data);
    }
}
