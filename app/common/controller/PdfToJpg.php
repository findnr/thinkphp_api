<?php
/*
 * @Author: 程英明
 * @Date: 2022-12-29 10:27:01
 * @LastEditTime: 2022-12-29 10:30:24
 * @LastEditors: 程英明
 * @Description: 
 * @FilePath: \api\app\common\controller\PdfToJpe.php
 * QQ:504875043@qq.com
 */

declare(strict_types=1);

namespace app\common\controller;

use Intervention\Image\ImageManagerStatic as Image;
use Imagick;
use think\facade\Request;

class PdfToJpg
{
    public function pdf()
    {
        $image = new Imagick();
        $image->setOption('density', '96x96');
        $image->readImage($_FILES['file']['tmp_name']);
        $image->setImageFormat('jpeg');
        $img = Image::make($image->getImageBlob());
        $base64  = (string) $img->encode('data-url');
        return s('获取成功', 200, ['base64' => $base64]);
    }
}
