<?php

namespace Admin\Controller;

class UploadifyController extends BaseController{

    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
     
    }

    public function upload(){
        $imageSize = M('config')->where("name = 'image_size'")->getField("value");
        $func = I('func');
        $path = I('path','temp');
        $info = array(
        	'num'=> I('num'),
            'title' => '',       	
        	'upload' =>U('Admin/Ueditor/imageUp',array('savepath'=>$path,'pictitle'=>'banner','dir'=>'images')),
            'size' => $imageSize.'MB',
            'type' =>'jpg,png,gif,jpeg,ico',
            'input' => I('input'),
            'func' => empty($func) ? 'undefined' : $func,
        );
        $this->assign('info',$info);
        $this->display();
    }

    public function uploadImg(){
        $imageSize = M('config')->where("name = 'image_size'")->getField("value");
        $func = I('func');
        $path = I('path','temp');
        $info = array(
            'num'=> I('num'),
            'title' => '',
            'upload' =>U('Admin/Ueditor/imageUp',array('savepath'=>$path,'pictitle'=>'banner','dir'=>'images')),
            'size' => $imageSize.'MB',
            'type' =>'jpg,png,gif,jpeg,ico',
            'eid' => I('eid'),
            'func' => empty($func) ? 'undefined' : $func,
        );
        $this->assign('info',$info);
        $this->display();
    }

    public function uploadFile(){
        $fileSize = M('config')->where("name = 'file_size'")->getField("value");
        $func = I('func');
        $path = I('path','temp');
        $info = array(
            'num'=> I('num'),
            'title' => '',
            'upload' =>U('Admin/Ueditor/fileUpload',array('savepath'=>$path)),
            'size' => $fileSize.'MB',
            'type' =>'',
            'input' => I('input'),
            'func' => empty($func) ? 'undefined' : $func,
        );
        $this->assign('info',$info);
        $this->display();
    }

    /*
              删除上传的图片
     */
    public function delupload(){
        $action=isset($_GET['action']) ? $_GET['action'] : null;
        $filename= isset($_GET['filename']) ? $_GET['filename'] : null;
        $filename= str_replace('../','',$filename);
        $filename= trim($filename,'.');
        $filename= trim($filename,'/');
        if($action=='del' && !empty($filename)){
            $size = getimagesize($filename);
            $filetype = explode('/',$size['mime']);
            /*if($filetype[0]!='image'){
                return false;
                exit;
            }*/
            unlink($filename);
            exit;
        }
    }

}