<?php

namespace Api\Logic;


use Think\Log;

class CompanyLogic extends BaseRestLogic
{
    //获取列表
    public function getCompanyList($parameter)
    {
        $formArr = $this->getTable();
        $tableName = $formArr["tableFormat"];
        $channelId = M("SystemChannel")->where("call_index='{$parameter['channel']}'")->getField("id");  //频道id

        $where['is_deleted'] = 0;
        $where['status'] = 0;
        $where['is_active'] = 1;
        //判断是否是置顶数据
        if ($parameter['is_red'] == 1) {
            $where['is_red'] = 1;
        }

        if ($parameter['city'] != null) {
            $where['city'] = array('like', '%' . $parameter['city'] . '%');
            $info1 = M("$tableName")
                ->field('id,title,logo_img,clicks,level_id,contacts,mobile,email')
                ->where($where)
                ->order($parameter['sort'])
                ->limit($parameter['limit_start'], $parameter['limit_end'])
                ->select();
            $info[0] = $info1;
            $info[1] = '以下是城市【' . $parameter['city'] . '】筛选结果：';

        } else if ($parameter['is_search'] == 1) {
            if($parameter['search'] != 'all') {
                $where['title'] = array('like', '%' . $parameter['search'] . '%');
                $info1 = M("$tableName")
                    ->field('id,title,logo_img,clicks,level_id,contacts,mobile,email')
                    ->where($where)
                    ->limit($parameter['limit_start'], $parameter['limit_end'])
                    ->order($parameter['sort'])
                    ->select();
                $info[0] = $info1;
                $info[1] = '以下是关键字【' . $parameter['search'] . '】筛选结果';
            } else {
                $info1 = M("$tableName")
                    ->field('id,title,logo_img,clicks,level_id,contacts,mobile,email')
                    ->where($where)
                    ->limit($parameter['limit_start'], $parameter['limit_end'])
                    ->order($parameter['sort'])
                    ->select();
                $info[0] = $info1;
                $info[1] = '企业列表：';
            }

        } else if ($parameter['tag_id'] != null) {
            $search = $parameter['tag_id'];
            $relationTable = getTable($parameter['channel'], 5)['table_name'];
            $where2['B.tag_id'] = array('in',$search);
            $where2['A.is_deleted'] = 0;
            $where2['A.status'] = 0;
            $where2['A.is_active'] = 1;
           
            $info1 = M("$tableName")->alias('A')
                ->field('distinct A.id,A.title,A.logo_img,A.clicks,A.level_id,contacts,mobile,email')
                ->join("LEFT JOIN $relationTable B ON A.id=B.data_id")
                ->where($where2)
                ->limit($parameter['limit_start'], $parameter['limit_end'])
                ->order("A.".$parameter['sort'])
                ->select();
            $info[0] = $info1;
            $info[1] = '以下是所选标签筛选结果';
        } else {
            if ($parameter['sort'] == 'asc') {
                $order = "clicks asc";
            } else if ($parameter['sort'] == 'desc') {
                $order = "clicks desc";
            } else {
                $order = $parameter['sort'];
            }
            $info[0] = M("$tableName")
                ->field('id,title,logo_img,clicks,level_id,contacts,mobile,email')
                ->where($where)
                ->order($order)
                ->limit($parameter['limit_start'], $parameter['limit_end'])
                ->select();
        }

        //获取标签
        $tagsRelationTable = M("SystemChannelTableConfig")
            ->where("channel= '{$parameter['channel']}' AND type=5")
            ->getField("table_format");
        $tagsTable = M("SystemChannelTableConfig")
            ->where("channel= '{$parameter['channel']}' AND type=4")
            ->getField("table_name");

        if($info[0]){
            $i = 0;
            foreach ($info[0] as $data) {
                $tagName = M($tagsRelationTable)->alias('A')
                                ->field("B.tag_name")
                                ->join("$tagsTable B on B.id = A.tag_id", "LEFT")
                                ->where("A.data_id =" . $data['id'])
                                ->select();
                $tags = array();
                foreach ($tagName as $valuet) {
                    $tags[] = $valuet['tag_name'];
                }
                $tagsName = implode(' | ', $tags);
                $info[0][$i]['tags_name'] = $tagsName;
                $i++;
            }
        }


        return $info ? $info : null;
    }

    //获取公司详情
    public function getCompanyDetail($parameter)
    {
        if ($parameter['type'] == 1) {
            $channel = $parameter['channel'];
            $tagsTable = M("SystemChannelTableConfig")
                ->where("channel= '$channel' AND type=4")
                ->getField("table_name");
            $tagsRelationTable = M("SystemChannelTableConfig")
                ->where("channel= '$channel' AND type=5")
                ->getField("table_format");

            if ($parameter['data_id'] > 0) {
                $info1 = M($this->tableFormat)
                    ->field()
                    ->where("is_deleted = 0 AND id={$parameter['data_id']}  AND status = 0 AND is_active = 1")
                    ->order("clicks DESC ")
                    ->find();
                $info1['intro'] = htmlspecialchars_decode($info1['intro']);

                //***********查询是否被关注****************
                $conf = array();
                $conf['data_id'] = $parameter['data_id'];
                $conf['channel_id'] = $info1['channel_id'];
                $conf['zan_user_id'] = $parameter['user_id'];
                $relationCount = M("CommonLike")->where($conf)->count();
                //***********查询是否被关注****************

                $tagName = M($tagsRelationTable)
                    ->alias('a')
                    ->field("b.tag_name")
                    ->join("$tagsTable b on b.id = a.tag_id", "LEFT")
                    ->where("a.data_id =" . $info1['id'])
                    ->select();
                $tags = array();
                foreach ($tagName as $valuet) {
                    $tags[] = $valuet['tag_name'];
                }
                $tagsName = implode(' | ', $tags);
                $info1['tags_name'] = $tagsName;

                $info[0] = $info1;
                $info[1] = $relationCount; //是否关注该公司
            } else {
                $info1 = M($this->tableFormat)
                    ->field()
                    ->where("is_deleted = 0  AND status = 0 AND is_active = 1")
                    ->order("level_data DESC ")
                    ->select();

                foreach ($info1 as $item => $value) {
                    $tagName = M($tagsRelationTable)
                        ->alias('a')
                        ->field("b.tag_name")
                        ->join("$tagsTable b on b.id = a.tag_id", "LEFT")
                        ->where("a.data_id =" . $value['id'])
                        ->select();

                    $tags = array();
                    foreach ($tagName as $valuet) {
                        $tags[] = $valuet['tag_name'];
                    }
                    $tagsName = implode(' | ', $tags);
                    $info[$item][0] = $value;
                    $info[$item][0]['intro'] = htmlspecialchars_decode($info[$item][0]['intro']);
                    $info[$item][0]['tags_name'] = $tagsName;
                    $relationCount = M("ManageUsersRelation")
                        ->where("from_user_id = '{$parameter['user_id']}' AND to_user_id = " . $value['id'] . " AND rel_type = 2")
                        ->count();
                    $info[$item][1] = $relationCount;
                }
            }
        } //动态
        else if ($parameter['type'] == 8) {
            $info = $this->newsDetails($parameter, $tableName);
        }
        return $info;
    }

    //获取职位分类列表
    public function getRecruitList($parameter)
    {
        if ($parameter['parent_id']) {
            $where['parent_id'] = $parameter['parent_id'];
            $info = M($this->tableFormat)->where($where)->select();

        } else {
            $info = M($this->tableFormat)
                ->field('id,title')
                ->where("is_deleted = 0 AND parent_id = 0 ")
                ->select();
            $i = 0;
            foreach ($info as $value) {
                $second = M($this->tableFormat)
                    ->field('id,title')
                    ->where("is_deleted = 0 AND parent_id = {$value['id']}")
                    ->select();
                $info[$i]['second'] = $second;
                $i++;
            }
        }

        return $info ? $info : null;
    }

    //获取职位分类下的招聘列表
    public function getRecruitLevelList($parameter)
    {
        $channel = $parameter['channel'];
        $companyTable = M("SystemChannelTableConfig")
            ->where("channel= '$channel' AND type=1")
            ->getField("table_name");
        $formArr = $this->getTable();
        $where['A.is_deleted'] = 0;
        if ($parameter['parent_id']) {
            $where['A.category_id'] = $parameter['parent_id'];
        }
        if ($parameter['second_level_id']) {
            $where['A.second_recruit_id'] = $parameter['second_level_id'];
        }
        $where['B.status'] = 0;
        $where['B.is_active'] = 1;
        if ($parameter['data_id']) {
            $where['B.id'] = $parameter['data_id'];
        }
        $info = M("{$formArr["tableFormat"]}")
            ->alias("A")
            ->field('A.id,A.title,A.obligation,A.payment,A.create_time,A.intro,B.logo_img')
            ->join("$companyTable B on B.id = A.data_id", "LEFT")
            //   ->where("a.is_deleted = 0 AND a.category_id = '{$parameter['parent_id']}' AND a.second_recruit_id = '{$parameter['second_level_id']}' AND b.status = 0 AND b.is_active = 1")
            ->where($where)
            ->select();
        $i = 0;
        foreach ($info as $value) {
            $info[$i]['intro'] = htmlspecialchars_decode($info[$i]['intro']);
            $info[$i]['create_time'] = date_to_timestamp($info[$i]['create_time']);
            $i++;
        }
        return $info ? $info : null;
    }

    /*
     * 获取某个招聘的详细信息
     */
    public function getCompanyJobDetail($parameter)
    {

        $where['is_deleted'] = 0;
        $where['id'] = $parameter['id'];
        $info = M($this->tableFormat)
            ->where($where)
            ->find();


        $info['intro'] = htmlspecialchars_decode($info['intro']);
        $info['create_time'] = date_to_timestamp($info['create_time']);

        return $info;
    }

    /*
     * 职位
     * 1、如果没有数据id，那么获取全部信息；否则只获取当前数据的数据
     */
    public function getJobList($parameter, $tableName)
    {

        //获取频道表名
        $channelTableName = M("SystemChannelTableConfig")
            ->where("channel= '" . $parameter['channel'] . "' AND type=1")
            ->getField("table_name");

        if ($parameter['keyword'] == "company") {
            $where['A.data_id'] = $parameter['data_id'];
        } else if ($parameter['keyword'] == "category") {
            $where['A.second_recruit_id'] = $parameter['data_id'];
        }
       /* if ($parameter['data_id']) {
            $where['A.data_id'] = $parameter['data_id'];
        }*/

        $where['A.is_deleted'] = 0;
        $info = M("$tableName")
            ->alias("A")
            ->field("A.id,A.title,A.obligation,A.second_recruit_id,A.payment,A.create_time,A.intro,A.data_id,B.logo_img,B.city")
            ->join("$channelTableName B on B.id = A.data_id", "LEFT")
            ->where($where)
            ->limit($parameter['limit_start'], $parameter['limit_end'])
            ->order("A.create_time desc")
            ->select();
        if ($info) {
            $i = 0;
            foreach ($info as $value) {
                $info[$i]['intro'] = htmlspecialchars_decode($value['intro']);
                $info[$i]['create_time'] = date_to_timestamp($value['create_time']);
                $i++;
            }
        }
        return $info ? $info : null;
    }

    /*
     * 获取标签列表
     */
    public function getTagList($channel_id, $tableName)
    {
        $info = M($tableName)
            ->field("id,tag_name")
            ->where("is_deleted = 0 AND channel_id =" . $channel_id)
            ->order("sort_num  asc")
            ->select();
        return $info ? $info : null;
    }

    /*
     * 获取动态列表
     */
    public function getNewsList($parameter, $tableName, $user_id)
    {
        $where['A.is_deleted'] = 0;
        if ($parameter['data_id']) {
            $where['A.data_id'] = $parameter['data_id'];
        }
        //获取频道表名
        $channelTableName = M("SystemChannelTableConfig")
            ->where("channel= '{$parameter['channel']}' AND type=1")
            ->getField("table_name");

        $info = M("$tableName")
            ->alias('A')
            ->field("A.id,A.title,A.cover_url,A.link,A.desc,A.create_time,A.likes,b.title as company_title,b.logo_img")
            ->join("$channelTableName b on b.id = A.data_id", "LEFT")
            ->where($where)
            ->limit($parameter['limit_start'], $parameter['limit_end'])
            ->order("A.create_time DESC")
            ->select();

        $i = 0;
        foreach ($info as $value) {
            $info[$i]['create_time'] = date_to_timestamp($info[$i]['create_time']);
            $isLike = M('CommonLike')->where("data_id={$value['id']}  AND zan_user_id='{$user_id}'")->count();
            //添加一条此用户是否点赞此动态，1 为是，0为否
            $info[$i]['isLike'] = $isLike;

            $i++;
        }
        return $info ? $info : null;
    }

    //写入被点赞的用户信息
    public function likes($parameter)
    {
        $formArr = $this->getTable();
        $channelId = M("SystemChannel")->where("call_index='{$parameter['channel']}'")->getField("id");  //频道id
        $fromData = M("{$formArr["tableFormat"]}")
            ->field("title")
            ->where("id={$parameter["news_id"]}")
            ->find();

        $data["zan_title"] = $fromData["title"];

        //查找用户是否点赞过。
        $info = M('CommonLike')->where("zan_user_id= '{$parameter["zan_user_id"]}' AND data_id= '{$parameter["news_id"]}'")->find();
        if ($info) {
            M('CommonLike')->where("zan_user_id= '{$parameter["zan_user_id"]}' AND data_id= '{$parameter["news_id"]}'")->delete();
        } else {
            $data['data_id'] = $parameter['news_id'];
            $data['channel_id'] = $channelId;
            $data['zan_user_id'] = $parameter['zan_user_id'];
            $data['zan_user_name'] = $parameter['zan_user_name'];
            $data['zan_user_nickname'] = $parameter['zan_user_nickname'];
            $data['zan_time'] = $parameter['zan_time'];
            $data['data_id'] = $parameter['news_id'];
            M('CommonLike')->add($data);
        }
        //此用户对此动态的点赞数
        $isLike = M('CommonLike')->where("data_id= '{$parameter["news_id"]} ' AND zan_user_id= '{$parameter["zan_user_id"]}'")->count();
        //$count这条动态一共有多少点赞
        $count = M('CommonLike')->where("data_id= '{$parameter["news_id"]} '")->count();
        $array[0] = $isLike;
        $array[1] = $count;
        return $array;
    }

    /*
     * 获取详情
     * **/
    public function detail($id)
    {
        try {
            $where['A.id'] = $id;
            $levelTableConfig = $this->getChannelTable($this->channel, 3);
            $levelTable = $levelTableConfig['table_format2'];

            $field = "A.id,A.title,A.address,A.contacts,A.mobile,A.email,A.logo_img,A.status,A.level_id,DATE_FORMAT(A.level_expiry,'%Y-%m-%d') level_expiry," .
                "B.level_name,B.cost level_cost";
            $data = M("$this->tableFormat")->alias('A')->join('LEFT JOIN ' . $levelTable . ' B ON A.level_id=B.id')
                ->field($field)
                ->where($where)
                ->select();
            return $data[0];
        } catch (Exception $e) {
            return false;
        }

    }


    public function getFieldValue($id, $field)
    {
        $table = $this->tableFormat;
        return M($table)->where('id=' . $id)->getField($field);
    }

    /*
     * 更新字段信息
     * **/
    public function updateField($id, $field, $value){

        $table = $this->tableFormat;
        return M($table)->where('id=' . $id)->setField($field, $value);
    }

    /*
     * 根据data_id删除数据(关联表删除使用)
     * **/
    public function deleteDataByDataId($dataId)
    {
        $table = $this->tableFormat;
        return M($table)->where('data_id=' . $dataId)->delete();
    }

    /*
     * 新增数据
     * **/
    public function addAllData($data)
    {
        $table = $this->tableFormat;
        return M($table)->addAll($data);
    }

    /*
     * 新增数据
     * **/
    public function addData($data)
    {
        $table = $this->tableFormat;
        return M($table)->add($data);
    }

    /*
     * 获取标签列表
     */
    public function getTagRelation($channel, $dataId)
    {
        $channelId = M('SystemChannel')->where("call_index='" . $channel . "'")->getField('id');
        $tagTable = getTableStr($channel, 4, 'table_format');
        $info = M($tagTable)
            ->where("is_deleted = 0 AND channel_id =" . $channelId)
            ->field("id,tag_name")
            ->order("sort_num asc")
            ->select();

        $relationTable = getTableStr($channel, 5, 'table_format');
        $where['channel_id'] = $channelId;
        $where['data_id'] = $dataId;
        $tagIds = M($relationTable)->field('tag_id')->where($where)->select();

        foreach ($tagIds as $item) {
            $ids[] = $item['tag_id'];
        }

        $i = 0;
        foreach ($info as $tag) {
            if (in_array($tag['id'], $ids)) {
                $info[$i]['checked'] = true;
            } else {
                $info[$i]['checked'] = false;
            }
            $i++;
        }


        return $info ? $info : null;
    }

}