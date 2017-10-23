<?php
/**
* 	配置账号信息
*/
namespace Common\Util;

use Think\Log;

class WxPayConfig
{
	protected static $cfg = array(
		'APPID'     => '',
		'MCHID'     => '',
		'KEY'       => '',
		'APPSECRET' => '',
		'NOTIFY_URL' => '',
		'SSLCERT_PATH' => '../cert/apiclient_cert.pem',
		'SSLKEY_PATH'  => '../cert/apiclient_key.pem',
		'ROOTCA_PATH'  => '../cert/rootca.pem',
		'REPORT_LEVENL' => 1,
		'CURL_PROXY_HOST' => '0.0.0.0',
		'CURL_PROXY_PORT' => 0,
	);
	public static function getConfig($field = '') {
		return $field ? self::$cfg[$field] : self::$cfg;
	}

	public static function setConfig($c) {
		self::$cfg = array_merge(self::$cfg, $c);
	}
}
