<?php
namespace Home\Controller;
use Think\Controller;
class PromanController extends Controller {




    public function index(){
		
		$uid = session('uid');
		//$uid = 5916;
		$a='true';
		$b='请在微信中打开此网页！';
		//是否在微信中打开
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false ) {}
		else{	dump( $b);}
	 $User_weixin = $this->User_weixin = session('User_weixin');


		
		if(!empty($uid)){ 
			
		$Proman = M('proman');
		$proman = $this->proman = $Proman->select();}		
	$this->display();
    }


	public function proman(){
		$id = I('id');	
		$Proman = M('proman');
		$proman = $this->proman = $Proman->where('id='.$id)->find();
		$proman_uid = $proman['uid'];

		$Apply = M('apply');

		$pingjia = $this->pingjia = $Apply->where('proman_id='.$id)->order('reg_time desc')->select();

		/*$Comment =  M('comment');
		$comment = $this->comment = $Comment->where('obj_id='.$proman_uid)->select();*/
	$this->display();
	}


/*

	public function index(){
	
		$uid = session('uid');
		$uid = 5916;
		if(!empty($uid)){ 
			$Apply = M('apply');
			$apply = $this->apply = $Apply->where('uid='.$uid.' AND pay_status = "0" ')->order('reg_time DESC')->find();
			$proman_id = $this->proman_id = $apply['proman_id'];

		

				if(!empty($proman_id)){ 
					$this->redirect('Proman/proman_start', array('cate_id' => 2), 0, '页面跳转中...');
				}
			
			}
		
		$Proman = M('proman');
		$proman = $this->proman = $Proman->select();		
	$this->display();
	}


*/

	



























	public function evaluation(){

		$apply_id=$this->apply_id = I('apply_id');






		$this->display();
	 }

	 public function evaluationing(){

		$apply_id=$this->apply_id = I('apply_id');
  





		$this->display();
	 }









	public function evaluationing_do(){

		$Proman = M('apply');
		$apply_id=$this->apply_id = I('apply_id');

		if(!empty($apply_id)){
		$proman = $Proman->where('apply_id='.$apply_id)->save($_POST);		
		}
		else{
		$proman = $Proman->add($_POST);
		}
		$data = $Proman->where('apply_id='.$apply_id)->find();
		$name = $data['name'];
		$phone = $data['phone'];
		$message = $data['message'];
		$proman_fangshi =$data['proman_fangshi'];
		$proman_time = $data['proman_time'];
		session('apply_id',$apply_id);
		session('weixin_name',$name);
		session('weixin_phone',$phone);
		session('weixin_message',$message);
		session('weixin_proman_fangshi',$proman_fangshi);
		session('weixin_proman_time',$proman_time);
		redirect('http://www.paoding.cc/weixin/weixinpaytest/example/jsapi.php',0, '页面跳转中...');
	//$this->redirect('Proman/order', array('uid' => $uid,'username'=>$username), 0, '页面跳转中...');
	// $this->display();
	 }




	//预约经理
	 public function proman_start(){
		$uid = session('uid');
		//$uid = 5916;
	
	
		if(!empty($uid)){
		$Apply = M('apply');
		$apply = $this->apply = $Apply->where('uid='.$uid.' AND status = "0" ')->order('reg_time desc')->find();
		$proman_id = $apply['proman_id'];
		$Proman = M('proman');
		$promaned = $this->promaned = $Proman->where('id='.$proman_id)->find();
		session('promaned',$promaned);
		}
		else{ $this->redirect('Proman/index', array('cate_id' => 2), 0, '页面跳转中...');}


	$this->display();
	}

	  
	//见面结束
	  public function proman_end(){
		
	  $this->display();
	 }

	 //订单
	 public function order(){

		$apply_id = session('apply_id');
		$Apply = M('apply');
		$apply = $this->apply = $Apply->where('apply_id='.$apply_id)->find();
		
	 $this->display();
	 }

	 public function proman_pingjia(){
		 $apply_id =$this->apply_id = I('apply_id');
			$Apply = M('apply');
			$apply = $this->apply = $Apply->where('apply_id='.$apply_id)->find();

	  $this->display();
	 }

	//接受评价
	  public function proman_pingjia_do(){
		$uid = session('uid');
		//$uid = 5916;

		$pingjia = I('pingjia');
		$_POST['proman_pingjia'] = $pingjia;

		$apply_id = I('apply_id');
		$_POST['status'] = "3"; 
		$Apply = M('apply');
		$apply = $Apply->where('apply_id='.$apply_id)->save($_POST) ;

		if($pingjia== "0" ){ $this->redirect('Proman/unsatisfy',   array('apply_id' => $apply_id), 0, '页面跳转中...');    }
		if($pingjia== "1" ){ $this->redirect('Proman/satisfy', array('apply_id' => $apply_id), 0, '页面跳转中...');    }

		
	  $this->redirect('Index/index', array('uid' => $uid,'username'=>$username), 0, '页面跳转中...');
	 }

	public function satisfy(){
		$apply_id=$this->apply_id = I('apply_id');
		
		$Apply = M('apply');
		$proman_id = $this->proman_id = $Apply->where('apply_id='.$apply_id)->getField('proman_id');
		$this->display();
	}

	public function unsatisfy(){
		$apply_id=$this->apply_id = I('apply_id');
		$Apply = M('apply');
		$proman_id = $this->proman_id = $Apply->where('apply_id='.$apply_id)->getField('proman_id');
		$this->display();
	}


	public function download(){
	$apply_id=$this->apply_id = I('apply_id');
	$Apply = M('apply');
		$data['status'] = 4; // 2,已支付，3，已评价，4，已下载
		$apply = $Apply->where('apply_id='.$apply_id)->save($data);
	dump($apply_id);
	
	$this->display();
	}


	









	public function finished(){
		$apply_id=$this->apply_id = I('apply_id');

		
		$Apply = M('apply');
		$data['status'] = 5; // 2,已支付，3，已评价，4，已下载
		$apply = $Apply->where('apply_id='.$apply_id)->save($data);

		$this->redirect('User/fished', array('apply_id' => $apply_id), 0, '页面跳转中...'); 

		$this->display();
	}






	
}