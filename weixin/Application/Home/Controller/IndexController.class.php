<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {




    public function index(){

		$a='true';$b='请在微信中打开此网页！';
		//是否在微信中打开
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false ) {	}else	{			dump( $b);			}

	 $User_weixin = $this->User_weixin = session('User_weixin');
	// dump($User_weixin);

		
   
	$this->display();
    }







	public function apply(){
		$Apply = M('apply');			
			if(IS_POST){
				$_POST['reg_time']=time();					
				if($Apply->add($_POST)){
					$mobile = $_POST['phone'];
					$message = "尊敬的用户您好，我们已收到您的申请，并会尽快给您回复。在此期间如果您想获得更多的服务，请登录paoding.cc并填写完整您的联系方式。登录时请选择手机动态登录方式。";
					sms($message,$mobile);
					$mobile1 = "13710795745";
					//$mobile1 = "18565190690,13710795745,18520391103";	//张晓烁,王雨辰,
					$da ="<".$_POST['name'].">(".$_POST['phone'].")发布了咨询：'".$_POST['message']."'";
					sms($da,$mobile1);
				}	
				//$this->ajaxReturn($_POST);		//已有默认返回
			}
        
	}
	

	
}