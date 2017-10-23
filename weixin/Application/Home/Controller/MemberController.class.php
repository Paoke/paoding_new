<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller {
   
	//PC网站扫二维码进入这里
	public function weixin_login(){
		$url = I('url');
	//	dump($url);
		 //插入数据库
	//	$url = substr($url,12);
	//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx439d64ef3294cf25&redirect_uri=http%3a%2f%2fwww.paoding.cc%2fHome%2fOauth%2fweixin_login&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
	//
	//$http_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx439d64ef3294cf25&redirect_uri=http%3a%2f%2fwww.paoding.cc%2fHome%2fOauth%2findex&response_type=code&scope=snsapi_userinfo&state=".$url."#wechat_redirect";
	/*	if(empty($url)){
			$token = "paoding";
			$timestamp = time();
			$nonce = 11111;
			$tmpArr = array($token, $timestamp, $nonce);
			 // use SORT_STRING rule
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			$url = "WeixinLogin_".$tmpStr;
		 }
*/

	$http_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx439d64ef3294cf25&redirect_uri=http%3a%2f%2fwww.paoding.cc%2fweixin%2fHome%2fMember%2flogin_do&response_type=code&scope=snsapi_userinfo&state=".$url."#wechat_redirect";

	//http%3a%2f%2fwww.paoding.cc%2fWEIXIN%2fHome%2fIndex%2findex
		redirect($http_code, 0, '页面跳转中...');
	
	}

	//从公众号的首页登陆
	public function gongzhong_login(){
			
			/*********根据当前时间生成随机数地址*********/
		    $token = "paoding";
			$timestamp = time();
			$nonce = 11111;
			$tmpArr = array($token, $timestamp, $nonce);
			 // use SORT_STRING rule
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			$url = "WeixinLogin_".$tmpStr;
			/*******************************************/
			session('url',$url);
	
//	http://www.paoding.cc/weixin/Home/Member/login_do
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx439d64ef3294cf25&redirect_uri=http%3a%2f%2fwww.paoding.cc%2fweixin%2fHome%2fMember%2flogin_do&response_type=code&scope=snsapi_userinfo&state=2015#wechat_redirect
	$http_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx439d64ef3294cf25&redirect_uri=http%3a%2f%2fwww.paoding.cc%2fweixin%2fHome%2fMember%2flogin_do&response_type=code&scope=snsapi_userinfo&state=".$url."#wechat_redirect";


	//dump($http_code);
	redirect($http_code, 0, '页面跳转中...');
	
	
	}


   //登陆后处理


	public function login_do(){
	
		/**************/
		$erweima = $_GET["state"];
	
		$code    = $_GET["code"]; 
		$appid   = "wx439d64ef3294cf25";
		$secret  = "bed10144c27ddc91ee6072cc0f0755de";

	//	dump($erweima);
	//	dump($code);

		//获取openid
		//https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx439d64ef3294cf25&secret=bed10144c27ddc91ee6072cc0f0755de&code=CODE&grant_type=authorization_code

		$token_url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
		$res=$this->https_request($token_url);
		$json_obj = json_decode($res,true);

		$access_token = $json_obj['access_token']; 
		$openid = $json_obj['openid']; 
		$scope = $json_obj['scope']; 
		$unionid = $json_obj['unionid']; 

		//获取用户信息
		//https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN

		$user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";

		$res_user=$this->https_request($user_url);
		$user_obj = json_decode($res_user,true);
		session('User_weixin',$user_obj);

		$nickname= $user_obj['nickname'];
		$sex     = $user_obj['sex'];

		$province	= $user_obj['province'];
		$city	    = $user_obj['city'];
        $country	= $user_obj['country'];
        $headimgurl = $user_obj['headimgurl'];

		/****************************************************/

		$Member_online = M('member_online');
		$cond['unionid'] = $unionid;

		$result = $Member_online->where($cond)->find();

		if(empty($result)){ 
			$data['erweima'] = $erweima;
			$data['openid']  = $openid ;
			$data['unionid'] = $unionid;
			$data['mstatus'] = '0';
			$data['nickname'] = $nickname;
			$Member_online->add($data); 
			}

		
		$Member = M('member');
		$cond1['unionid'] = $unionid;		
		$user = $Member->where($cond1)->find();

		$uid = $user['uid'];


		
		//用户已注册，并 已绑定微信号
		if(!empty($user)){
			session('uid',$uid);
			$this->redirect('Index/index', array('cate_id' => 2), 0, '页面跳转中...');}
		else{$this->redirect('Member/select', array('cate_id' => 2), 0, '页面跳转中...');}




		
		
		//用户状态： 没注册   ---->   注册

		//用户状态： 没绑定   ---->   绑定

		//用户状态： 已绑定   ---->   登陆

		
	
	
		
	
	  //$this->redirect('New/category', array('cate_id' => 2), 5, '页面跳转中...');
	
	
	}
  //选择注册用户还是绑定用户
	public function select(){
	 $User_weixin = $this->User_weixin = session('User_weixin');
	$this->display();
	}





	//用户未注册，填资料.
	//绑定账号
	public function register(){
	$User_weixin = $this->User_weixin = session('User_weixin');
	$this->display();
	}

	public function register_do(){

		$user_obj = session('User_weixin');
		$username = $_POST['username'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$mobile   = $_POST['mobile'];
		$email    = $_POST['email'];
		if($password!=$repassword){ $this->redirect('Member/register', array('cate_id' => 2), 0, '页面跳转中...');      }

		$Member = M('member');		
		$data['username'] = $username;
		$data['password'] = md5($password);
		$data['email'] = $email;
		$data['openid']  = $user_obj['openid'];
		$data['unionid'] = $user_obj['uniodid'];
		$uid = $Member->add($data);

		$Space = M('space');
		$newdata['uid'] = $uid;
		$newdata['username'] = $username;
		$newdata['password'] = md5($password);
		$newdata['email'] = $email;
		$newdata['mobile'] = $mobile;		
		$newuser = $Space->add($newdata);
		if(!empty($newuser)){
			session('uid',$uid);
			$this->redirect('Index/index', array('cate_id' => 2), 0, '页面跳转中...');}
		else{$this->redirect('Member/select', array('cate_id' => 2), 0, '页面跳转中...');}
	}
	public function register_protocol(){	
		$this->display();
	}


	//绑定账号
	public function binding(){
	$User_weixin = $this->User_weixin = session('User_weixin');
	$username = $this->username = I('username');	
	$this->display();
	}



	public function binding_do(){
		$User_weixin = $this->User_weixin = session('User_weixin');

		$username = $_POST['username'];
		$password = md5($_POST['password']);

		$Member = M('member');
		$cond['username'] = $username;
		$cond['password'] = $password;
		$uid = $Member->where($cond)->getField('uid');
		$data['uid'] = $uid;
		$data['username'] = $username;
		$this->ajaxReturn($data);die;
		//$this->redirect('Member/binding_isSuccess', array('uid' => $uid,'username'=>$username), 0, '页面跳转中...');
		
		
	}



	public function binding_isSuccess(){
	$User_weixin = $this->User_weixin = session('User_weixin');
	$url = session('url');
	$uid = $this->uid = I('uid');
	$username = I('username');

	$Member = M('member');

    //将uniodid更新到用户表中
	if(!empty($uid)){
		$data['openid'] =  $User_weixin['openid'];
		$data['unionid'] = $User_weixin['unionid'];		
		$Member->where('uid='.$uid)->save($data);	

		$Member_online = M('member_online');
		$data_1['muid']=$uid;
		$Member_online->where('erweima="'.$url.'"')->save($data_1);
	}    

	//判断是否绑定成功
	$cond_b['uid']       = $uid;
	$cond_b['unionid']   = $User_weixin['unionid'];	
	$is_binding = $this->is_binding = $Member->where($cond_b)->find();
	session('uid',$uid);

	if(!empty($is_binding)){	
			$this->redirect('Index/index', array('uid' => $uid), 0, '您已绑定成功，正在跳转首页...');
		}
	else{
			$this->redirect('Member/binding', array('uid' => $uid,'username'=>$username), 0, '页面跳转中...');
	}

	
	$this->display();
	}





	



	public function https_request($url){

		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);  

		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);  

		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE );  

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

		$res = curl_exec($ch); 

		if(curl_errno($ch)){return 'ERROR'.curl_error($curl);} 

		curl_close($ch); 

		return $res;

	}
//直接AJAX验证3个字段是否占用	
	public function checkregister(){
		if(IS_POST){
			$username = I('post.username');
			$mobile = I('post.mobile');
			$email = I('post.email');
			$space = M('space');
			$data =	$space->where(array('username'=>$username))->find();
			$data1 = $space->where(array('mobile'=>$mobile))->find();
			$data2 = $space->where(array('email'=>$email))->find();
			if($data == false){
				$arr['u_status'] = 1;
			}else{
				$arr['u_status'] = 0;
			}
			if($data1 ==false){
				$arr['m_status'] = 1;
			}else{
				$arr['m_status'] = 0;
			}
			if($data2 ==false){
				$arr['e_status'] = 1;
			}else{
				$arr['e_status'] = 0;
			}
			$this->ajaxReturn($arr);
		}
	}
//验证用户是否绑定。
	public function checkweixin(){
			$User= M('space');
			$username = I('username');
			$password = md5(I('password'));
			$use = $User->where(array('username'=>$username))->find();
			if($use == false){
				$arr['status'] = 0;			//0报错，没有此用户
			}else{
				if($use['password'] !=$password){
					$arr['status'] =1;		//1报错，找到用户，密码验证错误
				}else{
					/*为了实现查找填写的用户是否已有绑定的微信号，待处理*/
					//$member = M('member');
					//$user = $member->where('username'=>$username,'password'=>$password)->find();
					$arr['status'] = 2;			//2正确，找到用户，且密码验证正确
					$arr['uid'] =$use['uid'];
					$arr['username'] =$sue['username'];
				}
			}
			$this->ajaxReturn($arr);

	}	

}

