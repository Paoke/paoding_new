<?php

namespace Api\Controller;

use Api\Logic\CompanyLogic;
use Common\Util\Image;
use Think\Log;

class CompanyUserController extends BaseRestController
{

    public function register(){

        $action = $_GET['action'];
        $companyDAO = new CompanyLogic();
        switch($action){
            case 'check':
                if($_POST['account']){
                    $flag = $this->checkAccount($_POST['account']);
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $flag);

                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少参数!", "code" => 402, "data" => null);
                }
                break;
            case 'add':
                $data = I('post.');
                $channel = $data['channel'];
                unset($data['channel']);
                if($channel){
                    //检查是否重名
                    $flag = $this->checkAccount($_POST['account']);
                    if($flag === 1){
                        $returnArr = array("result" => 0, "msg" => "该账号已被使用", "code" => 405);
                        json_return($returnArr);
                    }
                    //检查密码
                    $flag = $this->checkPassword($_POST['company_pw'], $_POST['company_pw_cf']);
                    if(!$flag){
                        $returnArr = array("result" => 0, "msg" => "密码为空或不一致!", "code" => 406);
                        json_return($returnArr);
                    }
                    //保存图片
                    $data = $this->saveImage($data);
                    //密码加密
                    $data['company_pw'] = encrypt($data['company_pw']);
                    unset($data['company_pw_cf']);
                    $channelData = $data;
                    unset($channelData['account']);
                    unset($channelData['company_pw']);

                    $id = $this->saveChannelData($channel, $channelData);
                    if($id){
                        $flag = $this->saveAccount($id, $channel, $data);
                        if($flag){
                            cookie('company_account', $data['account']);
                            $returnArr = array("result" => 1, "msg" => "创建用户成功", "code" => 200, "data" => $id);
                        }else{
                            //删掉公司表的数据
                            $companyDAO->delete($id);
                            $returnArr = array("result" => 0, "msg" => "新增用户失败", "code" => 404);
                        }
                    }else{
                        $returnArr = array("result" => 0, "msg" => "新增用户失败", "code" => 403);
                    }
                }else{
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少频道参数!", "code" => 401);
                }
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
            break;
        }
        json_return($returnArr);
    }


    //重置密码
    public function reset(){
        $action = $_GET['action'];
        $channel = $_GET['channel'];
        switch($action) {
            case 'send_code':
                $where['user_name'] = $_POST['account'];
                $where['channel'] = $channel;
                $where['is_lock'] = 0;
                $account = M('ManageUsers')->where($where)->find();

                if(!$account){
                    $returnArr = array("result" => 0, "msg" => "没有找到账号[".$_POST['account']."],请检查", "code" => 401, "data" => null);
                    json_return($returnArr);
                }
                //检查发送次数(每天三次)
                $conf = "user_id=".$account['id']." AND user_type=2 AND TO_DAYS(create_time) = TO_DAYS(NOW())";
                $count = M('ManageValidCode')->where($conf)->count();
                if($count >= 3){
                    $returnArr = array("result" => 0, "msg" => "重置码发送已超过当天限制(每天3次)", "code" => 401, "data" => null);
                    json_return($returnArr);
                }

                $companyTable = $this->getTableName($account['channel'], 1);
                $where = array();
                $where['id'] = $account['data_id'];
                $company = M("$companyTable")->where($where)->find();
                $email = $company['email'];
                if(!$email){
                    $returnArr = array("result" => 0, "msg" => "账号[".$where['account']."]没有邮箱,不能更改密码", "code" => 401, "data" => null);
                    json_return($returnArr);
                }

                $resetCode = get_rand_str(6, 0, 0);
                $title = "您正在重置密码";
                $content = "您的重置码为: ".$resetCode." , 重置码30分钟内有效，请尽快更改密码!";

                try{
                    //发送邮件
                    send_email_asyn($email, $title, $content);
                    //记录发送码
                    $data['code'] = $resetCode;
                    $data['type'] = 1;//1为邮件
                    $data['is_used'] = 0;
                    $data['user_id'] = $account['id'];
                    $data['user_type'] = 2;//企业账户
                    $data['create_time'] = date('Y-m-d H:i:s', time());
                    M('ManageValidCode')->add($data);

                    $this->logRecord(6, "邮件发送重置码[".$resetCode."]成功", 7, $company['channel_id'], $company['id']);
                    $flag = true;
                }catch(\Exception $e){
                    $this->logRecord(4, "邮件发送重置码[".$resetCode."]失败", 7, $company['channel_id'], $company['id']);
                    $flag = false;
                }

                if($flag){
                    $returnArr = array("result" => 1, "msg" => "已经发送邮件，请查收重置码，更改密码", "code" => 200);
                }else{
                    $returnArr = array("result" => 0, "msg" => "发送邮件失败!", "code" => 401);
                }

                break;

            case 'update':
                $channel = M('SystemChannel')->where("call_index='".$channel."'")->find();
                //获取客户信息
                $where['user_name'] = $_POST['account'];
                $where['is_lock'] = 0;
                $account = M('ManageUsers')->where($where)->find();

                if(!$account){
                    $returnArr = array("result" => 0, "msg" => "没有找到账号[".$where['account']."],请检查", "code" => 402, "data" => null);
                    json_return($returnArr);
                }

                //检验重置码
                $status = $this->checkResetCode($_POST['reset_code'], $account['id'], 2);
                if($status != 1){
                    $returnArr = array("result" => 0, "msg" => "重置码出错,请检查", "code" => 403, "data" => $status);
                    json_return($returnArr);
                }
                //将当前用户所有重置码置为已使用
                $conf['user_id'] = $account['id'];
                $conf['user_type'] = 2;
                M('ManageValidCode')->where($conf)->setField('is_used', 1);

                //检验密码
                $pw1 = $_POST['new_pw'];
                $pw2 = $_POST['re_pw'];
                $flag = $this->checkPassword($pw1, $pw2);
                if(!$flag){
                    $returnArr = array("result" => 0, "msg" => "校验新密码出错,请检查", "code" => 404, "data" => null);
                    json_return($returnArr);
                }

                //更改account密码
                $password = encrypt($pw1);
                $flag = M('ManageUsers')->where('user_id='.$account['userid'])->setField('password', $password);
                if($flag){
                    $companyTable = $this->getTableName($account['channel'], 1);
                    M("$companyTable")->where("id=".$account['data_id'])->setField('company_pw', $password);
                    $returnArr = array("result" => 1, "msg" => "修改密码成功", "code" => 200, "data" => null);
                    $this->logRecord(6, "重置密码成功", 7, $channel['id'], $account['data_id']);
                }else{
                    $returnArr = array("result" => 0, "msg" => "修改密码失败", "code" => 405, "data" => null);
                    $this->logRecord(4, "重置密码失败", 7, $channel['id'], $account['data_id']);
                }

                break;

            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
                break;
        }

        json_return($returnArr);

    }

    private function checkResetCode($resetCode, $userId, $userType=0){
        if(empty($resetCode)){
            return -1;//重置码空
        }
        $DAO = M('ManageValidCode');
        //检查是否相等(跟当前用户最新重置码[未使用]校验)
        $where['user_id'] = $userId;
        $where['user_type'] = $userType;
        $where['is_used'] = 0;

        $newResetCode = $DAO->where($where)->order('create_time DESC')->find();
        if($newResetCode == null || $resetCode !== $newResetCode['code']){
            return -2;//重置码错误
        }

        //检查是否超时
        $new = date("Y-m-d H:i:s", time());
        $resetCodeTime = $newResetCode['create_time'];

        $minute = floor((strtotime($new)-strtotime($resetCodeTime))%86400/60);
        if($minute > 30){
            return -3; //已失效
        }

        return 1;
    }

    private function saveImage($data){
        foreach($data as $key=>$value){
            if(strpos($value, 'data:image') !== false){
                $base64Image = $value;
                $site = get_site_name();
                $imgDiv = UPLOAD_PATH . $site. '/image/' . date('Ymd', time()) . '/';

                $imgPath = Image::base64ToFile($base64Image, $imgDiv, $key);
                $data[$key] = $imgPath;
            }
        }
        
        return $data;
    }
    
    public function fans(){
        $account = session('account');
        if($account){
            $action = $_GET['action'];
            $model = M('ManageUsersRelation');
            switch($action){
                case 'list':

                    $where['A.to_user_id'] = $account['id'];

                    //$count = $model->where($where)->count();
                    $page_num = I('post.page_num', null) ? I('post.page_num') : 10;   //$page_num 每页几条数据
                    $page_now = I('post.page_now', 1);   //$page_now 第几页
                    //$page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                    $data = $model->alias('A')->join('LEFT JOIN __MANAGE_USERS__ B ON A.`from_user_id` = B.`user_id`')
                                ->field('B.user_id,B.mobile,B.nickname,B.email,B.head_pic,B.sex,B.birthday,B.desc')
                                ->where($where)->page($page_now, $page_num)
                                ->order('add_time DESC')
                                ->select();

                    if($data){
                        $returnArr = array("result" => 1, "msg" => "获取数据成功!", "code" => 200, "data" => $data);
                    }else{
                        $returnArr = array("result" => 0, "msg" => "获取数据失败!", "code" => 401, "data" => null);
                    }
                    break;


                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
                    break;
            }


        }else{
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登录!", "code" => -1, "data" => null);
        }

        json_return($returnArr);

    }

    /*
     * 检查账号
     * **/
    private function checkAccount($account){
        $where['user_name'] = $account;
        $where['is_lock'] = 0;
        $count = M('ManageUsers')->where($where)->count();
        $flag = 0;
        if($count > 0){
            $flag = 1;
        }
        return $flag;
    }

    /*
     * 插入频道数据
     * **/
    private function saveChannelData($channelIndex, $data){


        $channel = M('SystemChannel')->where("call_index='".$channelIndex."'")->find();
        $data['channel_id'] = $channel['id'];
        if(is_null($data['logo_img'])){
            $data['logo_img'] = '/Public/images/company.png';
        }
        $data["create_user_id"] = $_SESSION["userArr"]["user_id"];
        $data["create_user"] = $_SESSION["userArr"]["nickname"];
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $data['is_delete'] = 0;

        $channelTable = getChannelTable($channelIndex, 1)['table_format'];
        $id = M($channelTable)->add($data);

        return $id;
    }

    /*
     * 更新频道数据
     * */
    private function updateChannelData($channel, $id, $data){
        $DAO = new CompanyLogic();
        $bool = $DAO->setTable($channel, 1);
        if(!$bool){return false;}

        $data["update_user_id"] = session('account')["id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());
        $data['is_delete'] = 0;

        $flag = $DAO->update($id, $data);
        return $flag;
    }


    /*
     * 检查密码
     * **/
    private function checkPassword($pw1, $pw2){
        if($pw1 && $pw2 && $pw1 === $pw2){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 保存企业的时候保存用户
     * **/
    private function saveAccount($id, $channel, $data){
        $account['user_name'] = $data['account'];
        $account['password'] = $data['company_pw'];
        $account['nickname'] = $data['title'];

        $account['reg_time'] = date('Y-m-d H:i:s',time());

        $flag = M('ManageUsers')->add($account);
        //添加用户和频道数据的关联关系

        $where['call_index'] = $channel;
        $channel = M('SystemChannel')->where($where)->find();
        $relation['channel_id'] = $channel['id'];
        $relation['channel_index'] = $channel['call_index'];
        $relation['data_id'] = $id;
        $relation['user_id'] = $flag;
        M('SystemRelation')->add($relation);

        return $flag;
    }

    public function get_account(){
        $account = session('company_account');
        if($account){
            $relation = M('SystemRelation')->where('user_id='.$account['user_id'])->find();
            $table = getTableStr($relation['channel_index'], 1, 'table_format');
            $company = M($table)->where('id='.$relation['data_id'])->find();
            $returnArr = array("result" => 1, "msg" => "获取信息成功", "code" => 200, "data" => $company);
        }else{
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登录!", "code" => -1, "data" => null);
        }
        json_return($returnArr);
    }
}
