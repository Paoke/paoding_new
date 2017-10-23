<?php
namespace Home\Controller;
use Think\Controller;
class ProtocolController extends Controller {
    public function fatask(){
	$this->display();
    }

	public function proman(){
	$apply_id=$this->apply_id = I('apply_id');
	$this->display();
    }

	
}