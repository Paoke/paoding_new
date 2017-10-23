<?php
/**
 * Created by PhpStorm.
 * User: SingHome
 * Date: 2017/6/15
 * Time: 20:17
 */

namespace Api\Controller;


use Think\Log;

class UploadController
{
    public function upload()
    {
        $fileKey = $_GET['key'];

        if (isset($_FILES[$fileKey])) {

            $site_name = session('site_name');
            $uploadPath = UPLOAD_PATH . $site_name . '/file/';
            mkdir($uploadPath, 0777, true);

            $fileName = $_FILES[$fileKey]['name'];
            $suffix = explode('.', $fileName)[1];
            $fileName = "";
            if($_GET['channel']){
                $fileName .= $_GET['channel'];
            }
            if($_GET['id']){
                $fileName .= $_GET['id'];
            }
            if($fileKey){
                $fileName .= $fileKey;
            }
            $fileName .= time() . '.' . $suffix;

            $file = $uploadPath . $fileName;

            move_uploaded_file($_FILES[$fileKey]['tmp_name'], $file);

            if(is_file($file)){
                $returnArr = array("result" => 1, "msg" => "上传文件成功!", "code" => 200, 'data' => '/'.$file, 'name' => $fileName);
            }else{
                $returnArr = array("result" => 0, "msg" => "上传文件失败，请稍后重试!", "code" => 401, 'name' => $_FILES[$fileKey]['name']);
            }


        }else{
            $returnArr = array("result" => 0, "msg" => "上传文件失败，没有找到文件名!", "code" => 402, 'name' => '无文件');

        }
        $retMsg = urldecode(json_encode($returnArr));
        header("Content-type:text/json;charset=utf-8");
        echo $retMsg;
    }
}