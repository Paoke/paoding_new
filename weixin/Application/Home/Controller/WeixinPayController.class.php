<?php
namespace Home\Controller;
use Think\Controller;
class WeixinPayController extends Controller {




    public function WeixinPay(){

		$apply_id = session('apply_id');
		
		$Apply = M('apply');
		$data['pay'] = 1 ;
		$data['status'] = 2;
		$apply = $Apply->where('apply_id='.$apply_id)->save($data);

		$this->redirect('User/unfished', array('apply_id' => $apply_id), 0, '页面跳转中...'); 
   
	   $this->display();
    }




}


