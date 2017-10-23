<?php
namespace Mobile\Model;
use Think\Model;
class WeixinshareModel extends Model
{
    const APPID = 'wxc3f45a0b83a4ad4a';
    const APPSECRET = 'e334964f6458b1f863e899a4b78368a9';

    //获取access_token
    public function accessToken()
    {
        $access_token = $this->redis->get("weixin_access_token");//存入redis，这里要结合自己的项目，对redis或者memcahe进行设置
        if(!$access_token){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::APPID."&secret=".self::APPSECRET;
            $data = json_decode($this->httpGet($url),true);
            if(isset($data['access_token']) && $data['access_token'] != ''){
                $access_token = $this->redis->set("weixin_access_token",$data['access_token'],7200);
            }else{
                return false;
            }
        }
        return $access_token;
    }

    //用第一步拿到的access_token 采用http GET方式请求获得jsapi_ticket
    public function jsapiTicket()
    {
        $jsapi_ticket = $this->redis->get("weixin_jsapi_ticket");
        if(!$jsapi_ticket){
            $access_token = $this->accessToken();
            if($access_token){
                $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
                $data = json_decode($this->httpGet($url),true);
                if(isset($data['errcode']) && $data['errcode']== 0){//请求成功
                    $jsapi_ticket = $this->redis->set("weixin_jsapi_ticket",$data['ticket'],7200);
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        return $jsapi_ticket;
    }


    //获取signature
    public function signature($nonceStr,$timestamp,$url)
    {
        $jsapi_ticket = $this->jsapiTicket();

        $signature = '';
        if($jsapi_ticket) {
            $string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature = sha1($string);//对string1进行sha1签名，得到signature
        }else{
            return false;
        }
        return $signature;
    }


    public function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    
    public function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

}