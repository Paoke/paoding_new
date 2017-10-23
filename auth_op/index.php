<?php
header("Content-type: text/html; charset=utf-8");
include_once "wxBizMsgCrypt.php";
	if(isset($_GET['auth_code'])){
		 $info = getComponentAccessToken($_GET['auth_code']);
		 /*var_dump($info);exit;*/
		$filename = '../wechat_op/'.$info['authorization_info']['authorizer_appid'];
		if(!is_dir($filename)){
			mkdir($filename);
		}
		$info['expire_time'] = time() + 7000;
		$fp = fopen($filename.'/authorizer.json', 'w');
		fwrite($fp, json_encode($info));
		fclose($fp); 
		echo '<script>window.location.href="http://www.paoding.cc"</script>';
		return;
	}
	
	
	$encodingAesKey = "eZt1Pxp6mK1hQfm7jgHPs7vvvy2pK9PaBBdHUVbH4A9";
	$token = "dingshao";	
	$appId = "wx146146e36bcaa37e";
	$nonce = $_GET['nonce'];
	$timestamp  = $_GET['timestamp'];
	$msg_signature  = $_GET['msg_signature'];
	$encrypt_type = (isset($_GET['encrypt_type']) && ($_GET['encrypt_type'] == 'aes')) ? "aes" : "raw";
	
	$encryptMsg = $GLOBALS["HTTP_RAW_POST_DATA"];
	
	if (!empty($encryptMsg)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
            the best way is to check the validity of xml by yourself */
	   if ($encrypt_type == 'aes'){
		$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
			
			$msg = '';
			$errCode = $pc->decryptMsg($msg_signature, $timestamp, $nonce, $encryptMsg, $msg);
			if ($errCode == 0) {
				libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA);
				//$postObj->ComponentVerifyTicket;
				getAcToken($postObj->ComponentVerifyTicket);
				echo "success";
			} 
			else {
				echo json_encode($errCode);
			} 
		}
	}
	
	function getComponentAccessToken($auth_code){
	$data = json_decode(file_get_contents('../component_access_token_ax.json'),true);
	$url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token='.$data['access_token'];
	$date='{
		"component_appid":"wx146146e36bcaa37e" ,
		"authorization_code": "'.$auth_code.'"
		}';
	$info = https_request($url,$date);
	$res = json_decode($info,true);
	return $res;
	}
	function https_request($url,$data=null){
		$curl = curl_init();
		
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
		if(!empty($data)){
			curl_setopt($curl,CURLOPT_POST,1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
		}
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
	function getAcToken($tick) {
		if (file_exists('ComponentVerifyTicket.json')) {
				$access_token = $tick;
				if ($access_token) {
					$data['VerifyTicket'] = $access_token;
					$fp = fopen('ComponentVerifyTicket.json', 'w');
					fwrite($fp, json_encode($data));
					fclose($fp);
				}
			
		} else {
			$access_token = $tick;
			if ($access_token) {
				$data['VerifyTicket'] = $access_token;
				$fp = fopen('ComponentVerifyTicket.json', 'w');
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		}
		
	}