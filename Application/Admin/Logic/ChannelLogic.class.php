<?php
namespace Admin\Logic;

/**
 * 频道逻辑
 * @package Admin\Logic
 */
class ChannelLogic
{

    private $DAO = null;//当前表操作对象
    private $channel = null;
    private $type = null;

    public function __construct($channel, $type)
    {
        parent::__construct();
        $this->channel = $channel;
        $this->type = $type;
        $this->DAO = createDAO($channel, $type);
    }

    /*
     * 创建数据库操作对象
     * **/
    public function createDAO($channel, $type){
        $table = getTableStr($channel, $type, 'table_format');
        $DAO = D($table);
        return $DAO;
    }



}