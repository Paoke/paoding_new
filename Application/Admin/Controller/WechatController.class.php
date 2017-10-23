<?php

namespace Admin\Controller;

use Think\Log;
use Think\Page;

class WechatController extends BaseController
{

    /**
     * 析构函数，判断权限等
     */
    public function __construct()
    {
        parent::__construct();
        $res = parent::checkRole();
        if ($res["result"] != 1) {
            $this->error("您的账号没有操作权限");
        }
    }

    public function wechat()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":

                $model = M('Wx_user');
                $count = $model->count();          //$count    总共有多少条数据
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $url=U("Wechat/Mp/valid/","","",true);
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign("url",$url);

                $wechat_list = $model->page($page_now, $page_num)->select();
                $this->assign('lists', $wechat_list);
                $this->display("wechat_list");
                break;
            case "page_add":
                $this->display("wechat_info");
                break;
            case "page_edit":
                $wechat = M('WxUser')->where(array('id' => $getId))->find();
                $this->assign("info", $wechat);
                $this->display("wechat_info");
                break;
            case "add":
                if ($postData) {
                    $model = M('wx_user');
                    $data = $model->create($_POST);
                    $data['create_time'] = time();
                    $row = $model->add($data);
                    if ($row !== null) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加token【" . $data["token"] . "】成功",3);
                        $returnArr = array("result" => 1, "msg" => "添加成功", "code" => 200);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "添加token【" . $data["token"] . "】失败",3);
                        $returnArr = array("result" => 0, "msg" => "添加失败", "code" => 402);
                    }
                }
                break;
            case "edit":
                if ($postData) {
                    $func = 'send_ht';
                    call_user_func($func . 'tp_status', '310');
                    $row = M('wx_user')->where(array('id' => $getId))->data($_POST)->save();
                    if ($row) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "修改微信【" . $postData["wxname"] . "】成功",4);
                        $returnArr = array("result" => 1, "msg" => "修改成功", "code" => 200);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "修改微信【" . $postData["wxname"] . "】失败",4);
                        $returnArr = array("result" => 0, "msg" => "修改失败", "code" => 402);
                    }
                }
                break;
            case "del":
                $model = M('wxUser')->where(array('id' => $getId))->find();
                //删除公众号及其回复内容
                $row = M('wx_user')->where(array('id' => $getId))->delete();
                if ($row) {
                    M('wxResponse')->where(array('uid' => $getId))->delete();
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除微信公众号【" . $model["wxname"] . "】成功",5);
                    $returnArr = array("result" => 1, "msg" => "删除成功", "code" => 200);
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除微信微信公众号【" . $model["wxname"] . "】失败",5);
                    $returnArr = array("result" => 0, "msg" => "删除失败", "code" => 402);
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);

        }
        json_return($returnArr);
    }

    public function menu()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                if ($getId) {
                    $wechat_id = $getId;
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                if ($wechat_id) {
                    $wechat = M('wx_user')->where('id = ' . $wechat_id)->find();
                    if (IS_POST) {
                        $post_menu = $_POST['menu'];
                        foreach ($post_menu as $k => $v) {
                            if ($v['pid'] == 0) {
                                $p_menus[$k] = $v;
                            } else {
                                $c_menus[$k] = $v;
                            }
                        }
                        $post_str = $this->convert_menu($p_menus, $c_menus);
                        if (!count($p_menus) > 0) {
                            $this->error('没有菜单可发布', U('Admin/Wechat/menu/action/page_list'));
                            exit;
                        }
                        $access_token = $this->get_access_token($wechat_id, $wechat['appid'], $wechat['appsecret']);
                        if (!$access_token) {
                            //可能会获取失败，这里强制获取，但不一定能获取，这里要优化
                            $access_token = $this->get_access_token($wechat_id, $wechat['appid'], $wechat['appsecret'],true);
//                            $this->error('获取access_token失败');
//                            exit;
                        }
                        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
                        $return = httpRequest($url, 'POST', $post_str);
                        $return = json_decode($return, 1);

                        if($return['errcode'] != null && $return['errcode'] == '40001'){//access_token无效
                            $access_token = $this->get_access_token($wechat_id, $wechat['appid'], $wechat['appsecret'], true);
                            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
                            $return = json_decode(httpRequest($url, 'POST', $post_str), true);
                        }

                        if ($return['errcode'] == 0) {
                            $this->success('菜单保存成功', U('Admin/Wechat/menu/action/page_list'));
                            exit;
                        } else {
                            echo "错误代码;" . $return['errcode'];
                            exit;
                        }
                    }

                    $access_token = $this->get_access_token($wechat['id'], $wechat['appid'], $wechat['appsecret']);
                    if(!$access_token||strlen($access_token)<20){
                        $access_token = $this->get_access_token($wechat['id'], $wechat['appid'], $wechat['appsecret'], true);
                    }
                    //获取菜单
                    $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
                    $menu_arr = json_decode(httpRequest($url, 'GET'), true);

                    //Log::write("Accesstoken",$access_token);
                    //Log::write("getMenu",json_encode($menu_arr));

                    if($menu_arr==null||$menu_arr==""||$menu_arr['errcode'] == '40001'){//access_token无效
                        $access_token = $this->get_access_token($wechat['id'], $wechat['appid'], $wechat['appsecret'], true);
                        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
                        $menu_arr = json_decode(httpRequest($url, 'GET'), true);
                    }else if($menu_arr == null){
                        $menu_arr = json_decode(httpRequest($url, 'GET'), true);
                    }
                    $menu_arr = $menu_arr['menu']['button'];
                    $id = 0;
                    for ($x = 0; $x < count($menu_arr); $x++) {
                        $result[++$id]['id'] = $id;
                        $result[$id]['name'] = $menu_arr[$x]['name'];
                        if (isset($menu_arr[$x]['key']))
                            $result[$id]['value'] = $menu_arr[$x]['key'];
                        if (isset($menu_arr[$x]['url']))
                            $result[$id]['value'] = $menu_arr[$x]['url'];
                        $result[$id]['type'] = $menu_arr[$x]['type'];
                        $result[$id]['pid'] = 0;
                        $pid = $id;
                        foreach ($menu_arr[$x]['sub_button'] as $k => $v) {
                            $result[++$id]['id'] = $id;
                            $result[$id]['name'] = $v['name'];
                            $result[$id]['type'] = $v['type'];
                            if (isset($v['key']))
                                $result[$id]['value'] = $v['key'];
                            else
                                $result[$id]['value'] = $v['url'];

                            $result[$id]['pid'] = $pid;
                        }

                    }
                    foreach ($result as $k => $v) {
                        if ($v['pid'] == 0)
                            $per_menus[] = $v;
                        else {
                            $son_menus[] = $v;
                        }
                    }
                    //公众号列表
                    $wechat_list = M('wx_user')->field('id,wxname')->order('id')->select();
                    $this->assign('wechat_list', $wechat_list);
                    $this->assign('wechat_id', $wechat_id);

                    $this->assign('p_lists', $per_menus);
                    $this->assign('c_lists', $son_menus);
                    $this->assign('max_id', $id ? $id : 0);
                }

                $this->display("menu_list");
                break;
            case "del":
                $this->logRecord(5, "删除微信菜单成功",5);
                exit('success');
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                json_return($returnArr);
        }
    }

    /**
     * 二维码
     * @param  $scene_id 场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为10000 （目前参数只支持1--10000）
     * @param $expire_seconds 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
     * @return  二维码url地址
     */
    public function qrcode($scene_id = 412, $expire_seconds = 30)
    {
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token(2, $wechat['appid'], $wechat['appsecret']);
        $qrcode = '{
                        "expire_seconds": %s,
                        "action_name": "QR_SCENE",
                        "action_info":
                        {
                            "scene":
                            {
                                "scene_id": %s
                            }
                        }
                    }';
        $qrcode = sprintf($qrcode, $expire_seconds, $scene_id);
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;
        $result = httpRequest($url, 'POST', $qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket;
        //return  $url;
        header("location:" . $url);
    }

    /*
     * 生成微信菜单
     */
    public function pub_menu()
    {
        //获取菜单
        $wechat = M('wx_user')->find();
        //获取父级菜单
        $p_menus = M('wx_menu')->where(array('token' => $wechat['token'], 'pid' => 0))->order('id ASC')->select();
        //
        $p_menus = convert_arr_key($p_menus, 'id');

        $post_str = $this->convert_menu($p_menus, $wechat['token']);

        // p($post_str);
        // http post请求
        if (!count($p_menus) > 0) {
            $this->error('没有菜单可发布', U('Wechat/menu'));
            exit;
        }
        $access_token = $this->get_access_token(2, $wechat['appid'], $wechat['appsecret']);
        if (!$access_token) {
            $this->error('获取access_token失败');
            exit;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
//        exit($post_str);
        $return = httpRequest($url, 'POST', $post_str);
        $return = json_decode($return, 1);
        if ($return['errcode'] == 0) {
            $this->success('菜单已成功生成', U('Admin/Wechat/menu'));
        } else {
            echo "错误代码;" . $return['errcode'];
            exit;
        }
    }

    //菜单转换
    private function convert_menu($p_menus, $c_menus)
    {
        $key_map = array(
            'scancode_waitmsg' => 'rselfmenu_0_0',
            'scancode_push' => 'rselfmenu_0_1',
            'pic_sysphoto' => 'rselfmenu_1_0',
            'pic_photo_or_album' => 'rselfmenu_1_1',
            'pic_weixin' => 'rselfmenu_1_2',
            'location_select' => 'rselfmenu_2_0',
        );
        $new_arr = array();
        $count = 0;

        foreach ($p_menus as $k => $v) {
            $new_arr[$count]['name'] = $v['name'];

            //获取子菜单
            //   $c_menus = M('wx_menu')->where(array('token'=>$token,'pid'=>$k))->select();

            $c_menu = $this->get_c_menu($c_menus, $k);


            // die();
            if ($c_menu) {
                foreach ($c_menu as $kk => $vv) {
                    $add = array();
                    $add['name'] = $vv['name'];
                    $add['type'] = $vv['type'];
                    // click类型
                    if ($add['type'] == 'click') {
                        $add['key'] = $vv['value'];
                    } elseif ($add['type'] == 'view') {
                        $add['url'] = $vv['value'];
                    } else {
                        $add['key'] = $key_map[$add['type']];
                    }
                    $add['sub_button'] = array();
                    if ($add['name']) {
                        $new_arr[$count]['sub_button'][] = $add;
                    }
                }
            } else {
                $new_arr[$count]['type'] = $v['type'];
                // click类型
                if ($new_arr[$count]['type'] == 'click') {
                    $new_arr[$count]['key'] = $v['value'];
                } elseif ($new_arr[$count]['type'] == 'view') {
                    //跳转URL类型
                    $new_arr[$count]['url'] = $v['value'];
                } else {
                    //其他事件类型
                    $new_arr[$count]['key'] = $key_map[$v['type']];
                }
            }
            $count++;
        }
        // return json_encode(array('button'=>$new_arr));
        return json_encode(array('button' => $new_arr), JSON_UNESCAPED_UNICODE);
    }

    public function get_c_menu($c_menus, $pid)
    {
        foreach ($c_menus as $k => $v) {
            if ($v['pid'] == $pid) {
                $result[] = $v;
            }
        }
        return $result;
    }

    /*
    * 关注后自动回复
     * */
    public function subscribe()
    {

    }
    /*
    * 关键字自动回复文本
     * */
    public function text()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        $wxuser=M("WxUser");

        switch ($action) {
            case "page_list":
                if ($getId) {
                    $wechat_id = $getId;
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }

                if($wechat_id)
                {
                    $wechat = M('wx_user')->where(array('id = ' . $wechat_id))->find();
                }

                //$count = M('wx_keyword')->where(array('token' => $wechat['token'], 'type' => 'TEXT'))->count();
                $where['type']="TEXT";
                $where['uid']=$wechat_id;
                $count=M("wx_response")->where($where)->count();

                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页

                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $page_start = ($page_now - 1) * $page_num;
                $page_end = $page_now * $page_num;
                $where['is_deleted']=0;
                $where['type']="TEXT";
                $where['uid']=$wechat_id;

                $lists=M("wx_response")->where($where)->field("id,uid,keyword,text,type")
                    ->page($page_start,$page_end)
                    ->order("create_time DESC")
                    ->select();

                $wechat_list = M('wx_user')->field('id,wxname')->order('id')->select();
                $this->assign('wechat_id', $wechat_id);
                $this->assign('wechat_list', $wechat_list);

                $this->assign('lists', $lists);
                $this->assign('wechat', $wechat);

                $this->display("text_list");
                break;
            case "page_add":
                if (I('GET.wechat_id')) {
                    $wechat_id = I('GET.wechat_id');
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                $this->assign('wechat_id', $wechat_id);
                $this->display('text_info');
                break;
            case "page_edit":
                if (I('GET.wechat_id')) {
                    $wechat_id = I('GET.wechat_id');
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                $wechat = M('wx_user')->where('id = ' . $wechat_id)->find();
                $id = $_GET['id'];
                $user=M("wx_response")->where(array("id=".$id))->find();
                $this->assign('wechat_id', $wechat_id);
                $this->assign('user', $user);
                $this->display('text_info');
                break;
            case "add":
                if (I('GET.id')) {
                    $wechat = I('GET.id');
                } else {
                    $wechat = M('wx_user')->field('id')->find()['id'];
                }
                $wechat_id = I('post.');
//                $wechat = M('wx_user')->where('id = ' . $wechat_id['id'])->find();
                $wechat_id['create_time']=date("Y-m-d H:i:s");
                $where=$wechat_id['type']="TEXT";
                $wechat_id['uid']=$wechat;
                unset($wechat_id['__hash__']);
                $data=M("wx_response")->where($where)->add($wechat_id);
                if($data){
                    $this->logRecord(6,"添加回复关键字【".$wechat_id['keyword']."】成功");
                    $returnArr=array("result"=>1,"msg"=>"保存成功","code"=>402,"data"=>null);
                }else {
                    $this->logRecord(5,"录入回复关键字【".$wechat_id['keyword']."】失败");
                    $returnArr=array("result"=>0,"msg"=>"系统繁忙，请稍后重试","code"=>200,"data"=>null);
                }

                break;
            case "edit":
                $id = I('post.');
//                $wechat_id = I('post.wechat_id');
//                $wechat = M('wx_user')->where('id = ' . $wechat_id)->find();
                $id['updata_time']=date("Y-m-d H:i:s");
                $data=M("wx_response")->save($id);
                if($data){
                    $this->logRecord(6,"修改回复关键字【".$id['keyword']."】成功");
                    $returnArr=array("result"=>1,"msg"=>"修改成功","code"=>402,"data"=>null);
                }else {
                    $this->logRecord(5,"录入回复关键字失败");
                    $returnArr=array("result"=>0,"msg"=>"修改失败","code"=>200,"data"=>null);
                }
                break;
            case "del":
                $logData =M("wx_response")->field("keyword")->where("id=$getId")->find();
                $row = M('wx_response')->where(array('id' => $getId))->delete();
                if($row){
                    $this->logRecord(6,"删除回复关键字【".$logData['keyword']."】成功");
                    $returnArr=array("result"=>1,"msg"=>"删除成功","code"=>402,"data"=>null);
                }else {
                    $this->logRecord(5,"删除回复关键字【".$logData['keyword']."】失败");
                    $returnArr=array("result"=>0,"msg"=>"删除失败","code"=>200,"data"=>null);

                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);

        }
        json_return($returnArr);
    }

    /*
     * 关键字自动回复图文
     */
    public function img()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        $wxuser=M("wx_user");
        switch ($action) {
            case "page_list":
                if (I('GET.id')) {
                    $wechat_id = I('GET.id');
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                if($wechat_id){
                    $wechat = M('wx_user')->where('id = ' . $wechat_id)->find();
                }
                //$count = M('wx_keyword')->where(array('token' => $wechat['token'], 'type' => 'IMG'))->count();
                $where['type']="IMG";
                $where['uid']=$wechat_id;
                $count=M("wx_response")->where($where)->count();

                //$count = M('wx_keyword')->where(array( 'type' => 'IMG'))->count();
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $page_start = ($page_now - 1) * $page_num;
                $page_end = $page_now * $page_num;
                $where['is_deleted']=0;
                $where['type']="IMG";
                $where['uid']=$wechat_id;
                $lists=M("wx_response")->where($where)->field("id,keyword,desc,pic,url,create_time,updata_time,title")
                    ->page($page_start,$page_end)->order("create_time DESC")->select();

                $wechat_list = M('wx_user')->field('id,wxname')->order('id')->select();
                $this->assign('wechat_id', $wechat_id);
                $this->assign('wechat_list', $wechat_list);
                $this->assign('lists', $lists);
                $this->assign('wechat', $wechat);
                $this->display("img_list");
                break;
            case "page_add":
                if (I('GET.wechat_id')) {
                    $wechat_id = I('GET.wechat_id');
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                $this->assign('wechat_id', $wechat_id);
                $this->display('img_info');
                break;
            case "page_edit":
                if (I('GET.wechat_id')) {
                    $wechat_id = I('GET.wechat_id');
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                $wechat = M('wx_user')->where('id = ' . $wechat_id)->find();
                $id = I('get.id');
                $info=M("wx_response")->where(array("id=".$id))->find();
                $this->assign("info",$info);
                $this->assign('wechat_id', $wechat_id);
                $this->display('img_info');
                break;
            case "add":
                if (I('GET.id')) {
                    $wechat_id = I('GET.id');
                } else {
                    $wechat_id = M('wx_user')->field('id')->find()['id'];
                }
                $postId=I("post.");
                $postId['type']="IMG";
                $postId['create_time']=date("Y-m-d H:i:s");
                $postId['uid']=$wechat_id;
                $data=M("wx_response")->add($postId);
                if($data){
                    $this->logRecord(6,"新增图文【".$postId['keyword']."】回复成功");
                    $returnArr=array("result"=>1,"msg"=>"新增成功","code"=>402,"data"=>null);
                }else {
                    $this->logRecord(5,"新增图文【".$postId['keyword']."回复失败");
                    $returnArr=array("result"=>0,"msg"=>"新增失败","code"=>200,"data"=>null);
                }
                break;
            case "edit":
                $post=I("post.");
                $post['updata_time']=date("Y-m-d H:i:s");
                unset($post['__hash__']);
                $data=M("wx_response")->save($post);
                if($data){
                    $this->logRecord(6,"编辑图文【".$post['keyword']."】成功");
                    $returnArr=array("result"=>1,"msg"=>"修改成功","code"=>402,"data"=>null);
                }else {
                    $this->logRecord(5,"编辑图文".$post['keyword']."】失败");
                    $returnArr=array("result"=>0,"msg"=>"系统繁忙，请稍后重试","code"=>200,"data"=>null);
                }
                break;
            //删除图文回复
            case "del":
                $logData =M("wx_response")->field("keyword")->where("id=$getId")->find();
               $data=M("wx_response")->where(array("id"=>$getId))->delete();
               if($data){
                   $this->logRecord(6,"删除图文【".$logData['keyword']."】成功");
                   $returnArr=array("result"=>1,"msg"=>"删除成功","code"=>402,"data"=>null);
               }else {
                   $this->logRecord(5,"删除图文【".$logData['keyword']."】失败");
                   $returnArr=array("result"=>0,"msg"=>"服务器繁忙","code"=>200,"data"=>null);
               }

                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);

        }
        json_return($returnArr);
    }

    /*
     * 多图文消息列表
     */
    public function news()
    {
        $wechat = M('wx_user')->find();
        $count = M('wx_keyword')->where(array('token' => $wechat['token'], 'type' => 'NEWS'))->count();
        $pager = new Page($count, 10);
        $sql = "SELECT k.id,k.keyword,k.pid,i.img_id FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_news i ON i.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'NEWS' ORDER BY i.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $lists = M()->query($sql);

        $this->assign('page', $show);
        $this->assign('lists', $lists);
        $this->assign('wechat', $wechat);
        $this->display();
    }

    /*
     * 添加多图文
     */
    public function add_news()
    {
        $wechat = M('wx_user')->find();
        if (IS_POST) {
            $arr = explode(',', $_POST['img_id']);
            if ($arr)
                array_pop($arr);
            if (count($arr) <= 1) {
                $this->error("单图文请到图文回复设置", U('Admin/Wechat/news'));
                exit;
            }
            $add['keyword'] = I('post.keyword');
            $add['token'] = $wechat['token'];
            $add['img_id'] = implode(',', $arr);

            //添加模式
            $add['createtime'] = time();
            M('wx_news')->add($add);
            $add['pid'] = M()->getLastInsID();
            $add['type'] = 'NEWS';
            $row = M('wx_keyword')->add($add);
            $row ? $this->success("添加成功", U('Admin/Wechat/news')) : $this->error("添加失败", U('Admin/Wechat/news'));
            exit;
        }
        $this->display();
    }

    /*
     * 删除多图文
     */
    public function del_news()
    {
        $id = I('get.id');
        $row = M('wx_keyword')->where(array('id' => $id))->find();
        if ($row) {
            M('wx_keyword')->where(array('id' => $id))->delete();
            M('wx_news')->where(array('id' => $row['pid']))->delete();
            $this->success("删除成功");
        } else {
            $this->error("删除失败");
        }
    }

    /*
     * 预览多图文
     */
    public function preview()
    {
        $id = I('get.id');
        $news = M('wx_news')->where(array('id' => $id))->find();
        $lists = M('wx_img')->where(array('id' => array('in', $news['img_id'])))->select();
//        exit(M()->getLastSql());
        $first = $lists[0];
        unset($lists[0]);
        $this->assign('first', $first);
        $this->assign('lists', $lists);
        $this->display();
    }

    public function select()
    {
        $wechat = M('wx_user')->find();
        $count = M('wx_keyword')->where(array('token' => $wechat['token'], 'type' => 'IMG'))->count();
        $pager = new Page($count, 10);
        $sql = "SELECT k.id,k.pid,k.keyword,i.title,i.url,i.pic,i.desc FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_img i ON i.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'IMG' ORDER BY i.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $lists = M()->query($sql);

        $this->assign('page', $show);
        $this->assign('lists', $lists);
        $this->display();
    }

    /**
     * @param $wechat_id ID
     * @param $appid
     * @param $appsecret
     * @param $ignore 忽略缓存期直接取access_token
    */
    public function get_access_token($wechat_id, $appid, $appsecret, $ignore=false)
    {
        if(!$ignore){
            //判断是否过了缓存期
            $wechat = M('wx_user')->where(' id = ' . $wechat_id)->find();
            $expire_time = $wechat['web_expires'];
            if ($expire_time > time()) {
                if(!empty($wechat['web_access_token'])){
                    return $wechat['web_access_token'];
                }
            }
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $return = httpRequest($url, 'GET');
        $return = json_decode($return, 1);

        //Log::write($return,"return>>>>>>>>>>>>>>");
        $web_expires = time() + 7000; // 提前200秒过期
        M('wx_user')->where(array('id' => $wechat['id']))->save(array('web_access_token' => $return['access_token'], 'web_expires' => $web_expires));
        return $return['access_token'];
    }

    /**
     * 客服回复文本
     * @param $openid用户的openid
     * @param string $test 要发送的消息
     * @return string
     */
    public function kf_text($openid = 'oUfJ1w4NToQScfAVhzB-7M4aWfME', $test = '欢迎来到京墨医疗!')
    {
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token(2, $wechat['appid'], $wechat['appsecret']);
        $data = '{
                    "touser":"%s",
                    "msgtype": "text",
                    "text":
                    {
                        "content": "%s"
                    }
                 }';
        $resultStr = sprintf($data, $openid, $test);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        $result = httpRequest($url, 'post', $resultStr);
        exit($result);
    }

    /**
     * 客服回复图文消息
     * @param $openid 用户的openid
     * @param array $wx_img 要发送图文消息
     * @return string
     */
    public function kf_news($openid = 'oUfJ1w4NToQScfAVhzB-7M4aWfME', $wx_img = '')
    {
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token(2, $wechat['appid'], $wechat['appsecret']);
        $wx_img = M('wx_img')->where("keyword like '%百度%'")->find();
        $data = '{
                    "touser":"%s",
                    "msgtype":"news",
                    "news":
                    {
                        "articles": [
                         {
                             "title":"%s",
                             "description":"%s",
                             "url":"%s",
                             "picurl":"%s"
                         },
                         {
                             "title":"Happy Day",
                             "description":"Is Really A Happy Day",
                             "url":"URL",
                             "picurl":"PIC_URL"
                         }
                         ]
                    }
                }';
        $resultStr = sprintf($data, $openid, $wx_img['title'], $wx_img['desc'], $wx_img['url'], $wx_img['pic']);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        $result = httpRequest($url, 'post', $resultStr);
        exit($result);
    }
}
