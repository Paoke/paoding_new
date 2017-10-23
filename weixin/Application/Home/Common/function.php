<?php


//发系统信息
function systemMsg($to_uid,$to_username,$title,$content){
	$MESSAGE = M('msg');
	$cond['uid'] = 0;
	$cond['username'] = '系统消息';
	$cond['to_uid'] = $to_uid;
	$cond['to_username'] = $to_username;
	$cond['title'] = $title;
	$cond['content'] = $content;
	$cond['on_time'] = date('Y-m-d H:i:s', time())   ;
	$MESSAGE->add($cond); 		 
}


//发送短信
function sms($message,$mobile){
	$data = $message;
	$post_data = array();
	$post_data['account'] = iconv('GB2312', 'GB2312',"paoding");
	$post_data['pswd'] = iconv('GB2312', 'GB2312',"Tch123456");
	$post_data['mobile'] = $mobile;

	$post_data['msg']=mb_convert_encoding("$data",'UTF-8', 'auto');
	$url='http://222.73.117.158/msg/HttpBatchSendSM?'; 
	$o="";
	foreach ($post_data as $k=>$v){
	   $o.= "$k=".urlencode($v)."&";
	}
	$post_data=substr($o,0,-1);
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$result = curl_exec($ch);	
}


?>