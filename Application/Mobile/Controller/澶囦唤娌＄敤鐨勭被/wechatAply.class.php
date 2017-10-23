<?php
/**
 *	微信公众平台PHP-SDK, 官方API部分
 *  @author  dodge <dodgepudding@gmail.com>
 *  @link https://github.com/dodgepudding/wechat-php-sdk
 *  @version 1.2
 *  @version l.sh 修改版
 *  usage:
 *   $options = array(
 *      'openid'=>'', //openid
 *      'appid'=>'wx91224c6dcc734791', //填写高级调用功能的app id       
 *      'key'=>'linsihuilinsihuilinsihuilinsihui', //商户支付api密钥 
 *      'mch_id'=>'1342226001', //商户号
 *      
 *      'body'=>'Ipad mini  16G  白色', //商品描述
 *      'total_fee'=>999, //订单总金额，单位为分
 *      'goods_tag'=>'', //
 *      'attach'=>'', //
 *      
 *		);
 */
namespace Mobile\Controller;
use Think\Controller;

header("Content-type: text/html; charset=utf-8");
class WechatAply
{
	
	private $appid; //公众账号ID:
  private $key; //api密钥:
  private $nonce_str;//随机字符串:
  private $mch_id; //商户号: 微信支付分配的商户号1342226001）
  private $device_info; //终端设备号(门店号或收银设备ID)，注意：PC网页或公众号内支付请传"WEB"
  private $sign;   //sign签名：440369F7BB32F6E0C767F8798DFC237432
  private $pay_sign;   //paySign签名：440369F7BB32F6E0C767F8798DFC237432
  private $body;   //商品描述: 商品或支付单简要描述 (Ipad mini  16G  白色)
  private $detail; //商品详情: (非必须)商品名称明细列表 (Ipad mini  16G  白色)
  private $attach; //附加数据: (非必须)附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据 深圳分店
  private $out_trade_no; //商户订单号: 商户系统内部的订单号,32个字符内
  private $fee_type; //货币类型： (非必须) 默认人民币：(CNY)
  private $total_fee;//总金额：订单总金额，单位为分
  private $spbill_create_ip; //终端IP: APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
  private $time_start;  //交易起始时间: (非必须)(20091225091010)
  private $time_expire; //交易结束时间: (非必须)(20091225091010)
  private $goods_tag;   //商品标记:   (非必须)商品标记，代金券或立减优惠功能的参数
  private $notify_url;  //通知地址: 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。(WXG)
  private $trade_type;  //交易类型:  取值如下：JSAPI，NATIVE，APP ,JSAPI--公众号支付、NATIVE--原生扫码支付、APP--app支付
  private $product_id;  //商品ID:   (非必须)trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义
  private $limit_pay;   //指定支付方式:   (非必须)取值no_credit--指定不能使用信用卡支付
  private $openid;      //用户标识:   (非必须)

	public function __construct($options)
	{
    
    $this->nonce_str = $this->getNonceStr(30);
    $this->appid = isset($options['appid'])?$options['appid']:'';
    $this->mch_id = isset($options['mch_id'])?$options['mch_id']:'';          
    $this->device_info = isset($options['device_info'])?$options['device_info']:'WEB';  
    $this->key = isset($options['key'])?$options['key']:'BD4144296C11049FEF13B3459C0AADBB';   

    $this->body = isset($options['body'])?$options['body']:'test';
    $this->out_trade_no = isset($options['out_trade_no'])?$options['out_trade_no']:time().rand(1000,9999);
    $this->total_fee = isset($options['total_fee'])?$options['total_fee']:1;
    $this->spbill_create_ip = isset($options['spbill_create_ip'])?$options['spbill_create_ip']:$_SERVER['REMOTE_ADDR'];
    $this->notify_url = isset($options['notify_url'])?$options['notify_url']:'http://paysdk.weixin.qq.com/example/notify.php';
    $this->trade_type = isset($options['trade_type'])?$options['trade_type']:'JSAPI';
    $this->openid = isset($options['openid'])?$options['openid']:'oCg84w_SYl3oY3780baeqN1dbiYo';
    $this->goods_tag = isset($options['goods_tag'])?$options['goods_tag']:'';
    $this->attach = isset($options['attach'])?$options['attach']:'';

    // $this->sign = $this->makeSign();
    // $this->pay_sign = $this->makeSign();
	}

  /**
   *
   * 
   * 统一下单
   * appid、mchid、spbill_create_ip、nonce_str out_trade_no、body、total_fee、trade_type填入
   * @param WxPayUnifiedOrder $inputObj
   * @param int $timeOut
   * @throws WxPayException
   * @return 成功时返回，其他抛异常
   */
    public function unifiedOrder(){
      // $url = "https://api.mch.weixin.qq.com/pay/unifiedorder?appid=$this->appid&body=$this->body&mch_id=$this->mch_id&nonce_str=$this->nonce_str&notify_url=$this->notify_url&out_trade_no=$this->out_trade_no&spbill_create_ip=$this->spbill_create_ip&total_fee=$this->total_fee&trade_type=$this->trade_type&sign=$this->sign&openid=$this->openid";
      $values = array( 
                    'body'=>$this->body,      
                    'notify_url'=>'http://www.rdmsys.cn',
                    'out_trade_no'=>$this->out_trade_no,                    
                    'total_fee'=>$this->total_fee,
                    'trade_type'=>$this->trade_type,                    
                    'openid'=>$this->openid,
                     "goods_tag"=>$this->goods_tag ,
                     "attach"=> $this->attach ,

                     'nonce_str'=>$this->nonce_str,
                     'appid'=>$this->appid,
                     'mch_id'=>$this->mch_id,
                     'spbill_create_ip'=>$this->spbill_create_ip,
                    );
      $values['sign'] = $this->makeSign($values);

      $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";    
      ksort($values);
      $xml = $this->toXml($values);
      $timeOut = 6;
      $response = $this->postXmlCurl($xml, $url, false, $timeOut);
      // return $arr;  
      $result = $this->fromXml($response);
      return $result;
      
    }
  /**
   * 
   * 获取jsapi支付的参数
   * @param array $UnifiedOrderResult 统一支付接口返回的数据
   * @throws WxPayException
   * 
   * @return json数据，可直接填入js函数作为参数
   */
  public function GetJsApiParameters($UnifiedOrderResult)
  {
    if(!array_key_exists("appid", $UnifiedOrderResult)
    || !array_key_exists("prepay_id", $UnifiedOrderResult)
    || $UnifiedOrderResult['prepay_id'] == "")
    {
      throw new WxPayException("参数错误");
    }
    $jsapi["appId"] = $UnifiedOrderResult["appid"];
    $timeStamp = time();
    $jsapi["timeStamp"] = "$timeStamp";
    $jsapi["nonceStr"] = $this->getNonceStr(30);
    $jsapi["package"] = "prepay_id=" . $UnifiedOrderResult['prepay_id'];
    $jsapi["signType"] = "MD5";
    $jsapi["paySign"] = $this->makeSign($jsapi);
    $parameters = json_encode($jsapi,JSON_UNESCAPED_UNICODE);
    return $parameters;
  }

  /**
   * 生成签名
   * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
   */
    public function makeSign($values){
      //签名步骤一：按字典序排序参数
      ksort($values);
      $string = $this->ToUrlParams($values);
      //签名步骤二：在string后加入KEY
      $string = $string . "&key=".$this->key;
      //签名步骤三：MD5加密
      $string = md5($string);
      //签名步骤四：所有字符转为大写
      $result = strtoupper($string);
      return $result;
    }
  /**
   * 随机生成字符串
   * @return 字符串
   */
    public function getNonceStr($n){
      //随机生成字符串
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $str = "";
      for($i = 0; $i < $n; $i++)
      {
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
      }
      return $str;
    }
  /**
   * 格式化参数格式化成url参数
   */
  public function ToUrlParams($values)
  {
    $buff = "";
    foreach ($values as $k => $v)
    {
      if($k != "sign" && $v != "" && !is_array($v)){
        $buff .= $k . "=" . $v . "&";
      }
    }
    
    $buff = trim($buff, "&");
    return $buff;
  }
  /**
   * 输出xml字符
   * @throws WxPayException
  **/
  public function toXml($values)
  {
    if(!is_array($values) 
      || count($values) <= 0)
    {
        echo "数组数据异常！";
      }
      
      $xml = "<xml>";
      foreach ($values as $key=>$val)
      {
        // if (is_numeric($val)){
          $xml.="
          <".$key.">".$val."</".$key.">";
        // }else{
        //   $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        // }
        }
        $xml.="
        </xml>";
        return $xml; 
  }
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
  public function fromXml($xml)
  { 
    if(!$xml){
      return "xml数据异常！";
    }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);    
    return $values;
  }


  /**
   * 以post方式提交xml到对应的接口url
   * 
   * @param string $xml  需要post的xml数据
   * @param string $url  url
   * @param bool $useCert 是否需要证书，默认不需要
   * @param int $second   url执行超时时间，默认30s
   * @throws WxPayException
   */
  public function postXmlCurl($xml, $url, $useCert = false, $second = 30)
  {   
    $ch = curl_init();
    //设置超时
    curl_setopt($ch, CURLOPT_TIMEOUT, $second);     
    
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);//关闭访问https时本地的ssl证书校验
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
    //设置header
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  
    if($useCert == true){
      //设置证书
      //使用证书：cert 与 key 分别属于两个.pem文件
      curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
      curl_setopt($ch,CURLOPT_SSLCERT,'apiclient_cert.pem' );
      curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
      curl_setopt($ch,CURLOPT_SSLKEY, 'apiclient_key.pem');
    }
    //post提交方式
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    //运行curl
    $data = curl_exec($ch);
    //返回结果
    if($data){
      curl_close($ch);
      return $data;
    } else { 
      $error = curl_errno($ch);
      curl_close($ch);
      echo("curl出错，错误码:$error");

    }
  }
  /**
   * GET 请求
   * @param string $url
   */
  private function http_get($url){
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
      curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
      return $sContent;
    }else{
      return false;
    }
  }

	
}

