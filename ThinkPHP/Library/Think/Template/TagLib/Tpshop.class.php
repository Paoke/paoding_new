<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think\Template\TagLib;
use Think\Template\TagLib;

/**
 * 自定义标签
 */

class Tpshop extends TagLib {
	protected $tags = array(
		'adv' => array('attr'=>'limit,order,where,item','close'=>1),
		'article' => array('attr'=>'limit,order,where','close'=>1),
                'tpshop' => array('attr'=>'sql,key,item,result_name','close'=>1,'level'=>3), // tpshop sql 万能标签
                'goods_img' =>  array('attr'=>'id,width,height','close'=>0), // 商品缩列图标签
	);

	public function _article($tag,$content){
		
	}
        
    /**
     * _tpshopassign标签解析
     * 在模板中给某个变量赋值 支持变量赋值
     * 格式： <assign name="" value="" />
     * @access public
     * @param array $tag 标签属性
     * @param string $content  标签内容
     * @return string
     
    public function _tpshopassign($tag,$content) {
        $name       =   $this->autoBuildVar($tag['name']);
        if('$'==substr($tag['value'],0,1)) {
            $value  =   $this->autoBuildVar(substr($tag['value'],1));
        }else{
            $value  =   '\''.$tag['value']. '\'';
        }
        $parseStr   =   '<?php '.$name.' = '.$value.'; ?>';
        return $parseStr;
    }
	*/		
	/**
	 * sql 语句万能标签
	 * @access public
	 * @param array $tag 标签属性
	 * @param string $content  标签内容
	 * @return string
	 */
	public function _tpshop($tag,$content){
            $sql = $tag['sql']; // sql 语句     
            //  file_put_contents('a.html', $sql.PHP_EOL, FILE_APPEND);
            $sql = str_replace(' eq ', ' = ', $sql); // 等于
            $sql = str_replace(' neq  ', ' != ', $sql); // 不等于            
            $sql = str_replace(' gt ', ' > ', $sql);// 大于
            $sql = str_replace(' egt ', ' >= ', $sql);// 大于等于
            $sql = str_replace(' lt ', ' < ', $sql);// 小于
            $sql = str_replace(' elt ', ' <= ', $sql);// 小于等于
            //$sql = str_replace(' heq ', ' == ', $sql);// 恒等于
            //$sql = str_replace(' nheq ', ' !== ', $sql);// 不恒等于
            
           // $sql = str_replace(')', '."', $sql);
                                                
            $key  =  !empty($tag['key']) ? $tag['key'] : 'key';// 返回的变量key
            $item  =  !empty($tag['item']) ? $tag['item'] : 'item';// 返回的变量item	
            $result_name  =  !empty($tag['result_name']) ? $tag['result_name'] : 'result_name';// 返回的变量key			
                        
            //$Model = new \Think\Model();
            //$name = 'sql_result_'.$item.rand(10000000,99999999); // 数据库结果集返回命名
            $name = 'sql_result_'.$item;//.rand(10000000,99999999); // 数据库结果集返回命名
            //$this->tpl->tVar[$name] = $Model->query($sql); // 变量存储到模板里面去                      
            $parseStr   =   '<?php
                                   
                                $md5_key = md5("'.$sql.'");
                                $'.$name.' = S("sql_".$md5_key);
                                if(empty($'.$name.'))
                                {
                                    $Model = new \Think\Model();    
                                    $'.$result_name.' = $'.$name.' = $Model->query("'.$sql.'"); 
                                    S("sql_".$md5_key,$'.$name.',TPSHOP_CACHE_TIME);
                                }    
                             ';  
            $parseStr  .=   ' foreach($'.$name.' as $'.$key.'=>$'.$item.'): ?>';
            $parseStr  .=   $this->tpl->parse($content).$tag['level'];
            $parseStr  .=   '<?php endforeach; ?>';                                    
           
            if(!empty($parseStr)) {
                return $parseStr;
            }
            return ;
    }
}
 