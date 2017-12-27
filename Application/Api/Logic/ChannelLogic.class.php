<?php

namespace Api\Logic;


use Think\Log;

class ChannelLogic extends BaseRestLogic
{
    /*
   * 获取列表
   */
    public function getList($param)
    {
        //查询条件
        if($param['category_id'] > 0){
            $where['category_id'] = $param['category_id'];
        }
        if($param['user_id'] > 0){
            $where['create_user_id'] = $param['user_id'];
        }
        if($param['city']){
            $where['address'] = array('LIKE', '%'.$param['city'].'%');
        }
        if($param['tag_id'] > 0){
            $relationTable = getChannelTable($param['channel'], 5)['table_format'];
          
            $relations = M($relationTable)->field('data_id')->where("tag_id in (".$param['tag_id'].")")->select();
            $i = 0;
            foreach($relations as $r){
                $ids[$i] = $r['data_id'];
                $i++;
            }
            if($ids == ''){
                $ids[0]=0;
            }
            $where['id'] = array('IN', $ids);
        }
        if($param['search']){
            $map['title'] = array('LIKE', '%'.$param['search'].'%');
            if($param['channel'] == 'jhjj'){
                $map['gcsxm'] = array('LIKE', '%'.$param['search'].'%');
            }
//            else{
//                $map['content'] = array('LIKE', '%'.$param['search'].'%');
//            }

            $map['_logic'] = 'or';
            $where['_complex'] = $map;
        }
       
        if($param['page'] && $param['page_num']){
            $page = $param['page'];
            $page_num = $param['page_num'];
        }
        if($param['order_field']&&$param['order_by']){
            $orderBy = $param['order_field']. " ". $param['order_by'];
        }
       if($param['data_by']) {
            $orderBy = $param['data_by'];
        }
        $category = getChannelTable($param['channel'], 2)['table_format'];
        $where['is_deleted'] = 0;
        $where['is_active'] = 1;
        $where['status'] = 0;

        //暂时不处理
//       if($param['channel_type'] == 'Article'){
//
//        } else {
//            $where['UNIX_TIMESTAMP(formal_end_time)'] = array('GT',time());
//        }

      
        //应该要根据后台配置的列表内容显示数据
        $info = M($this->tableFormat)
//            ->join("AS A LEFT JOIN $category AS B ON A.category_id=B.id")
//            ->field("A.*,B.cat_name")
            ->where($where)
            ->page($page, $page_num)
            ->order($orderBy)
            ->select();

        //转换时间
        $i = 0;

        $catModel=M($category);
        foreach ($info as $value) {
            $info[$i]['create_time'] = date_to_timestamp($value['create_time']);
            $cat=$catModel->where("id=".$value['category_id'])->field("cat_name")->find();
            $info[$i]['cat_name']=$cat["cat_name"];
            $i++;
        }
        if($param['get_page']){
            $count = M($this->tableFormat)->where($where)->count();
            $pageTotal = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num);
            $pageInfo['page'] = $page;
            $pageInfo['page_total'] = $pageTotal;
            $data['info'] = $info;
            $data['page'] = $pageInfo;
        }else{
            $data = $info;
        }
        return $data ? $data : null;
    }

    /*
     * 获取子表信息
     * **/
    public function getChildList($param){

        $where['is_deleted'] = 0;
        $where['is_choice'] = 0;
        if($param['data_id']){
            $where['data_id'] = $param['data_id'];
        }
        if($param['relation_data_id']){
            $where['relation_data_id'] = $param['relation_data_id'];
        }
       if($param['zt_id']){
           $where["relation_data_id"] = $param['zt_id'];
       }


        $list = M($this->tableFormat)->where($where)->select();
        return $list;
    }

    /*
     * 获取门票
     */
    public function getTicketList($param, $filed=''){
        $where['data_id'] = $param['id'];
        $where['is_deleted'] = 0;
        $where['is_active'] = 1;
        if(!$filed){
            $filed = "id,cat_name,ticket_price,ticket_return_ratio";
        }

        $list = M($this->tableFormat)
                    ->field($filed)
                    ->where($where)
                    ->order('ticket_price')
                    ->select();
        return $list;
    }

    /*
     * 获取详情
     */
    public function getDetail($parameter)
    {
        //查询条件
        if($parameter['id']){
            $where['A.id'] = $parameter['id'];
        }else {
            $where['A.id'] = $parameter['data_id'];
        }
        $where['A.is_deleted'] = 0;
        $where['A.is_active'] = 1;
        $where['A.status'] = 0;
        //执行
        $category = getChannelTable($parameter['channel'], 2)['table_name'];
        $info = M($this->tableFormat)
            ->join("AS A LEFT JOIN $category AS B ON A.category_id=B.id")
            ->field("A.*,B.cat_name")
            ->where($where)
            ->find();
        if($info['content']){
            $info['content'] = htmlspecialchars_decode($info['content']);
        }
        if($info['jsys']){
            $info['jsys'] = htmlspecialchars_decode($info['jsys']);
        }
        if($info['xgzb']){
            $info['xgzb'] = htmlspecialchars_decode($info['xgzb']);
        }
        if($info['yyal']){
            $info['yyal'] = htmlspecialchars_decode($info['yyal']);
        }
        if($info['zlzs']){
            $info['zlzs'] = htmlspecialchars_decode($info['zlzs']);
        }
        if($info['ryzs']){
            $info['ryzs'] = htmlspecialchars_decode($info['ryzs']);
        }
        if($info['qtzs']){
            $info['qtzs'] = htmlspecialchars_decode($info['qtzs']);
        }
        if($info['xhjj']){
            $info['xhjj'] = htmlspecialchars_decode($info['xhjj']);
        }
        return $info ? $info : null;
    }

    /*
     * 获取子表数据详情
     * **/
    public function getChildDetail($param)
    {
        //查询条件
        $where['is_deleted'] = 0;
        if($param['id']){
            $where['id'] = $param['id'];
        }
        //执行
        $info = M($this->tableFormat)->where($where)->find();

        return $info;
    }

    /*
     * 获取分类列表
     */
    public function getCategoryList()
    {
        $formArr = $this->getTable();
        //查询条件
        $where['is_deleted'] = 0;
        $where['is_active'] = 1;
        //执行
        $info = M()->table("{$formArr["tableName"]}")
            ->field('id,cat_name,cat_img')
            ->where($where)
            ->order("sort_num ASC")
            ->select();
        return $info ? $info : null;
    }

    /*
     * 获取标签列表
     */
    public function getTags($channel, $ids){
        $tagTable = getChannelTable($channel, 4)['table_format'];
        $where['id'] = array('IN', $ids);
        $tagArr = M($tagTable)->where($where)->select();
        $tags = "";
        foreach($tagArr as $tag){
            $tags .= $tag['tag_name'] . ',';
        }
        $tags = rtrim($tags, ',');
        return $tags;
    }

    public function getCategoryName($channel, $id){
        $table = getTableStr($channel, 2, 'table_format');
        return M($table)->where('id='.$id)->getField('cat_name');
    }

    public function getTagList($channel){
        $tagTable = getChannelTable($channel, 4)['table_format'];
        $info = M($tagTable)->field('id,tag_name')->where('is_deleted=0')->order("sort_num ASC")->select();
        return $info;
    }

    /*
     * 获取总数
     */
    public function getCount($parameter)
    {
        //查询条件
        if($parameter['category_id']){
            $where['category_id'] = $parameter['category_id'];
        }
        if($parameter['search']){
            $where['_string'] = " title LIKE '%".$parameter['search']."%'";
        }
        Log::write($parameter['search'],"search>>>>>>>>");
        Log::write(json_encode($where),">>>>>>>>");
        $where['is_deleted'] = 0;
        $where['is_active'] = 1;
        $where['status'] = 0;
        //执行
        $formArr = $this->getTable();
        $info = M()->table($formArr["tableName"])->where($where)->count();
        return $info ? $info : 0;
    }

    /*
     * 收藏
     * **/
    public function collect($data, $user){

        $channelTable = getTableStr($data['channel'], $data['type'], 'table_format');
        M($channelTable)->where('id='.$data['data_id'])->setInc('favorites');

        $data['collect_user_id'] = $user['user_id'];
        $data['collect_user_name'] = $user['user_name'];
        $data['collect_user_nickname'] = $user['nickname'];
        $data['collect_time'] = date("Y-m-d H:i:s", time());
        $data['page_url'] = urldecode($data['page_url']);

        return M('CommonCollect')->add($data);
    }

    /*
     * 取消收藏
     * **/
    public function cancelCollect($data, $userId){

        $channelTable = getTableStr($data['channel'], $data['type'], 'table_format');
        M($channelTable)->where('id='.$data['data_id'])->setDec('favorites');

        $where['collect_user_id'] = $userId;
        $where['channel'] = $data['channel'];
        $where['type'] = $data['type'];
        $where['data_id'] = $data['data_id'];
        return M('CommonCollect')->where($where)->delete();
    }

    /*
     * 收藏列表
     * **/
    public function collectList($userId, $channel, $type, $page, $page_num){

        $where['collect_user_id'] = $userId;
        $where['channel'] = $channel;
        $where['is_deleted'] = 0;
        $where['is_active'] = 1;
        $where['type'] = $type;

        $table= getTableStr($channel, $type, 'table_format');

        $info = M($table)->alias('A')->join('__COMMON_COLLECT__ B ON A.id=B.data_id', 'LEFT')
                            ->field('A.*')
                            ->where($where)
                            ->page($page, $page_num)
                            ->select();

        return $info;
    }

    /*
     * 是否已收藏
     * **/
    public function isCollect($channel, $type=1, $id, $userId){
        $where['channel'] = $channel;
        $where['type'] = $type;
        $where['data_id'] = $id;
        $where['collect_user_id'] = $userId;

        $count = M('CommonCollect')->where($where)->count();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public function updateData($where, $data){
       return M($this->tableFormat)->where($where)->save($data);
    }

    /*
     * 增加点击数
     * **/
    public function addClicks($id){
        M($this->tableFormat)->where('id='.$id)->setInc('clicks');
    }

    /*
     * 获取订单
     * **/
    public function getOrder($channel, $type=3, $where){
        $orderTable = getTableStr($channel, $type, 'table_format');

        $order = M($orderTable)->where($where)->find();
        return $order;
    }

    public function isExistData($where){

        $info = M($this->tableFormat)->where($where)->find();
        if($info){
            return true;
        }else{
            return false;
        }
    }

    /*
    * 添加子表数据
    */
    public function addData($channel, $type, $param,$data){
        //获取channel_id
        $where['call_index'] = $channel;
        $channelInfo = M('SystemChannel')->where($where)->find();
        $data['channel_id'] = $channelInfo['id'];
        $data["create_time"] = date("Y-m-d H:i:s", time());
        $data['is_delete'] = 0;
        //添加用户信息
        if(empty($data["create_user_id"])){
            $user = session('userArr');
            $data["create_user_id"] = $user['user_id'];
            $data["create_user"] = $user['user_name'] ? $user['user_name'] : $user['nickname'];
        }
      
        //执行
        $info = M($this->tableFormat)->add($data);
        $fj_data['house_type_id'] = $data['relation_data_id'];
        $fj_data['house_type_name'] = $data['fangxing'];
        $fj_data['activity_id'] = $data['activity_id'];
        $fj_data['hotel_name'] = $data['title'];
        $fj_data['people_name'] = $data['xingming'];
        $fj_data['hotel_id'] = $param['jd_id'];
        $fj_data['user_id'] = $data['create_user_id'];
        $fj_data['user_name'] = $data['create_user'];
       /* $fj_data['is_choice'] =-1;*/
        $fj_data['fj_id'] = $info;
        $fj_data['order_id'] =$data['order_id'];
        $fj_data['zsgl_hygl_id'] = $info;
        $fj_data['create_time'] = date("Y-m-d H:i:s",time());
        M("ActivityXzfj")->add($fj_data);
        return $info ? $info : null;
    }
    /*
     * 联系我们
     */

    public function Contact($data=array())
    {
        //查找是否有这个用户账号
        $info = M('ArticleFwdj')
            ->add($data);
        return $info ? true : false;
    }
    public function getApplyInfo($channel, $type=3, $id, $userId, $filed=''){
        $orderTable = getTableStr($channel, $type, 'table_format');
        $where['activity_id'] = $id;
        $where['user_id'] = $userId;

        if(!$filed){
            $filed = 'name,mobile,email';
        }
        return  M($orderTable)->field($filed)->where($where)->find();
    }

    public function getUserInfo($userId){
        $where['user_id'] = $userId;
        $filed = 'user_name as name,nickname,mobile,email,company,job';

        return  M("ManageUsers")->field($filed)->where($where)->find();
    }

    //    //获取用户发布的列表
//    public function getMyList($parameter,$tableName){
//
//        $info = M()->table("$tableName")
//            //->field('id,title,qiyemingcheng,qiyetupian,gongchengshixingming,gongchengshitupian,feiyong,desc,content,create_time')
//            ->where("is_deleted = 0  AND is_active = 1 AND create_user_id = '{$_SESSION["userArr"]["user_id"]}' AND is_admin = 0")
//            ->order("create_time desc")
//            ->limit($parameter['limit_start'], $parameter['limit_end'])
//            ->select();
//        return $info;
//    }

    /*
     * 获取推送内容
     * @param info: 频道表数据
     * @param type: 内容类别,可以自行扩展类别来组装内容
     * @param param: 其他参数，传入需要参数
     * **/
    public function getPushContent($info, $type, $param){
        $content = null;
        switch($type){
            default:
            case 1: //
                $fileField = $param['file_field'];
                $content = $this->getDownAddress($info, $fileField);
                break;

        }

        return $content;
    }

    private function getDownAddress($info, $fileField){
        $http = 'http';
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
            $http = 'https';
        }
        $domain = $http . '://' . I('server.HTTP_HOST');

        $file = $domain . $info[$fileField];
        $content = $info['title'].'资料的下载地址是：'.$file;
        return $content;
    }
}