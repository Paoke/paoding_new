<?php

namespace Api\Controller;

use Api\Logic\CompanyLogic;
use Common\Util\Image;
use Think\Log;

class CompanyController extends BaseRestController
{
    /*
     * 获取列表
     */
    public function dataList()
    {
        $parameterGet = I('get.');
        $parameterPost = I('post.');
        $parameter = array_merge($parameterGet, $parameterPost);
        $type = $parameter['type'];
        switch ($type) {
            case 1:
                $returnArr = $this->getCompanyList($parameter);
                break;
            case 4://标签
                $returnArr = $this->getTagList($parameter);
                break;
            case 5://标签关系
                $returnArr = $this->getTagRelation($parameter);
                break;
            case 6:
                $returnArr = $this->getJobList($parameter);
                break;
            case 8://获取动态列表
                $returnArr = $this->getNewsList($parameter);
                break;
            case 9://获取职位分类
                $returnArr = $this->getJobCategory($parameter);
                break;
            default:
                $returnArr = $this->getCompanyList($parameter);
                break;
        }

        json_return($returnArr);
    }

    /*
     * 获取详细数据
     */
    public function dataDetail()
    {
        $parameter = I('get.');
        $parameter['user_id'] = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $company = new CompanyLogic();
        $bool = $company->setTable($parameter['channel'], $parameter['type']);

        if ($bool) {
            switch ($parameter['type']) {
                case 1://增加点击次数
                    $this->addClickCount($parameter['channel'], $parameter['type'], $parameter['data_id']);
                    $info = $company->getCompanyDetail($parameter);
                    break;
                case 6:
                    $info = $company->getCompanyJobDetail($parameter);
                    break;
                default:
                    break;
            }
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => null);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     * 添加频道主表
     */
    public function add()
    {
        $parameter = I('get.');
        $channel = $parameter['channel'];
        $type = $parameter['type'];
        $data = I('post.');
        switch ($type) {
            case 1:
                break;
            case 5://关联标签
                $returnArr = $this->addRelationTag($channel, $type, $data);
                break;
            case 6:
                $returnArr = $this->addJob($channel, $type, $data);
                break;
            case 8://获取动态列表
                $returnArr = $this->addNews($channel, $type, $data);
                break;
            case 9://获取职位分类
                break;
            default:
                break;
        }
        json_return($returnArr);
    }


    private function addRelationTag($channel, $type, $data)
    {
        if (session('company_account')) {
            $account = session('company_account');
            $dataId = $account['data_id'];
            $channelId = M('SystemChannel')->where("call_index='" . $channel . "'")->getField('id');
            $ids = explode(',', $data['tag_ids']);
            $i = 0;
            foreach ($ids as $tagId) {
                $relationData[$i]['channel_id'] = $channelId;
                $relationData[$i]['data_id'] = $dataId;
                $relationData[$i]['tag_id'] = $tagId;
                $relationData[$i]['status'] = 0;
                $relationData[$i]['create_time'] = date("Y-m-d H:i:s", time());
                $i++;
            }

            $logic = new CompanyLogic();
            $logic->setTable($channel, $type);
            //先删除原来
            $logic->deleteDataByDataId($dataId);

            $info = $logic->addAllData($relationData);
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "保存标签成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "保存标签失败", "code" => 402, "data" => null);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "请先登录企业用户，再进行操作", "code" => 666, "data" => null);
        }

        return $returnArr;
    }

    /*
     * 添加子表数据
     */
    private function addData($channel, $type, $data)
    {
        $DAO = new CompanyLogic();
        $bool = $DAO->setTable($channel, $type);
        if ($bool) {
            //获取channel_id
            $where['call_index'] = $channel;
            $channelInfo = M('SystemChannel')->where($where)->find();
            $data['channel_id'] = $channelInfo['id'];
            //添加用户信息
            $account = session('company_account');
            $data['data_id'] = $account['data_id'];
            $data["create_user_id"] = $account['user_id'];
            $data["create_user"] = $account['user_name'];
            $data["create_time"] = date("Y-m-d H:i:s", time());
            $data['is_delete'] = 0;
            $flag = $DAO->addData($data);
            return $flag;
        } else {
            return false;
        }
    }

    /*
     * 添加动态
     */
    private function addNews($channel, $type, $data)
    {
        //保存图片
        $data = $this->saveImage($data);
        $info = $this->addData($channel, $type, $data);
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => null);
        }
        return $returnArr;
    }

    /*
    * 发布职位
    */
    public function addJob($channel, $type, $data)
    {
        $info = $this->addData($channel, $type, $data);
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => null);
        }
        return $returnArr;
    }

    /*
     * 点赞
     */
    public function like()
    {
        $parameter = I('get.');
        $channel = $parameter['channel'];  //操作参数
        $type = $parameter['type'];
        $parameter['zan_user_id'] = $_SESSION["userArr"]["user_id"];
        $parameter['zan_user_name'] = $_SESSION["userArr"]["mobile"];
        $parameter['zan_user_nickname'] = $_SESSION["userArr"]["nickname"];
        $parameter['zan_time'] = date("Y - m - d H:i:s", time());

        $company = new CompanyLogic();
        $bool = $company->setTable($channel, $type);
        $isLike = M("SystemChannel")->where("call_index='$channel'")->getField("is_like");
        if ($isLike) {
            if ($bool) {
                //封装点赞用户信息与所点赞的文章
                $info = $company->likes($parameter);
                $newsTable = M("SystemChannelTableConfig")
                    ->where("channel = '$channel' AND type = '$type'")
                    ->getField("table_format");
                M($newsTable)->where("id = '{$parameter['news_id']}'")->setField("likes", $info[1]);
                if ($info[0]) {
                    $returnArr = array("result" => 1, "msg" => "点赞成功", "code" => 200, "data" => $info[1]);
                } else {
                    $returnArr = array("result" => -1, "msg" => "取消成功", "code" => 200, "data" => $info[1]);
                }
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "未开启点赞", "code" => 400);
        }
        json_return($returnArr);
    }

    /*
     * 收藏
     */
    public function favourite()
    {

        $parameter = I('get.');
        $where['is_deleted'] = 0;
        $where['channel'] = $parameter['channel'];
        $where['data_id'] = $parameter['data_id'];
        $accountId = M('ManageCompanyAccounts')->where($where)->getField('id');
        //被关注的的用户
        $userParameter = array(
            'action' => 'relation',
            "data_id" => $accountId
        );
        R("UserRe/index", array($userParameter));

    }

    /*
     * 获取职位分类
     */
    private function getJobCategory()
    {
        $parameter = I('get.');
        $channel = $parameter['channel'];  //操作参数
        $type = $parameter['type'];
        $parameter['user_id'] = $_SESSION["userArr"]["user_id"];  //自身的用户id
        $companyLogic = new CompanyLogic();
        $bool = $companyLogic->setTable($channel, $type);
        if ($bool) {
            $info = $companyLogic->getRecruitList($parameter);
            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => null);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
        }
        return $returnArr;
    }


    //获取企业列表
    private function getCompanyList($parameter)
    {
        $companyLogic = new CompanyLogic();
        if ($parameter['channel']) {
            $bool = $companyLogic->setTable($parameter['channel'], $parameter['type']);
            if ($bool) {
              
                $info = $companyLogic->getCompanyList($parameter);
                if ($info) {
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                } else {
                    $returnArr = array("result" => 0, "msg" => "没有数据或该用户不存在，否则为栏目不存在", "code" => 402);
                }
            } else {
                $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 401);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "服务器繁忙，请稍后再试", "code" => 400);
        }
        return $returnArr;
    }

    /*
   * 获取标签列表
   * */
    private function getTagList($parameter)
    {
        //获取操作的子表
        $tableName = $this->getTableName($parameter['channel'], $parameter['type']);
        $where['call_index'] = $parameter['channel'];
        $channelInfo = M('SystemChannel')->where($where)->find();
        $companyLogic = new CompanyLogic();
        $result = $companyLogic->getTagList($channelInfo['id'], $tableName);
        if ($result) {
            $returnArr = array("result" => 1, "msg" => "获取数据列表成功", "code" => 200, "data" => $result);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有找到数据", "code" => 402, "data" => null);
        }

        return $returnArr;
    }

    private function getTagRelation($param)
    {
        //获取操作的子表
        if (session('company_account')) {
            $companyLogic = new CompanyLogic();
            $dataId = session('company_account')['data_id'];
            $info = $companyLogic->getTagRelation($param['channel'], $dataId);

            if ($info) {
                $returnArr = array("result" => 1, "msg" => "获取数据列表成功", "code" => 200, "data" => $info);
            } else {
                $returnArr = array("result" => 0, "msg" => "没有找到数据", "code" => 402, "data" => null);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "请先登录企业账号，再操作", "code" => 666, "data" => null);
        }


        return $returnArr;
    }

    /*
     * 获取企业新闻列表
     */
    private function getNewsList($parameter)
    {
        //获取操作的子表
        $tableName = $this->getTableName($parameter['channel'], $parameter['type']);
        $companyLogic = new CompanyLogic();
        $result = $companyLogic->getNewsList($parameter, $tableName, $_SESSION["userArr"]["user_id"]);
        if ($result) {
            $returnArr = array("result" => 1, "msg" => "获取数据列表成功", "code" => 200, "data" => $result);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有找到数据", "code" => 402, "data" => null);
        }
        return $returnArr;
    }

    /*
     * 获取企业招聘职位
     */
    private function getJobList($parameter)
    {
        $companyLogic = new CompanyLogic();
        $tableName = $this->getTableName($parameter['channel'], $parameter['type']);
        $info = $companyLogic->getJobList($parameter, $tableName);
        if ($info) {
            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
        } else {
            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => null);
        }
        return $returnArr;
    }

    /*
    * 企业用户登录
    */
    public function login()
    {
        $account = $_POST['account'];
        $pw = $_POST['password'];
        $channel = $_GET['channel'];
        if ($account && $pw) {
            $where['is_lock'] = 0;
            $where['user_name'] = $account;
            $where['password'] = encrypt($pw);
            $account = M('ManageUsers')->where($where)->find();
            if ($account) {
                //判断用户是否绑定了企业信息
                $channelId = M('SystemChannel')->where("call_index='" . $channel . "'")->getField('id');
                $where['channel_id'] = $channelId;
                $where['user_id'] = $account['user_id'];
                $count = M('SystemRelation')->where($where)->count();
                if ($count < 1) {
                    $returnArr = array("result" => 0, "msg" => "请使用企业账号登录!", "code" => 401, "data" => null);
                } else {
                    $dataId = M('SystemRelation')->where($where)->getField('data_id');
                    // session('userArr',null);
                    $account['channel'] = $channel;
                    $account['data_id'] = $dataId;
                    unset($account['password']);
                    session('company_account', $account);
                    cookie('company_account', $account['user_name']);
                    if ($account['status'] != -1) {
                        $returnArr = array("result" => 1, "msg" => "登录成功!", "code" => 401, "data" => null);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "您的账号已停用，请联系管理员!", "code" => 200, "data" => null);
                    }
                }
            } else {
                $returnArr = array("result" => 0, "msg" => "用户名/密码错误!", "code" => 401, "data" => null);
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "账号/密码为空!", "code" => 400, "data" => null);
        }
        json_return($returnArr);
    }

    /*
   * 登录后获取用户信息
   */
    public function account_info()
    {
        $account = session('company_account');
        $account = session('company_account');
        if ($account) {
            $action = $_GET['action'];
            $companyDAO = new CompanyLogic();
            switch ($action) {
                case 'detail':
                    $relation = M("SystemRelation")->where('user_id=' . $account['user_id'])->find();
                    #ch
                    $companyDAO->setTable($relation['channel_index'], 1);
                    $data = $companyDAO->detail($relation['data_id']);
                    if ($data) {
                        $data = array_merge($data, $account);
                        $returnArr = array("result" => 1, "msg" => "获取数据成功!", "code" => 200, "data" => $data);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "获取数据失败!", "code" => 401, "data" => null);
                    }
                    break;
                case 'update_pw':
                    $oldPw = encrypt($_POST['old_pw']);
                    $newPw = $_POST['new_pw'];
                    $rePw = $_POST['re_pw'];
                    $where['user_id'] = $account['user_id'];
                    $password = M('ManageUsers')->where($where)->getField('password');
                    if ($oldPw != $password) {
                        $returnArr = array("result" => 0, "msg" => "旧密码错误,请检查!", "code" => 410, "data" => null);
                        json_return($returnArr);
                    }
                    if (!$this->checkPassword($newPw, $rePw)) {
                        $returnArr = array("result" => 0, "msg" => "两次密码不一致,请检查!", "code" => 411, "data" => null);
                        json_return($returnArr);
                    }
                    //修改频道表数据
                    $password = encrypt($newPw);

                    //修改企业用户表密码
                    $flag = M('ManageUsers')->where($where)->setField('password', $password);
                    if ($flag === false) {
                        $returnArr = array("result" => 0, "msg" => "修改密码出错!", "code" => 405, "data" => null);
                    } else {
                        $returnArr = array("result" => 1, "msg" => "修改密码成功!", "code" => 200, "data" => null);
                    }
                    break;

                case 'edit':
                    $data = I('post.');
                    $channel = $data['channel'];
                    unset($data['channel']);
                    unset($data['__hash__']);
                    $data =  array_filter($data);
                    if ($channel) {
                        //保存图片
                        $data = $this->saveImage($data);
                        $id = $_GET['id'];
                        $flag = $this->updateChannelData($channel, $id, $data);
                        if ($flag === false) {
                            $returnArr = array("result" => 0, "msg" => "修改企业信息失败", "code" => 403);
                        } else {
                            $returnArr = array("result" => 1, "msg" => "修改企业信息成功", "code" => 200, "data" => $id);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "请求错误，缺少频道参数!", "code" => 401);
                    }
                    break;
                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
                    break;
            }
        } else {
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登录!", "code" => 666, "data" => null);
        }
        json_return($returnArr);
    }

    /*
     * 注册
     */
    public function register()
    {

        $action = $_GET['action'];
        $companyDAO = new CompanyLogic();
        switch ($action) {
            case 'check':
                if ($_POST['account']) {
                    $flag = $this->checkAccount($_POST['account']);
                    $returnArr = array("result" => 1, "msg" => "请求成功", "code" => 200, "data" => $flag);

                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少参数!", "code" => 402, "data" => null);
                }
                break;
            case 'add':
                $data = I('post.');
                $channel = $data['channel'];
                unset($data['channel']);
                if ($channel) {
                    //检查是否重名
                    $flag = $this->checkAccount($_POST['account']);
                    if ($flag === 1) {
                        $returnArr = array("result" => 0, "msg" => "该账号已被使用", "code" => 405);
                        json_return($returnArr);
                    }
                    //检查密码
                    $flag = $this->checkPassword($_POST['company_pw'], $_POST['company_pw_cf']);
                    if (!$flag) {
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
                    if ($id) {
                        $flag = $this->saveAccount($id, $channel, $data);
                        if ($flag) {
                            cookie('company_account', $data['account']);
                            $returnArr = array("result" => 1, "msg" => "创建用户成功", "code" => 200, "data" => $id);
                        } else {
                            //删掉公司表的数据
                            $companyDAO->delete($id);
                            $returnArr = array("result" => 0, "msg" => "新增用户失败", "code" => 404);
                        }
                    } else {
                        $returnArr = array("result" => 0, "msg" => "新增用户失败", "code" => 403);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "请求错误，缺少频道参数!", "code" => 401);
                }
                break;
            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
                break;
        }
        json_return($returnArr);
    }

    /*
     * 重置密码
     */
    public function reset()
    {
        $action = $_GET['action'];
        $channel = $_GET['channel'];
        switch ($action) {
            case 'send_code':
                $where['user_name'] = $_POST['account'];
                $where['is_lock'] = 0;
                $account = M('ManageUsers')->where($where)->find();

                if ($account) {
                    $conf['user_id'] = $account['user_id'];
                    $conf['channel'] = $channel;
                    $relation = M("SystemRelation")->where($conf)->find();
                    if (!$relation) {
                        $returnArr = array("result" => 0, "msg" => "该账号[" . $_POST['account'] . "]不是企业账号,请检查", "code" => 401, "data" => null);
                        json_return($returnArr);
                    } else {
                        $account = array_merge($account, $relation);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "没有找到账号[" . $_POST['account'] . "],请检查", "code" => 401, "data" => null);
                    json_return($returnArr);
                }

                //检查发送次数(每天三次)
                $conf = "user_id=" . $account['user_id'] . " AND TO_DAYS(create_time) = TO_DAYS(NOW())";
                $count = M('ManageValidCode')->where($conf)->count();
                if ($count >= 3) {
                    $returnArr = array("result" => 0, "msg" => "重置码发送已超过当天限制(每天3次)", "code" => 401, "data" => null);
                    json_return($returnArr);
                }

                $companyTable = $this->getTableName($channel, 1);
                $where = array();
                $where['id'] = $account['data_id'];
                $company = M("$companyTable")->where($where)->find();
                $email = $company['email'];
                if (!$email) {
                    $returnArr = array("result" => 0, "msg" => "账号[" . $_POST['account'] . "]没有邮箱,不能更改密码", "code" => 401, "data" => null);
                    json_return($returnArr);
                }

                $resetCode = get_rand_str(6, 0, 0);
                $title = "您正在重置密码";
                $content = "您的重置码为: " . $resetCode . " , 重置码30分钟内有效，请尽快更改密码!";

                try {
                    //发送邮件
                    send_email_asyn($email, $title, $content);
                    //记录发送码
                    $data['code'] = $resetCode;
                    $data['type'] = 1;//1为邮件
                    $data['is_used'] = 0;
                    $data['user_id'] = $account['user_id'];
                    $data['create_time'] = date('Y-m-d H:i:s', time());
                    M('ManageValidCode')->add($data);

                    $this->logRecord(6, "邮件发送重置码[" . $resetCode . "]成功", 7, $company['channel_id'], $company['id']);
                    $flag = true;
                } catch (\Exception $e) {
                    $this->logRecord(4, "邮件发送重置码[" . $resetCode . "]失败", 7, $company['channel_id'], $company['id']);
                    $flag = false;
                }

                if ($flag) {
                    $returnArr = array("result" => 1, "msg" => "已经发送邮件，请查收重置码，更改密码", "code" => 200);
                } else {
                    $returnArr = array("result" => 0, "msg" => "发送邮件失败!", "code" => 401);
                }

                break;

            case 'update':
                $channelInfo = M('SystemChannel')->where("call_index='" . $channel . "'")->find();
                //获取客户信息
                $where['user_name'] = $_POST['account'];
                $where['is_lock'] = 0;
                $account = M('ManageUsers')->where($where)->find();

                if ($account) {
                    $conf['user_id'] = $account['user_id'];
                    $conf['channel'] = $channel;
                    $relation = M("SystemRelation")->where($conf)->find();
                    if (!$relation) {
                        $returnArr = array("result" => 0, "msg" => "该账号[" . $_POST['account'] . "]不是企业账号,请检查", "code" => 401, "data" => null);
                        json_return($returnArr);
                    } else {
                        $account = array_merge($account, $relation);
                    }
                } else {
                    $returnArr = array("result" => 0, "msg" => "没有找到账号[" . $_POST['account'] . "],请检查", "code" => 401, "data" => null);
                    json_return($returnArr);
                }

                //检验重置码
                $status = $this->checkResetCode($_POST['reset_code'], $account['user_id']);
                if ($status != 1) {
                    $returnArr = array("result" => 0, "msg" => "重置码出错,请检查", "code" => 403, "data" => $status);
                    json_return($returnArr);
                }
                //将当前用户所有重置码置为已使用
                $conf['user_id'] = $account['user_id'];
                $conf['code'] = $_POST['reset_code'];
                M('ManageValidCode')->where($conf)->setField('is_used', 1);

                //检验密码
                $pw1 = $_POST['new_pw'];
                $pw2 = $_POST['re_pw'];
                $flag = $this->checkPassword($pw1, $pw2);
                if (!$flag) {
                    $returnArr = array("result" => 0, "msg" => "校验新密码出错,请检查", "code" => 404, "data" => null);
                    json_return($returnArr);
                }

                //更改account密码
                $password = encrypt($pw1);
                $flag = M('ManageUsers')->where('user_id=' . $account['user_id'])->setField('password', $password);
                if ($flag === false) {
                    $returnArr = array("result" => 0, "msg" => "修改密码失败", "code" => 405, "data" => null);
                    $this->logRecord(4, "重置密码失败", 7, $channelInfo['id'], $account['data_id']);
                } else {
                    $returnArr = array("result" => 1, "msg" => "修改密码成功", "code" => 200, "data" => null);
                    $this->logRecord(6, "重置密码成功", 7, $channelInfo['id'], $account['data_id']);

                }

                break;

            default:
                $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
                break;
        }

        json_return($returnArr);

    }

    /*
     * 校验重置码
     */
    private function checkResetCode($resetCode, $userId)
    {
        if (empty($resetCode)) {
            return -1;//重置码空
        }
        $DAO = M('ManageValidCode');
        //检查是否相等(跟当前用户最新重置码[未使用]校验)
        $where['user_id'] = $userId;
        $where['is_used'] = 0;

        $newResetCode = $DAO->where($where)->order('create_time DESC')->find();
        if ($newResetCode == null || $resetCode !== $newResetCode['code']) {
            return -2;//重置码错误
        }

        //检查是否超时
        $new = date("Y-m-d H:i:s", time());
        $resetCodeTime = $newResetCode['create_time'];

        $minute = floor((strtotime($new) - strtotime($resetCodeTime)) % 86400 / 60);
        if ($minute > 30) {
            return -3; //已失效
        }

        return 1;
    }


    public function fans()
    {
        $account = session('account');
        if ($account) {
            $action = $_GET['action'];
            $model = M('ManageUsersRelation');
            switch ($action) {
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

                    if ($data) {
                        $returnArr = array("result" => 1, "msg" => "获取数据成功!", "code" => 200, "data" => $data);
                    } else {
                        $returnArr = array("result" => 0, "msg" => "获取数据失败!", "code" => 401, "data" => null);
                    }
                    break;


                default:
                    $returnArr = array("result" => 0, "msg" => "请求错误，参数错误!", "code" => 401, "data" => null);
                    break;
            }


        } else {
            $returnArr = array("result" => 0, "msg" => "请求错误，请先登录!", "code" => -1, "data" => null);
        }

        json_return($returnArr);

    }

    private function saveImage($data)
    {
        foreach ($data as $key => $value) {
            if (strpos($value, 'data:image') !== false) {
                $base64Image = $value;
                $site = get_site_name();
                $imgDiv = UPLOAD_PATH . $site . '/image/' . date('Ymd', time()) . '/';

                $imgPath = Image::base64ToFile($base64Image, $imgDiv, $key);
                $data[$key] = $imgPath;
            }
        }
        return $data;
    }

    /*
     * 检查账号
     */
    private function checkAccount($account)
    {
        $where['user_name'] = $account;
        $where['is_lock'] = 0;
        $count = M('ManageUsers')->where($where)->count();
        $flag = 0;
        if ($count > 0) {
            $flag = 1;
        }
        return $flag;
    }

    /*
     * 插入频道数据
     */
    private function saveChannelData($channelIndex, $data)
    {


        $channel = M('SystemChannel')->where("call_index='" . $channelIndex . "'")->find();
        $data['channel_id'] = $channel['id'];
        if (is_null($data['logo_img'])) {
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
    private function updateChannelData($channel, $id, $data)
    {

        $data["update_user_id"] = session('account')["id"];
        $data["update_time"] = date("Y-m-d H:i:s", time());
        $data['is_delete'] = 0;

        $table = getChannelTable($channel, 1)['table_format'];
        $flag = M($table)->where('id=' . $id)->save($data);
        return $flag;
    }

    /*
     * 递归函数
     */
    public function diff($id = 0, &$array = array())
    {
        $info = M("ArticleCategory")->where("id = $id")->find();
        if ($info) {
            $array[] = $info;
            $this->diff($info["parent_id"], $array);
        }
        return $array;
    }

    /*
     * 检查密码
     */
    private function checkPassword($pw1, $pw2)
    {
        if ($pw1 && $pw2 && $pw1 === $pw2) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 保存企业的时候保存用户
     * **/
    private function saveAccount($id, $channel, $data)
    {
        $account['user_name'] = $data['account'];
        $account['password'] = $data['company_pw'];;
        $account['nickname'] = $data['title'];
        $account['mobile'] = $data['mobile'];
        $account['email'] = $data['email'];
        $account['create_time'] = date('Y-m-d H:i:s', time());
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

//    //具体详情
//    public function company_recruit(){
//        $parameter = I('get.');
//        $channel = $parameter['channel'];  //操作参数
//        $type = $parameter['type'];
//
//        $account = session('company_account');
//        $parameter['data_id'] = $account['data_id'];
//
//        $company = new CompanyLogic();
//        $bool = $company->setTable($channel, $type);
//
//        if ($bool) {
//            if($parameter['parent_id'] && $parameter['second_level_id']){
//                $info = $company->getRecruitLevelList($parameter);
//            }else{
//                $tableName = $this->getTableName($channel, $type);
//                $info = $company->recruitList($parameter, $tableName);
//            }
//            if ($info) {
//                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
//            } else {
//                $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 402, "data" => null);
//            }
//        } else {
//            $returnArr = array("result" => 0, "msg" => "系统繁忙，请稍后再试", "code" => 400);
//        }
//        json_return($returnArr);
//    }
}
