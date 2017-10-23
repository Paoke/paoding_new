<?php
namespace Home\Controller;
use Think\Controller;
class TaskController extends Controller {




    public function index(){
	/*	$a='true';$b='请在微信中打开此网页！';
		//是否在微信中打开
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false ) {	}else	{			dump( $b);			}
   */
	$this->display();
    }

	public function fastTask(){		
   
	$this->display();
    }

	public function fastTask_do(){	
		$uid = session('uid');
		$_POST['uid'] = $uid;
		$_POST['reg_time'] = time();
		$_POST['source'] = 'weixin';
		$_POST['country'] = '中国';
		$Task = M('apply');
		$task = $Task->add($_POST);

	     if(!empty($task)){
			 //session('apply_id',$task);
			 /*********用户发需求时发短信***************/
			$mobile = $_POST['phone'];
			$message = "尊敬的用户您好，我们已收到您的申请，并会尽快给您回复。在此期间如果您想获得更多的服务，请登录paoding.cc并填写完整您的联系方式。登录时请选择手机动态登录方式。";
			sms($message,$mobile);
			$mobile1 = "13710795745";
			//$mobile1 = "18565190690,13710795745,18520391103";	//张晓烁,王雨辰,
			$da ="<".$_POST['name'].">(".$_POST['phone'].")用微信网站发布了咨询：'".$_POST['message']."'";
			sms($da,$mobile1);
			/************************/
			 
			 $this->redirect('Task/isSuccess', array('apply_id' => $task), 0, '页面跳转中...');        }
		 else{$this->redirect('Task/fastTask', array('cate_id' => 2), 0, '页面跳转中...');        }


   
//	$this->display();
    }




	public function isSuccess(){		
   $apply_id=$this->apply_id = I('apply_id');
   dump($apply_id);
	$this->display();
    }

	
}