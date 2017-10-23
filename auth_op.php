<?php
	if(isset($_GET['auth_code'])){
		var_dump($_GET['auth_code']);exit;
	}
	
	
	header("Location:https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=wx146146e36bcaa37e&pre_auth_code=".getAuthCode()."&redirect_uri=http%3a%2f%2fwww.paoding.cc%2fauth_op%2findex.php");
	
	function getCode(){
	$url = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token='.getAcToken();
	$date='{
	"component_appid":"wx146146e36bcaa37e" 
	}';
	$info = https_request($url,$date);
	$res = json_decode($info,true);
	return $res['pre_auth_code'];
	}
	
	function getAuthCode() {
		if (file_exists('AuthCode_ax.json')) {
			$data = json_decode(file_get_contents('AuthCode_ax.json'));
			if ($data -> expire_time < time()) {
				
				$access_token = getCode();
				if ($access_token) {
					$data -> expire_time = time() + 1600;
					$data -> access_token = $access_token;
					$fp = fopen('AuthCode_ax.json', 'w');
					fwrite($fp, json_encode($data));
					fclose($fp);
				}
			} else {
				$access_token = $data -> access_token;
			}
		} else {
			$access_token = getCode();
			if ($access_token) {
				$data['expire_time'] = time() + 1600;
				$data['access_token'] = $access_token;
				$fp = fopen('AuthCode_ax.json', 'w');
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		}
		return $access_token;
	}
	
	function getAccessToken(){
	$data = json_decode(file_get_contents('./auth_op/ComponentVerifyTicket.json'),true);
	$url = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
	$date='{
		"component_appid":"wx146146e36bcaa37e" ,
		"component_appsecret": "040419d55f0820cff5d1eb0c4483d93b", 
		"component_verify_ticket": "'.$data['VerifyTicket'][0].'" 
		}';
	$info = https_request($url,$date);
	$res = json_decode($info,true);
	return $res['component_access_token'];
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
	
	function getAcToken() {
		if (file_exists('component_access_token_ax.json')) {	
			$data = json_decode(file_get_contents('component_access_token_ax.json'));
			if ($data -> expire_time < time()) {
				$access_token = getAccessToken();
				if ($access_token) {
					$data -> expire_time = time() + 7000;
					$data -> access_token = $access_token;
					$fp = fopen('component_access_token_ax.json', 'w');
					fwrite($fp, json_encode($data));
					fclose($fp);
				}
			} else {
				$access_token = $data -> access_token;
			}
		} else {
			$access_token = getAccessToken();
			if ($access_token) {
				$data['expire_time'] = time() + 7000;
				$data['access_token'] = $access_token;
				$fp = fopen('component_access_token_ax.json', 'w');
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		}
		return $access_token;
	} 