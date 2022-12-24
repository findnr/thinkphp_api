<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-24 17:34:23
 * @LastEditTime: 2022-12-24 21:00:02
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \web_php6_server\app\common\server\code\Create.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\server\code;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use think\facade\Cache;
use Ramsey\Uuid\Uuid;

class Create extends Base
{
    public function index()
    {
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
            'code_key' => $uuid,
            'img_base64' => $img_base64,
        ];
        return sa('验证码获取成功', $res_data);
    }
}
