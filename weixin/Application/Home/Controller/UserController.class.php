<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {




    public function index(){

	/*	$a='true';
		$b='请在微信中打开此网页！';
		//是否在微信中打开
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false ) {
		//	dump($a);
			}
		else	{
			dump( $b);
			}
	 
	// dump($User_weixin);

		*/
		$uid = session('uid');
		//$User_weixin = $this->User_weixin = session('User_weixin');
	//	$nickname= $user_obj['nickname'];		
     //   $headimgurl = $user_obj['headimgurl'];

		if(!empty($uid)){

		$Space = M('space');
		$space = $this->space = $Space->where('uid='.$uid)->find();}
		else{
		$space = null;
		}




   
	$this->display();
    }
/*
	public function select(){	
		$uid = session('uid');
		$uid = 6026;
		$Apply = M('apply');

		$unfished = $this->unfished = $Apply->where('uid='.$uid.' AND pay_status = 0')->select();
		$fished   = $this->fished   = $Apply->where('uid='.$uid.' AND pay_status = 1')->select();
   
	$this->display();
    }*/

	public function unfished(){
		$uid = session('uid');
		if(!empty($uid)){
		$Apply = M('apply');
		$unfished = $this->unfished = $Apply->where('uid='.$uid.' AND status < 5')->select();
		//}else{$this->redirect('User/index', array('cate_id' => 2), 0, '页面跳转中...');}
		}else{$unfished = $this->unfished =null;}
		$this->display();
	}

	public function fished(){
		$uid = session('uid');
		if(!empty($uid)){
		$Apply = M('apply');
		$fished = $this->fished = $Apply->where('uid='.$uid.' AND status = 5')->select();
		//}else{$this->redirect('User/index', array('cate_id' => 2), 0, '页面跳转中...');}
		}else{$unfished = $this->unfished =null;}
		$this->display();
	}

	public function editor(){
		
		$this->display();
	}



	public function orderlist(){		
   
	$this->display();
    }

	public function order(){		
   
	$this->display();
    }

	public function order_detail(){	
		$apply_id = I('apply_id');

		$Apply = M('apply');
		$apply = $this->apply = $Apply->where('apply_id='.$apply_id)->find();

   
	$this->display();
    }

	public function modify_phone(){
	  $uid = session('uid');
	  
		/*if(!empty($uid)){
		$Space = M('space');
		$mobile = $this->mobile = $Space->where('uid='.$uid)->getField('mobile');	}
	
	else{$this->redirect('User/index', array('cate_id' => 2), 0, '页面跳转中...');}
	*/

	$this->display();
    }	

	public function modify_phone_do(){	
		$uid = session('uid');
		$code = session('code');
		$newmobile = I('newmobile');
		$newcode = I('newcode');
		if(!empty($newmobile)){
		$Member = M('space');
		$cond['mobile'] = $newmobile;
		$member = $Member->where('uid='.$uid)->save($cond);}
		else{
		$this->redirect('User/modify_phone', array('cate_id' => 2), 0, '页面跳转中...');
		
		}
		$this->redirect('User/index', array('cate_id' => 2), 0, '页面跳转中...');
	
    }

	public function modify_password(){
		$uid = session('uid');
		$this->display();
    }

	public function modify_password_do(){
		$uid = session('uid');
		if(!empty($uid)){
		$password = I('password');
		$newpassword = I('newpassword');
		$repassword = I('repassword');
		$Member = M('member');
		$oldpassword = $Member->where('uid='.$uid)->getField('password');
		if($password!=$oldpassword){ $this->redirect('User/modify_password', array('cate_id' => 2), 0, '页面跳转中...');      }
		if(empty($newpassword)){ $this->redirect('User/modify_password', array('cate_id' => 2), 0, '页面跳转中...');      }
		if($newpassword!=$repassword){ $this->redirect('User/modify_password', array('cate_id' => 2), 0, '页面跳转中...');      }
		$cond['password'] = md5($newpassword);
		$member = $Member->where('uid='.$uid)->save($_POST);
		}
	else{$this->redirect('User/index', array('cate_id' => 2), 0, '页面跳转中...');}
	$this->display();
    }



//修改手机号获取验证码
	public function sendsms(){
		$phone = I('phone');
		$code = rand(100000,999999);
		session('updatephone',$phone);
		session('updatecode',$code);
		$message ="您好！验证码是：" . $code ;
		sms($message,$phone);
	}
//修改手机号动态验证码验证
	public function sendsmsverify(){
		if(IS_AJAX){
			$code = I('code');
			$phone=I('phone');
			if(session('updatecode')==$code && session('updatephone')==$phone){
				$ajax['status'] = 1;
				session('updatecode',null);
				session('updatephone',null);
			}else{
				$ajax['status'] = 0;	
			}
			$this->ajaxReturn($ajax);
		}	
	}

	public function yanzheng(){
		$uid = session('uid');
		$user = M('member')->where(array('uid'=>$uid))->find();
		$data = md5(I('password'));
		$row = md5(I('newpassword'));
		$ros = md5(I('repassword'));
		if($user['password']  != $data){
			$ajax['status'] = 0;		//0原始密码不正确返回	
		}else if($row != $ros ){	
			$ajax['status'] = 1;		//1次密码输入不正确返回
		}else{
			$shuju['password'] = $row;
			$shuju['uid'] = $uid;
			M('member')->save($shuju);		//2更新成功
			$ajax['status'] = 2;
		}
		$this->ajaxReturn($ajax);
	}






}


