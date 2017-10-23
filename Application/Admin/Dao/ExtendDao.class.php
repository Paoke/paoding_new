<?php
/**
 * Created by PhpStorm.
 * User: SingHome
 * Date: 2016/11/10
 * Time: 14:05
 */

namespace Admin\Dao;

use Think\Model;

class ExtendDao
{

    /**
     * 通过频道模块获取列表显示的所有字段(基础表+扩展字段)
     * @param $baseTable format：'table_name'
     */
    public function getListField($channel, $module, $baseTable)
    {


        $condition['show_list'] = 1;
        $condition['field_type'] = 1;
        $condition['table_name'] = $baseTable;

        $fieldSql = 'title, name, width';

        //基础表字段
        $baseCol = M('SystemChannelFormField')->field($fieldSql)->where($condition)->select();


        //扩展表字段
        $condition = array();
        $condition['show_list'] = 1;
        $condition['field_type'] = 0;
        $condition['channel'] = $channel;
        $condition['module_index'] = $module;

        $extendCol = M('SystemChannelFormField')->field($fieldSql)->where($condition)->select();

        $cols = array_merge($baseCol, $extendCol);

        return $cols;

    }


    /**
     * 通过频道模块获取相应的扩展字段详细信息
     */
    public function getExtendFieldDetail($channel, $module)
    {

        $sql = "SELECT A.name, A.title, A.type, A.default_value, A.item_option, A.valid_tip_msg, A.valid_error_msg, A.valid_pattern " .
            "FROM __SYSTEM_CHANNEL_FORM_FIELD__ F, __SYSTEM_EXTEND_ATTRIBUTE__ A " .
            "WHERE F.attribute_id=A.id " .
            "AND F.field_type=0 " .
            "AND F.channel='" . $channel . "' AND F.module_index='" . $module . "'";


        $extends = M()->query($sql);

        return $extends;

    }

    /**
     * 通过频道模块获取相应的扩展字段简单信息(name,title)
     */
    public function getExtendField($channel, $module)
    {


        $ExtendField = M('SystemChannelFormField');

        $condition['channel'] = $channel;
        $condition['index'] = $module;
        $condition['field_type'] = 0;

        $fieldSql = 'name, title';

        $extends = $ExtendField->field($fieldSql)->where($condition)->select();

        return $extends;

    }

    /**
     * 获取列表数据(基本表+扩展表)
     * @param $baseTable format: "TableName"
     */
    public function getList($channel, $module, $baseTable, $fields, $where = null)
    {

        //格式化扩展表 format: "__TABLE_NAME__"
        $extendTable = strtoupper($baseTable) . '_EXTEND';
        $extendTable = '__' . $extendTable . '__';

        //拼接扩展字段
        $fieldSql = "";
        if ($fields) {
            $fieldArr = array();
            $i = 0;
            foreach ($fields as $field) {
                if($field['name'] !== 'id'){
                    $fieldArr[$i] = $field['name'];
                }

                $i++;
            }
            $fieldSql = implode($fieldArr, ',');
        }

        //条件
        if (empty($where)) {
            $where = "B.channel='" . $channel . "' AND B.is_deleted=0";
        }

        $base = M($baseTable)->alias('B');

        $list = $base->join('LEFT JOIN ' . $extendTable . ' E ON B.id=E.id')
            ->field('B.id, ' . $fieldSql)
            ->where($where)->select();

        $list = $this->formartList($channel, $module, $list);
        return $list;
    }

    private function formartList($channel, $module, $list)
    {
        $extendFileds = $this->getExtendFieldDetail($channel, $module);
        for ($i=0; $i<count($list); $i++) {
            foreach ($extendFileds as $eFiled) {
                $key = $eFiled['name'];
                if (!empty($list[$i][$key])) {
                    switch ($eFiled['type']) {
                        case 'checkbox':
                            $itemOption = $eFiled['item_option'];
                            // 1|上午,2|下午,3|晚上
                            if (!empty($itemOption)) {
                                $itemArr = explode(',', $itemOption);
                                $value = '';
                                foreach ($itemArr as $item) {
                                    $op = explode('|', $item);
                                    //1,2
                                    if(strpos($list[$i][$key], ',')){
                                        $indexArr = explode(',', $list[$i][$key]);
                                        foreach($indexArr as $index){
                                            if($index === $op[0]){
                                                $value .= $op[1] . '|';
                                                break;
                                            }
                                        }
                                    }else{
                                        if($list[$i][$key] === $op[0]){
                                            $value .= $op[1] . '|';
                                            break;
                                        }
                                    }
                                }
                                $value = substr($value, 0, mb_strlen($value)-1);
                                $list[$i][$key] = $value;
                            }
                            break;

                        case 'radio':
                        case 'select':
                            $itemOption = $eFiled['item_option'];
                            if (!empty($itemOption)) {
                                $itemArr = explode(',', $itemOption);
                                foreach ($itemArr as $item) {
                                    $op = explode('|', $item);
                                    if ($list[$i][$key] === $op[0]) {
                                        $list[$i][$key] = $op[1];
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }
        return $list;
    }
}