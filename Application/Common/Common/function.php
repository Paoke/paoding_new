<?php

/**
 * @param $arr
 * @param $key_name
 * @return array
 * 将数据库中查出的列表以指定的 id 作为数组的键名
 */
function convert_arr_key($arr, $key_name)
{
    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$val[$key_name]] = $val;
    }
    return $arr2;
}

/**
 * @param $password  string 密码加密
 * @return string 返回加密后的密码
 * 采用crypt函数将用户密码与密钥串结合加密后，再进行md5加密。
 */
function encrypt($password)
{
    $password = md5(crypt($password, C("AUTH_CODE") . $password));
    return $password;
}

/**
 * 获取数组中的某一列
 * @param type $arr 数组
 * @param type $key_name 列名
 * @return type  返回那一列的数组
 */
function get_arr_column($arr, $key_name)
{
    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[] = $val[$key_name];
    }
    return $arr2;
}


/**
 * 获取url 中的各个参数  类似于 pay_code=alipay&bank_code=ICBC-DEBIT
 * @param type $str
 * @return type
 */
function parse_url_param($str)
{
    $data = array();
    $parameter = explode('&', end(explode('?', $str)));
    foreach ($parameter as $val) {
        $tmp = explode('=', $val);
        $data[$tmp[0]] = $tmp[1];
    }
    return $data;
}

/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param string $type
 * @return array
 */
function array_sort($arr, $keys, $type = 'desc')
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($key_value);
    } else {
        arsort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}


/**
 * 多维数组转化为一维数组
 * @param 多维数组
 * @return array 一维数组
 */
function array_multi2single($array)
{
    static $result_array = array();
    foreach ($array as $value) {
        if (is_array($value)) {
            array_multi2single($value);
        } else
            $result_array [] = $value;
    }
    return $result_array;
}

/**
 * 友好时间显示
 * @param $time
 * @return bool|string
 */
function friend_date($time)
{
    if (!$time)
        return false;
    $fdate = '';
    $d = time() - intval($time);
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
    if ($d == 0) {
        $fdate = '刚刚';
    } else {
        switch ($d) {
            case $d < $atd:
                $fdate = date('Y年m月d日', $time);
                break;
            case $d < $td:
                $fdate = '后天' . date('H:i', $time);
                break;
            case $d < 0:
                $fdate = '明天' . date('H:i', $time);
                break;
            case $d < 60:
                $fdate = $d . '秒前';
                break;
            case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
                break;
            case $d < $dd:
                $fdate = floor($d / 3600) . '小时前';
                break;
            case $d < $yd:
                $fdate = '昨天' . date('H:i', $time);
                break;
            case $d < $byd:
                $fdate = '前天' . date('H:i', $time);
                break;
            case $d < $md:
                $fdate = date('m月d日 H:i', $time);
                break;
            case $d < $ld:
                $fdate = date('m月d日', $time);
                break;
            default:
                $fdate = date('Y年m月d日', $time);
                break;
        }
    }
    return $fdate;
}


/**
 * 返回状态和信息
 * @param $status
 * @param $info
 * @return array
 */
function arrayRes($status, $info, $url = "")
{
    return array("status" => $status, "info" => $info, "url" => $url);
}

/**
 * @param $arr
 * @param $key_name
 * @param $key_name2
 * @return array
 * 将数据库中查出的列表以指定的 id 作为数组的键名 数组指定列为元素 的一个数组
 */
function get_id_val($arr, $key_name, $key_name2)
{
    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$val[$key_name]] = $val[$key_name2];
    }
    return $arr2;
}

/**
 *  自定义函数 判断 用户选择 从下面的列表中选择 可选值列表：不能为空
 * @param type $attr_values
 * @return boolean
 */
function checkAttrValues($attr_values)
{
    if ((trim($attr_values) == '') && ($_POST['attr_input_type'] == '1'))
        return false;
    else
        return true;
}

// 定义一个函数getIP() 客户端IP，
function getIP()
{
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}

// 服务器端IP
function serverIP()
{
    return gethostbyname($_SERVER["SERVER_NAME"]);
}


/**
 * 自定义函数递归的复制带有多级子目录的目录
 * 递归复制文件夹
 * @param type $src 原目录
 * @param type $dst 复制到的目录
 */
//参数说明：            
//自定义函数递归的复制带有多级子目录的目录
function recurse_copy($src, $dst)
{
    $now = time();
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== $file = readdir($dir)) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                if (file_exists($dst . DIRECTORY_SEPARATOR . $file)) {
                    if (!is_writeable($dst . DIRECTORY_SEPARATOR . $file)) {
                        exit($dst . DIRECTORY_SEPARATOR . $file . '不可写');
                    }
                    @unlink($dst . DIRECTORY_SEPARATOR . $file);
                }
                if (file_exists($dst . DIRECTORY_SEPARATOR . $file)) {
                    @unlink($dst . DIRECTORY_SEPARATOR . $file);
                }
                $copyrt = copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                if (!$copyrt) {
                    echo 'copy ' . $dst . DIRECTORY_SEPARATOR . $file . ' failed<br>';
                }
            }
        }
    }
    closedir($dir);
}

/**
 * 自定义函数递归的复制带有多级子目录的目录
 * 递归复制文件夹
 * @param type $src 原目录
 * @param type $dst 复制到的目录
 * @param $renamePrefix 更改名称的前缀(改名规则: 前缀+原文件名)
 */
//参数说明：
//自定义函数递归的复制带有多级子目录的目录
function copy_and_rename($src, $dst, $renamePrefix)
{
    $now = time();
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== $file = readdir($dir)) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                if (file_exists($dst . DIRECTORY_SEPARATOR . $file)) {
                    if (!is_writeable($dst . DIRECTORY_SEPARATOR . $file)) {
                        exit($dst . DIRECTORY_SEPARATOR . $file . '不可写');
                    }
                    @unlink($dst . DIRECTORY_SEPARATOR . $file);
                }
                if (file_exists($dst . DIRECTORY_SEPARATOR . $file)) {
                    @unlink($dst . DIRECTORY_SEPARATOR . $file);
                }
                $copyrt = copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                if (!$copyrt) {
                    echo 'copy ' . $dst . DIRECTORY_SEPARATOR . $file . ' failed<br>';
                } else {
                    if (file_exists($dst . DIRECTORY_SEPARATOR . $renamePrefix . $file)) {
                        if (!is_writeable($dst . DIRECTORY_SEPARATOR . $renamePrefix . $file)) {
                            exit($dst . DIRECTORY_SEPARATOR . $renamePrefix . $file . '不可写');
                        }
                        @unlink($dst . DIRECTORY_SEPARATOR . $renamePrefix . $file);
                    }
                    if (file_exists($dst . DIRECTORY_SEPARATOR . $renamePrefix . $file)) {
                        @unlink($dst . DIRECTORY_SEPARATOR . $renamePrefix . $file);
                    }

                    rename($dst . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $renamePrefix . $file);
                }
            }
        }
    }
    closedir($dir);
}

// 递归删除文件夹
function delFile($dir, $file_type = '')
{
    if (is_dir($dir)) {
        $files = scandir($dir);
        //打开目录 //列出目录中的所有文件并去掉 . 和 ..
        foreach ($files as $filename) {
            if ($filename != '.' && $filename != '..') {
                if (!is_dir($dir . '/' . $filename)) {
                    if (empty($file_type)) {
                        unlink($dir . '/' . $filename);
                    } else {
                        if (is_array($file_type)) {
                            //正则匹配指定文件
                            if (preg_match($file_type[0], $filename)) {
                                unlink($dir . '/' . $filename);
                            }
                        } else {
                            //指定包含某些字符串的文件
                            if (false != stristr($filename, $file_type)) {
                                unlink($dir . '/' . $filename);
                            }
                        }
                    }
                } else {
                    delFile($dir . '/' . $filename);
                    rmdir($dir . '/' . $filename);
                }
            }
        }
    } else {
        if (file_exists($dir)) unlink($dir);
    }
}


/**
 * 多个数组的笛卡尔积
 *
 * @param unknown_type $data
 */
function combineDika()
{
    $data = func_get_args();
    $data = current($data);
    $cnt = count($data);
    $result = array();
    $arr1 = array_shift($data);
    foreach ($arr1 as $key => $item) {
        $result[] = array($item);
    }

    foreach ($data as $key => $item) {
        $result = combineArray($result, $item);
    }
    return $result;
}


/**
 * 两个数组的笛卡尔积
 * @param unknown_type $arr1
 * @param unknown_type $arr2
 */
function combineArray($arr1, $arr2)
{
    $result = array();
    foreach ($arr1 as $item1) {
        foreach ($arr2 as $item2) {
            $temp = $item1;
            $temp[] = $item2;
            $result[] = $temp;
        }
    }
    return $result;
}

/**
 * 将二维数组以元素的某个值作为键 并归类数组
 * array( array('name'=>'aa','type'=>'pay'), array('name'=>'cc','type'=>'pay') )
 * array('pay'=>array( array('name'=>'aa','type'=>'pay') , array('name'=>'cc','type'=>'pay') ))
 * @param $arr 数组
 * @param $key 分组值的key
 * @return array
 */
function group_same_key($arr, $key)
{
    $new_arr = array();
    foreach ($arr as $k => $v) {
        $new_arr[$v[$key]][] = $v;
    }
    return $new_arr;
}

/**
 * 获取随机字符串
 * @param int $randLength 长度
 * @param int $addtime 是否加入当前时间戳
 * @param int $includenumber 是否包含数字
 * @return string
 */
function get_rand_str($randLength = 6, $addtime = 1, $includenumber = 0)
{
    if ($includenumber) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    } else {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
    }
    $len = strlen($chars);
    $randStr = '';
    for ($i = 0; $i < $randLength; $i++) {
        $randStr .= $chars[rand(0, $len - 1)];
    }
    $tokenvalue = $randStr;
    if ($addtime) {
        $tokenvalue = $randStr . time();
    }
    return $tokenvalue;
}

/**
 * CURL请求
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug 调试开启 默认false
 * @return mixed
 */
function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false)
{
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i', $url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if ($ssl) {
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
    //return array($http_code, $response,$requestinfo);
}

/**
 * 过滤数组元素前后空格 (支持多维数组)
 * @param $array 要过滤的数组
 * @return array|string
 */
function trim_array_element($array)
{
    if (!is_array($array))
        return trim($array);
    return array_map('trim_array_element', $array);
}

/**
 * 检查手机号码格式
 * @param $mobile 手机号码
 */
function check_mobile($mobile)
{
    if (preg_match('/1[34578]\d{9}$/', $mobile))
        return true;
    return false;
}

/**
 * 检查邮箱地址格式
 * @param $email 邮箱地址
 */
function check_email($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;
    return false;
}


/**
 *   实现中文字串截取无乱码的方法
 */
function getSubstr($string, $start, $length)
{
    if (mb_strlen($string, 'utf-8') > $length) {
        $str = mb_substr($string, $start, $length, 'utf-8');
        return $str . '...';
    } else {
        return $string;
    }
}


/**
 * 判断当前访问的用户是  PC端  还是 手机端  返回true 为手机端  false 为PC 端
 * @return boolean
 */
/**
 * 　　* 是否移动端访问访问
 * 　　*
 * 　　* @return bool
 * 　　*/
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;

    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            return true;
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

//php获取中文字符拼音首字母
function getFirstCharter($str)
{
    if (empty($str)) {
        return '';
    }
    $fchar = ord($str{0});
    if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
    $s1 = iconv('UTF-8', 'gb2312', $str);
    $s2 = iconv('gb2312', 'UTF-8', $s1);
    $s = $s2 == $str ? $s1 : $str;
    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if ($asc >= -20319 && $asc <= -20284) return 'A';
    if ($asc >= -20283 && $asc <= -19776) return 'B';
    if ($asc >= -19775 && $asc <= -19219) return 'C';
    if ($asc >= -19218 && $asc <= -18711) return 'D';
    if ($asc >= -18710 && $asc <= -18527) return 'E';
    if ($asc >= -18526 && $asc <= -18240) return 'F';
    if ($asc >= -18239 && $asc <= -17923) return 'G';
    if ($asc >= -17922 && $asc <= -17418) return 'H';
    if ($asc >= -17417 && $asc <= -16475) return 'J';
    if ($asc >= -16474 && $asc <= -16213) return 'K';
    if ($asc >= -16212 && $asc <= -15641) return 'L';
    if ($asc >= -15640 && $asc <= -15166) return 'M';
    if ($asc >= -15165 && $asc <= -14923) return 'N';
    if ($asc >= -14922 && $asc <= -14915) return 'O';
    if ($asc >= -14914 && $asc <= -14631) return 'P';
    if ($asc >= -14630 && $asc <= -14150) return 'Q';
    if ($asc >= -14149 && $asc <= -14091) return 'R';
    if ($asc >= -14090 && $asc <= -13319) return 'S';
    if ($asc >= -13318 && $asc <= -12839) return 'T';
    if ($asc >= -12838 && $asc <= -12557) return 'W';
    if ($asc >= -12556 && $asc <= -11848) return 'X';
    if ($asc >= -11847 && $asc <= -11056) return 'Y';
    if ($asc >= -11055 && $asc <= -10247) return 'Z';
    return null;
}


/**
 * *************  验证码调用区块 start ***********
 * User: 吴邦
 * Date: 2016/8/04
 * Time: 13:27
 */

/**
 * 复写 发送短信 原系统短信验证在common.php中
 * @param $mobile  手机号码
 * @param $code    验证码
 * @return bool    短信发送成功返回true失败返回false
 */
function sms_send($mobile, $code)
{
    //获取短信配置
    $config = M('config');
    $data = array();

    $data['sms_appkey'] = $config->where('name="sms_appkey"')->getField('value');
    $data['sms_secretKey'] = $config->where('name="sms_secretKey"')->getField('value');
    $data['sms_product'] = $config->where('name="sms_product"')->getField('value');
    $data['sms_templateCode'] = $config->where('name="sms_templateCode"')->getField('value');
    $data['sms_sign'] = $config->where('name="sms_sign"')->getField('value');
    //时区设置：亚洲/上海 （使用户发送短信时不会出现时差）
    date_default_timezone_set('Asia/Shanghai');
    //调用阿里大于API接口
    vendor('Alidayu.top.TopClient');
    vendor('Alidayu.top.ResultSet');
    vendor('Alidayu.top.RequestCheckUtil');
    vendor('Alidayu.top.TopLogger');
    vendor('Alidayu.top.request.AlibabaAliqinFcSmsNumSendRequest');

    $c = new \TopClient;
    //短信内容：公司名/名牌名/产品名
    $product = $data['sms_product'];
    //引入短信 appkey 值
    $c->appkey = $data['sms_appkey'];
    //引入短信 secretkey 值
    $c->secretKey = $data['sms_secretKey'];
    //这个是用户名记录那个用户操作
    $req = new \AlibabaAliqinFcSmsNumSendRequest;
    //代理人编号 可选
    $req->setExtend("123456");
    //短信类型，此处默认，不用修改
    $req->setSmsType("normal");
    //短信签名 必须
    $req->setSmsFreeSignName($data['sms_sign']);
    //短信模板 必须
    $req->setSmsParam("{\"code\":\"$code\",\"product\":\"$product\"}");
    //短信接收号码 支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，
    $req->setRecNum("$mobile");
    //短信模板ID，传入的模板必须是在阿里大鱼“管理中心-短信模板管理”中的可用模板。
    $req->setSmsTemplateCode($data['sms_templateCode']); // templateCode
    //发送短信
    $resp = $c->execute($req);
    //短信发送成功返回True，失败返回false
    if ($resp) {
        // 从数据库中查询是否有验证码
        $data = M('ManageSmsLog')->where("code = '$code'")->find();
        // 没有就插入验证码,供验证用
        empty($data) && M('ManageSmsLog')->add(array('mobile' => $mobile, 'code' => $code, 'add_time' => time(), 'session_id' => SESSION_ID));
        return true;
    } else {
        return false;
    }
}

/**
 * 制作手机验证码
 * @param $length 设置验证码位数
 * @return string 返回验证码
 */
function get_mobile_code($length)
{
    return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

/**
 * 将用户发送短信的日志记录
 * @param string $mobile 手机号码
 * @param string $code 验证码
 * @param int $add_time 添加时间
 * @param string $desc 用处
 * @return array 返回记录信息
 */
function save_sms_log($mobile, $code, $add_time,$desc='')
{
    $manageSmsLog = M('ManageSmsLog');

    $data = array('mobile' => $mobile, 'code' => $code, 'add_time' => $add_time,"is_active"=>1,"desc"=>$desc);
    $res = $manageSmsLog->add($data);
    if ($res) {
        return array('result' => '1', 'msg' => '录入成功');
    } else {
        return array('result' => '2', 'msg' => '录入失败');
    }
}

/**
 * 检查验证码
 * @param $mobile 手机号码
 * @param $code 验证码
 */
function check_mobile_code($mobile, $code)
{
    $manageSmsLog = M('ManageSmsLog');
    $sms_mobile = $manageSmsLog->where('mobile="' . $mobile . '"')->order('id desc')->find();
    if ($sms_mobile==null||$sms_mobile['code'] != $code) {
        $data = array('result' => 2, 'msg' => '验证码错误', "code" => 402, "data" => null);
        return $data;
    }
    $count=$manageSmsLog->where("add_time>=CURRENT_TIMESTAMP - INTERVAL 5 MINUTE AND is_active=1 AND mobile='".$mobile."'")->count();
    if($count<1){
        $data=array("result"=>3,"msg"=>"验证码失效，请重新发送","code"=>402,"data"=>null);
        return $data;
    }
    $data = array('result' => 1, 'msg' => '验证码有效', "code" => 200, "data" => null);
    return $data;
}


// *************  验证码调用区块 end ***********

/**
 * 根据域名获取站点名
 * **/
function get_site_name()
{
    $site_domain = I('server.HTTP_HOST'); //域名
    if (strpos($site_domain, ':')) {
        $len = strpos($site_domain, ':');
        $site_domain = substr($site_domain, 0, $len);

    }

    $Model = D('Admin/Site');
    $sql = "SELECT site_name FROM global_site WHERE default_domain='" . $site_domain . "' OR specified_domain='" . $site_domain . "'";
    $data = $Model->query($sql);
    if (count($data) == 0) {
        return C('DEFAULT_SITE_NAME');
    } else {
        return $data[0]['site_name'];
    }

}

/**
 * 配置站点模板
 * @param $site_name 站点名称
 * @param $type 模板类型, 0:商城模板; 1:手机端模板
 **/
function site_template_config($site_name, $type)
{

    $Model = new \Think\Model();
    $sql = "SELECT view_path, default_theme, tmpl_detect_theme, theme_list, tmpl_parse_string_static FROM global_site_template_config WHERE site_name='$site_name' AND tmpl_type=" . $type;
    $data = $Model->query($sql);
    if(count($data) == 0){
        return false;
    }
    session('site_view_path', $data[0]['view_path']);
    session('site_default_theme', $data[0]['default_theme']);
    session('site_static', $data[0]['tmpl_parse_string_static']);
    return true;

}

/**
 * 将时间格式或时间戳解析为文字的时间间隔
 * @param string $time 要解析的时间格式或时间戳
    * @return false|string 返回时间间隔字符串
*/
function date_to_timestamp($time = "")
{
    if (strtotime($time)) {
        $time = strtotime($time);
    }
    //获取今天凌晨的时间戳
    $today = strtotime(date('Y-m-d', time()));
    //获取昨天凌晨的时间戳
    $yesterday = strtotime(date('Y-m-d', strtotime('-1 day')));
    //获取现在的时间戳
    $now = time();
    $tc = $now - $time;

    if ($time < $yesterday) {
        $str = date('Y-m-d H:s', $time);
    } elseif ($time < $today && $time > $yesterday) {
        $str = "昨天";
    } elseif ($tc > 60 * 60) {
        $str = floor($tc / (60 * 60)) . "小时前";
    } elseif ($tc > 60) {
        $str = floor($tc / 60) . "分钟前";
    } else {
        $str = "刚刚";
    }
    return $str;
}

/**
 * 将返回的数据集转换成树
 * @param  array   $list  数据集
 * @param  string  $pk    主键
 * @param  string  $pid   父节点名称
 * @param  string  $child 子节点名称
 * @param  integer $root  根节点ID
 * @return array          转换后的树
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root=0) {
    $tree = array();// 创建Tree
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[$data[$pk]] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 获取当前请求URL
**/
function get_request_url(){
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/*发送邮件方法
 *@param $to：接收者 $title：标题 $content：邮件内容 $config:发件人配置信息
 *@return bool true:发送成功 false:发送失败
 */

function sendMail($to, $title, $content, $config){

    //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
    require_once("./ThinkPHP/Library/Vendor/phpmailer/class.phpmailer.php");
    require_once("./ThinkPHP/Library/Vendor/phpmailer/class.smtp.php");

    $emailOption = C('SEND_EMAIL');     //config里面还没写邮箱配置名字和密码
    //实例化PHPMailer核心类
    $mail = new PHPMailer();
    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    $mail->SMTPDebug = 1;

    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();

    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth=true;

    //链接qq域名邮箱的服务器地址
    $mail->Host = $config['smtp_server'];

    //设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure =$emailOption['SMTPSecure'];

    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->Port = $config['smtp_port'];

    //设置smtp的helo消息头 这个可有可无 内容任意
    // $mail->Helo = 'Hello smtp.qq.com Server';

    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
    $mail->Hostname = 'localhost';

    //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->CharSet = 'UTF-8';

    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = $config['store_name'];

    //smtp登录的账号
    $mail->Username = $config['smtp_user'];

    //smtp登录的密码
    $mail->Password =  $config['smtp_pwd'];

    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From = $config['smtp_user']; ;

    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true);

    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($to,'收件人');

    //添加多个收件人 则多次调用方法即可
    // $mail->addAddress('xxx@xx.com','收件人');

    //添加该邮件的主题
    $mail->Subject = $title;

    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $content;

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    $status = $mail->send();

    //简单的判断与提示信息
    if($status) {
        return true;
    }else{
        return false;
    }
}

/**
 * 邮件发送(异步)
 */
function send_email_asyn($address, $title, $content){
    $where = "inc_type='email' OR inc_type='shop_info'";
    $list = M('Config')->where($where)->select();
    foreach ($list as $key => $value) {
        $config[$value['name']] = $value['value'];
    }

    if (!function_exists('pcntl_fork')) {
        return false;
    }
    pcntl_signal(SIGCHLD, SIG_IGN);

    $pid = pcntl_fork();

    if ($pid == -1) {
        //错误处理：创建子进程失败时返回-1.
        return false;
    } else if ($pid) {
        //父进程会得到子进程号，所以这里是父进程执行的逻辑
        pcntl_wait($status,WNOHANG);
        return true;
    } else {
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        sendMail($address, $title, $content, $config);
        exit(0);
    }

}


/**
 * 	作用：将xml转为array
 */
function xml_to_array($xml)
{
    //将XML转为array
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}

function wechat_notify_url(){
    $http = 'http';
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
        $http = 'https';
    }
    $domain = $http . '://' . I('server.HTTP_HOST');
    $url = $domain . '/index.php/Wechat/Mp/notify';
    return $url;
}


/**
 * 发送站内信
 * @param $content  内容
 *
*/
function sendNotice($content,$userid)
{
    if($userid==''){
        $data['user_id']=$_SESSION['userId'];
    }else{
        $data['user_id']=$userid;
    }

    $data['content']=$content;
    $data['status']='0';
    $data['create_time']=date("Y-m-d H:i:s");
    M('notice_relation_user')->add($data);
}

function send_note($content, $phonenum)
{
    $postFields['account']='paoding';
    $postFields['pswd']='Tch123456';
    $postFields['msg']=$content;
    $postFields['mobile']=$phonenum;
    $postFields['needstatus']='false';
    $url="http://222.73.117.156/msg/HttpBatchSendSM";
    $postFields = http_build_query ( $postFields );
    $ch = curl_init();
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
    $result = curl_exec ( $ch );
    curl_close ( $ch );
    return $result;
}