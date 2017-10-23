<?php
/**
 * Created by PhpStorm.
 * User: wubang
 * Date: 2016/8/16
 * Time: 12:11
 */
namespace Admin\Logic;

use Think\Model\RelationModel;

/**
 * 分类逻辑定义
 * Class CatsLogic
 * @package Home\Logic
 */
class RegisterCommonLogic extends RelationModel
{
    private $r_model;
    private $r_model_arr = array('r' => 'register', 'rd' => 'register_department', 'rs' => 'register_spec', 'rc' => 'register_category','as'=>'article_structure');

    /**
     * 获取指定的数据表
     * @return bool|string 返回当前操作的数组
     */
    public function find_model()
    {
        if (!in_array($this->getModelName(), $this->r_model_arr)) {
            return false;
        }
        $this->r_model = $this->getModelName();
        return $this->r_model;
    }

    /**
     * 获得指定分类下的子分类的数组
     * @access  public
     * @param   int $cat_id 分类的ID
     * @param   int $selected 当前选中分类的ID
     * @param   boolean $re_type 返回的类型: 值为真时返回下拉列表,否则返回数组
     * @param   int $level 限定返回的级数。为0时返回所有级数
     * @return  mix
     */
    public function info($cat_id = 0, $selected = 0, $re_type = true, $level = 0)
    {
        $this->find_model();
        global $val1, $val2;
        if ($this->r_model == 'register') {
            $sql = "SELECT ad.admin_id,ad.name,r.*,rd.id rd_id,rd.title rd_title,rc.id rc_id,rc.title rc_title FROM __PREFIX__register r LEFT JOIN __PREFIX__manage_admin ad ON ad.admin_id=r.create_user_id LEFT JOIN __PREFIX__register_department rd ON r.register_department_id=rd.id AND r.register_department_id=rd.id LEFT JOIN __PREFIX__register_category rc ON r.register_category_id=rc.id WHERE r.is_deleted !=1 ORDER BY r.sort ASC ,r.id ASC";
            $val1 = D($this->r_model)->query($sql);
            return $val1;
        } elseif ($this->r_model == 'register_department') {
            $sql = "SELECT ad.admin_id,ad.name,rd.* FROM __PREFIX__manage_admin AS ad LEFT JOIN __PREFIX__register_department AS rd ON rd.is_deleted != 1 AND ad.admin_id=rd.create_user_id ORDER BY sort ASC,rd.id ASC";
            $val1 = D($this->r_model)->query($sql);
            $val1 = convert_arr_key($val1, 'id');
            foreach ($val1 AS $key => $value) {
                if ($value['level'] == 1)
                    $this->get_tree($value['id']);
            }
            return $val2;
        } elseif ($this->r_model == 'register_category') {
            $sql = "SELECT ad.admin_id,ad.name,rc.* FROM __PREFIX__manage_admin AS ad LEFT JOIN __PREFIX__register_category AS rc ON rc.is_deleted != 1 AND ad.admin_id=rc.create_user_id ORDER BY sort ASC,rc.id ASC";
            $val1 = D($this->r_model)->query($sql);
            $val1 = convert_arr_key($val1, 'id');
            foreach ($val1 AS $key => $value) {
                if ($value['level'] == 1)
                    $this->get_tree($value['id']);
            }
            return $val2;
        } elseif ($this->r_model == 'register_spec') {
            $sql = "SELECT ad.admin_id,ad.name,rs.* FROM __PREFIX__manage_admin AS ad LEFT JOIN __PREFIX__register_spec AS rs ON rs.is_deleted != 1 AND ad.admin_id=rs.create_user_id ORDER BY sort ASC,rs.id ASC";
            $val1 = D($this->r_model)->query($sql);
            $val1 = convert_arr_key($val1, 'id');
            foreach ($val1 AS $key => $value) {
                if ($value['level'] == 1)
                    $this->get_tree($value['id']);
            }
            return $val2;
        }elseif ($this->r_model == 'article_structure') {
            $sql = "SELECT ad.admin_id,ad.name,ae.* FROM __PREFIX__manage_admin AS ad LEFT JOIN __PREFIX__article_structure AS ae ON ae.is_deleted != 1 AND ad.admin_id=ae.create_user_id ORDER BY sort ASC,ae.id ASC";
            $val1 = D($this->r_model)->query($sql);
            $val1 = convert_arr_key($val1, 'id');
            foreach ($val1 AS $key => $value) {
                if ($value['level'] == 1)
                    $this->get_tree($value['id']);
            }
            return $val2;
        }

    }

    /**
     * 获取指定id下的 所有分类
     * @global type $val1 所有商品分类
     * @param type $id 当前显示的 菜单id
     * @return 返回数组 Description
     */
    public function get_tree($id)
    {
        global $val1, $val2;
        $val2[$id] = $val1[$id];
        foreach ($val1 AS $key => $value) {
            if ($value['parent_id'] == $id) {
                $this->get_tree($value['id']);
                $val2[$id]['have_son'] = 1; // 还有下级
            }
        }
    }

    /**
     * 改变或者添加分类时 需要修改他下面的 parent_id_path  和 level
     * @global type $cat_list 所有商品分类
     * @param type $parent_id_path 指定的id
     * @return 返回数组 Description
     */
    public function refresh($id)
    {
        $this->find_model();
        $val1 = M($this->r_model); // 实例化User对象
        $cat = $val1->where("id = $id")->find(); // 找出他自己
        // 刚新增的分类先把它的值重置一下
        if ($cat['parent_id_path'] == '') {
            ($cat['parent_id'] == 0) && $val1->execute("UPDATE __PREFIX__$this->r_model set  parent_id_path = '_0_', level = 1 where id = $id"); // 如果是一级分类
            // $val1->execute("UPDATE __PREFIX__register_spec AS a ,__PREFIX__register_spec AS b SET a.parent_id_path = CONCAT_WS(null,b.parent_id_path,'$id'.'_'),a.level = (b.level+1) WHERE a.parent_id=b.id AND a.id = $id");
            $cat = $val1->where("id = $id")->find(); // 从新找出他自己
        }

        if ($cat['parent_id'] == 0) //是顶级分类 他没有老爸
        {

            $replace_level = 1; // 看看他 相比原来的等级 升级了多少  ($parent_cat['level'] + 1) 他老爸等级加一 就是他现在要改的等级
            $replace_str = '_0_';

        } else {   //parent_id !=0
            $parent_cat = $val1->where("id = {$cat['parent_id']}")->find(); // 找出他老爸的parent_id_path
            $replace_level = $parent_cat['level'] + 1; // 看看他 相比原来的等级 升级了多少  ($parent_cat['level'] + 1) 他老爸等级加一 就是他现在要改的等级
            $replace_str = $parent_cat['parent_id_path'] . $id . '_';
        }
        $val1->where(array('id' => $id))->setField(array('parent_id_path' => $replace_str, 'level' => $replace_level));
    }

    /**
     *  获取 公司 岗位 工作 选中的下拉框
     * @param type $id
     */
    function find_parent_id($id)
    {
        if ($id == null)
            return array();
        $this->find_model();
        $cat_list = M($this->r_model)->getField('id,parent_id,level');
        $cat_level_arr[$cat_list[$id]['level']] = $id;
        // 找出他老爸
        $parent_id = $cat_list[$id]['parent_id'];
        if ($parent_id > 0)
            $cat_level_arr[$cat_list[$parent_id]['level']] = $parent_id;
        // 找出他爷爷
        $grandpa_id = $cat_list[$parent_id]['parent_id'];
        if ($grandpa_id > 0)
            $cat_level_arr[$cat_list[$grandpa_id]['level']] = $grandpa_id;

        // 建议最多分 3级, 不要继续往下分太多级
        // 找出他祖父
        $grandfather_id = $cat_list[$grandpa_id]['parent_id'];
        if ($grandfather_id > 0)
            $cat_level_arr[$cat_list[$grandfather_id]['level']] = $grandfather_id;
        return $cat_level_arr;
    }
    function parent_tree(){
        $model_name=$this->find_model();
        echo $model_name;
    }
    /**
     *  获取 公司 岗位 工作 选中的下拉框
     * @param type $id
     */
    function find_parent_part($id)
    {
        if ($id == null)
            return array();
        $cat_list = M('register_department')->getField('id,parent_id,level');
        $cat_level_arr[$cat_list[$id]['level']] = $id;
        // 找出他老爸
        $parent_id = $cat_list[$id]['parent_id'];
        if ($parent_id > 0)
            $cat_level_arr[$cat_list[$parent_id]['level']] = $parent_id;
        // 找出他爷爷
        $grandpa_id = $cat_list[$parent_id]['parent_id'];
        if ($grandpa_id > 0)
            $cat_level_arr[$cat_list[$grandpa_id]['level']] = $grandpa_id;

        // 建议最多分 3级, 不要继续往下分太多级
        // 找出他祖父
        $grandfather_id = $cat_list[$grandpa_id]['parent_id'];
        if ($grandfather_id > 0)
            $cat_level_arr[$cat_list[$grandfather_id]['level']] = $grandfather_id;
        return $cat_level_arr;
    }

    /**
     *  获取 公司 岗位 工作 选中的下拉框
     * @param type $id
     */
    function find_parent_cate($id)
    {
        if ($id == null)
            return array();
        $cat_list = M('register_category')->getField('id,parent_id,level');
        $cat_level_arr[$cat_list[$id]['level']] = $id;
        // 找出他老爸
        $parent_id = $cat_list[$id]['parent_id'];
        if ($parent_id > 0)
            $cat_level_arr[$cat_list[$parent_id]['level']] = $parent_id;
        // 找出他爷爷
        $grandpa_id = $cat_list[$parent_id]['parent_id'];
        if ($grandpa_id > 0)
            $cat_level_arr[$cat_list[$grandpa_id]['level']] = $grandpa_id;

        // 建议最多分 3级, 不要继续往下分太多级
        // 找出他祖父
        $grandfather_id = $cat_list[$grandpa_id]['parent_id'];
        if ($grandfather_id > 0)
            $cat_level_arr[$cat_list[$grandfather_id]['level']] = $grandfather_id;
        return $cat_level_arr;
    }
    /**
     *  获取 公司 岗位 工作 选中的下拉框
     * @param type $id
     */
    function find_parent_spec($id)
    {
        if ($id == null)
            return array();
        $cat_list = M('register_spec')->getField('id,parent_id,level');
        $cat_level_arr[$cat_list[$id]['level']] = $id;
        // 找出他老爸
        $parent_id = $cat_list[$id]['parent_id'];
        if ($parent_id > 0)
            $cat_level_arr[$cat_list[$parent_id]['level']] = $parent_id;
        // 找出他爷爷
        $grandpa_id = $cat_list[$parent_id]['parent_id'];
        if ($grandpa_id > 0)
            $cat_level_arr[$cat_list[$grandpa_id]['level']] = $grandpa_id;

        // 建议最多分 3级, 不要继续往下分太多级
        // 找出他祖父
        $grandfather_id = $cat_list[$grandpa_id]['parent_id'];
        if ($grandfather_id > 0)
            $cat_level_arr[$cat_list[$grandfather_id]['level']] = $grandfather_id;
        return $cat_level_arr;
    }
}
