<?php

include COMMON_PATH.'Common/sendMessage.php';//发送短信
/**
 * @param $password  string 密码加密
 * @return string 返回加密后的密码
 * 采用crypt函数将用户密码与密钥串结合加密后，再进行md5加密。
 */
function password_md5($password)
{
    $password = md5(crypt($password, C("AUTH_CODE").$password));
    return $password;
}

/**
 * 
 * @param string $channel 频道名
 * @param int $type 1 为内容，2 为栏目
 * @return bool 有为真，无为假
 */
function getTable($channel = "", $type = 0)
{
    $info = M()->table("{$_SESSION["site_name"]}_system_channel_table_config")->field("id,channel,table_format,table_name")->where("channel='$channel' AND type=$type")->find();
    if ($info) {
        $info['channel_id'] = M()->table("{$_SESSION["site_name"]}_system_channel")->where("call_index='{$info['channel']}'")->getField("id");  //频道id
        return $info;
    } else {
        return false;
    }

    /**
     * 验证手机号是否正确
     * @author
     * @param number $mobile
     */
    function isMobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }
}
?>