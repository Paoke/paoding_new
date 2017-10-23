<?php
/**
 * Image: Image.class.php
 * Date: 14-1-31
 * Time: 下午2:53
 */

namespace Common\Util;

/**
 * Class Image
 * @package Common\Util
 */
class Image
{
    public static function base64ToFile($basePic, $imgDiv='', $imgName=''){
        $flag = 'base64,';
        $index = strpos($basePic, $flag) + strlen($flag);
        $base64Img = substr($basePic, $index);

        //获取后缀名
        $flag = 'image/';
        $begin = strpos($basePic, $flag) + strlen($flag);
        $flag = ';';
        $end = strpos($basePic, $flag, $begin) - $begin;
        $suffix = substr($basePic, $begin, $end);

        //保存图片到本地
        if(!$imgDiv){
            $site = get_site_name();
            $imgDiv = UPLOAD_PATH . $site. '/image/' . date('Ymd', time()) . '/';
        }

        if(!$imgName){
            $imgName = time() . '.' . $suffix;
        }else{
            $imgName = $imgName . '_' .time() . '.' . $suffix;
        }

        if(!is_dir($imgDiv)){
            mkdir($imgDiv, 0777, true);
        }
        $imgPath = $imgDiv . $imgName;
        file_put_contents($imgPath, base64_decode($base64Img));

        return '/'.$imgPath;
    }


}