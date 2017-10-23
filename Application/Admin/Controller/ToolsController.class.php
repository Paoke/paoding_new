<?php

namespace Admin\Controller;

use Think\Upload;

class ToolsController extends BaseController
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

    public function backups()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            //数据备份
            case "page_list":
                $dbtables = M()->query('SHOW TABLE STATUS');
                $total = 0;
                $count = count($dbtables);          //$count    总共有多少条数据
                $page_num = I('get.page_num', null) ? I('get.page_num') : I('post.page_num', 25);   //$page_num 每页几条数据
                $page_now = I('get.page_now', 1);   //$page_now 第几页
                $page = ($count / $page_num) > intval($count / $page_num) ? intval($count / $page_num + 1) : intval($count / $page_num); //$page     总共有几页
                foreach ($dbtables as $k => $v) {
                    $dbtables[$k]['size'] = format_bytes($v['data_length'] + $v['index_length']);
                    $total += $v['data_length'] + $v['index_length'];
                }
                foreach ($dbtables as $k => $v) {
                    if ($k >= ($page_now - 1) * $page_num && $k <= $page_now * $page_num - 1)
                        $list[] = $v;
                }
                $this->assign('page', $page);
                $this->assign('page_num', $page_num);
                $this->assign('page_now', $page_now);
                $this->assign('count', $count);
                $this->assign('list', $list);
                $this->assign('total', format_bytes($total));
                $this->assign('tableNum', count($dbtables));
                $this->display("backups_list");
                break;
            //优化
            case "optimize":
                $batchFlag = I('get.batchFlag', 0, 'intval');
                //批量删除
                if ($batchFlag) {
                    $table = I('key', array());
                } else {
                    $table[] = I('tablename', '');
                }

                if (empty($table)) {
                    $this->error('请选择要优化的表');
                }

                $strTable = implode(',', $table);
                if (!M()->query("OPTIMIZE TABLE {$strTable} ")) {
                    $strTable = '';
                }
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "优化表" . I('tablename', '') . "成功",4);
                $this->success("优化表成功" . $strTable);
                break;
            //修复
            case "repair":
                $batchFlag = I('get.batchFlag', 0, 'intval');
                //批量删除
                if ($batchFlag) {
                    $table = I('key', array());
                } else {
                    $table[] = I('tablename', '');
                }

                if (empty($table)) {
                    $this->error('请选择修复的表');
                }

                $strTable = implode(',', $table);
                if (!M()->query("REPAIR TABLE {$strTable} ")) {
                    $strTable = '';
                }
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "修复表" . I('tablename', '') . "成功",4);
                $this->success("修复表成功" . $strTable);
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                json_return($returnArr);
        }
    }
/*
 * 第三方登录插件
 */
    public function oauth()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            case "page_list":
                $type = "login";
                $plugin_list = M('SystemPlugin')->order('sort asc')->select();
                $plugin_list = group_same_key($plugin_list, 'type');
                $mod_id = get_mod_id('Plugin', 'setting' . $type);
                $this->assign('mod_id', $mod_id);
                $this->assign('type', $type);
                $this->assign('list', $plugin_list[$type]);
                $this->assign('function', $plugin_list['function']);
                $this->display('oauth_list');
                break;
            case "page_edit":
                $condition['type'] = I('get.type');
                $condition['code'] = I('get.code');
                $model = M('SystemPlugin');
                $row = $model->where($condition)->find();
                if (!$row) {
                    exit($this->error("不存在该插件"));
                }
                $row['config'] = unserialize($row['config']);
                $this->assign('type', $condition['type']);
                $this->assign('plugin', $row);
                $this->assign('config_value', unserialize($row['config_value']));

                $this->display('oauth_info');
                break;
            case "edit":
                $config = I('post.config');
                $this->save($config, $postData);
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "删除退货单" . $postData["name"] . "成功",5);
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法");
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                json_return($returnArr);
        }
    }

    public function restore()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            //数据备份
            case "page_list":
                $size = 0;
                $pattern = "*.sql";
                $filelist = glob(UPLOAD_PATH . "sqldata/" . $pattern);
                $fileArray = array();
                foreach ($filelist as $i => $file) {
                    //只读取文件
                    if (is_file($file)) {
                        $_size = filesize($file);
                        $size += $_size;
                        $name = basename($file);
                        $pre = substr($name, 0, strrpos($name, '_'));
                        $number = str_replace(array($pre . '_', '.sql'), array('', ''), $name);
                        $fileArray[] = array(
                            'name' => $name,
                            'pre' => $pre,
                            'time' => filemtime($file),
                            'size' => $_size,
                            'number' => $number,
                        );
                    }
                }

                if (empty($fileArray)) $fileArray = array();
                krsort($fileArray); //按备份时间倒序排列
                $this->assign('vlist', $fileArray);
                $this->assign('total', format_bytes($size));
                $this->assign('filenum', count($fileArray));
                $this->display("restore_list");
                break;
            //执行还原数据库操作
            case "restoreData":
                //ini_set("memory_limit", "16M");
                function_exists('set_time_limit') && set_time_limit(0); //防止备份数据过程超时
                //取得需要导入的sql文件
                if (!isset($_SESSION['cacheRestore']['files'])) {
                    $_SESSION['cacheRestore']['starttime'] = time();
                    $_SESSION['cacheRestore']['files'] = $this->getRestoreFiles();
                }

                $files = $_SESSION['cacheRestore']['files'];
                if (empty($files)) {
                    unset($_SESSION['cacheRestore']);
                    $this->error('不存在对应的SQL文件');
                }

                //取得上次文件导入到sql的句柄位置
                $position = isset($_SESSION['cacheRestore']['position']) ? $_SESSION['cacheRestore']['position'] : 0;
                $execute = 0;
                foreach ($files as $fileKey => $sqlFile) {
                    $file = UPLOAD_PATH . "sqldata/" . $sqlFile;
                    if (!file_exists($file))
                        continue;
                    $file = fopen($file, "r");
                    $sql = "";
                    fseek($file, $position); //将文件指针指向上次位置
                    while (!feof($file)) {
                        $tem = trim(fgets($file));
                        //过滤,去掉空行、注释行(#,--)
                        if (empty($tem) || $tem[0] == '#' || ($tem[0] == '-' && $tem[1] == '-'))
                            continue;
                        //统计一行字符串的长度
                        $end = (int)(strlen($tem) - 1);
                        //检测一行字符串最后有个字符是否是分号，是分号则一条sql语句结束，否则sql还有一部分在下一行中
                        if ($tem[$end] == ";") {
                            $sql .= $tem;
                            M()->execute($sql);
                            $sql = "";
                            $execute++;
                            if ($execute > 500) {
                                $_SESSION['cacheRestore']['position'] = ftell($file);
                                $imported = isset($_SESSION['cacheRestore']['imported']) ? $_SESSION['cacheRestore']['imported'] : 0;
                                $imported += $execute;
                                $_SESSION['cacheRestore']['imported'] = $imported;
                                //echo json_encode(array("status" => 1, "info" => '如果导入SQL文件卷较大(多)导入时间可能需要几分钟甚至更久，请耐心等待导入完成，导入期间请勿刷新本页，当前导入进度：<font color="red">已经导入' . $imported . '条Sql</font>', "url" => U('Database/restoreData', array(get_randomstr(5) => get_randomstr(5)))));
                                $this->success('如果SQL文件卷较大(多),则可能需要几分钟甚至更久,<br/>请耐心等待完成，<font color="red">请勿刷新本页</font>，<br/>当前导入进度：<font color="red">已经导入' . $imported . '条Sql</font>', U('Admin/Tools/restore/action/restoreData', array(get_rand_str(5, 0) => get_rand_str(5, 0))));
                                exit();
                            }
                        } else {
                            $sql .= $tem;
                        }
                    }
                    //错误位置结束
                    fclose($file);
                    unset($_SESSION['cacheRestore']['files'][$fileKey]);
                    $position = 0;
                }
                $time = time() - $_SESSION['cacheRestore']['starttime'];
                unset($_SESSION['cacheRestore']);
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "还原表" . I('tablename', '') . "成功",4);
                $this->success("导入成功，耗时：{$time} 秒钟", U('Admin/Tools/restore/action/page_list'));
                break;
            //执行上传数据库操作
            case "restoreUpload":
                $config = array(
                    "savePath" => 'sqldata/',
                    "maxSize" => 100000000, // 单位B
                    "exts" => array('sql'),
                    "subName" => array(),
                );

                $upload = new Upload($config);
                $info = $upload->upload();
                if (!$info) { // 上传错误提示错误信息
                    $this->error($upload->getError());
                } else { // 上传成功 获取上传文件信息
                    $file_path_full = '.' . $info['sqlfile']['urlpath'];
                    if (file_exists($file_path_full)) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "上传表" . I('tablename', '') . "成功",4);
                        $this->success("上传成功", U('Tools/restore'));
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "上传表" . I('tablename', '') . "失败",4);
                        $this->error('文件不存在');
                    }
                }
                break;
            //下载
            case "downFile":
                if (empty($_GET['file']) || empty($_GET['type']) || !in_array($_GET['type'], array("zip", "sql"))) {
                    $this->error("下载地址不存在");
                }
                $path = array("zip" => UPLOAD_PATH . "zipdata/", "sql" => UPLOAD_PATH . "sqldata/");

                $filePath = $path[$_GET['type']] . $_GET['file'] . ".sql";
                if (!file_exists($filePath)) {
                    $this->error("该文件不存在，可能是被删除");
                }
                $filename = basename($filePath);
                header("Content-type: application/octet-stream");
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header("Content-Length: " . filesize($filePath));
                readfile($filePath);
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "下载表" . I('tablename', '') . "成功",4);
                break;
            //删除sql文件
            case "delSqlFiles":
                $batchFlag = I('get.batchFlag', 0, 'intval');
                //批量删除
                if ($batchFlag) {
                    $files = I('key', array());
                } else {
                    $files[] = I('sqlfilename', '');
                }
                if (empty($files)) {
                    $this->error('请选择要删除的sql文件');
                }
                foreach ($files as $file) {
                    $a = unlink(UPLOAD_PATH . "sqldata" . '/' . $file . ".sql");
                }
                if ($a) {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(6, "删除表" . I('tablename', '') . "成功",5);
                    $this->success("已删除：" . implode(",", $files), U('Admin/Tools/restore/action/page_list'));
                } else {
                    //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                    $this->logRecord(5, "删除表" . I('tablename', '') . "成功",5);
                    $this->error("删除失败：" . implode(",", $files), U('Admin/Tools/restore/action/page_list'));
                }
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",-1);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                json_return($returnArr);
        }

    }

    /**
     * 读取要导入的sql文件列表并排序后插入SESSION中
     */
    private function getRestoreFiles()
    {
        $sqlfilepre = I('sqlfilepre', '');//获取sql文件前缀
        if (empty($sqlfilepre)) {
            $this->error('请选择要还原的数据文件！');
        }
        $pattern = $sqlfilepre . "*.sql";
        $sqlFiles = glob(UPLOAD_PATH . "sqldata/" . $pattern);
        if (empty($sqlFiles)) {
            $this->error('不存在对应的SQL文件！');
        }

        //将要还原的sql文件按顺序组成数组，防止先导入不带表结构的sql文件
        $files = array();
        foreach ($sqlFiles as $sqlFile) {
            $sqlFile = basename($sqlFile);
            $k = str_replace(".sql", "", str_replace($sqlfilepre . "_", "", $sqlFile));
            $files[$k] = $sqlFile;
        }
        unset($sqlFiles, $sqlfilepre);
        ksort($files);
        return $files;
    }

////////////////////////暂时没用到
    public function backup()
    {
        $M = M();
        //防止备份数据过程超时
        function_exists('set_time_limit') && set_time_limit(0);
        send_http_status('310');
        $tables = I('tables', array());
        if (empty($tables)) {
            $this->error('请选择要备份的数据表');
        }

        $time = time();//开始时间
        if (!file_exists(UPLOAD_PATH . 'sqldata')) {
            mkdir(UPLOAD_PATH . 'sqldata');
        }
        $path = UPLOAD_PATH . "sqldata/tpshop_tables_" . date("Ymd") . get_rand_str(3, 0);

        $pre = "# -----------------------------------------------------------\n";
        //取得表结构信息
        //1，表示表名和字段名会用``包着的,0 则不用``

        M()->execute("SET SQL_QUOTE_SHOW_CREATE = 1");
        $outstr = '';
        foreach ($tables as $table) {
            $outstr .= "# 表的结构 {$table} \n";
            $outstr .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $tmp = $M->query("SHOW CREATE TABLE {$table}");
            $outstr .= $tmp[0]['create table'] . " ;\n\n";
        }

        $sqlTable = $outstr;
        $outstr = "";
        $file_n = 1;
        $backedTable = array();
        //表中的数据
        foreach ($tables as $table) {
            $backedTable[] = $table;
            $outstr .= "\n\n# 转存表中的数据：{$table} \n";
            $tableInfo = $M->query("SHOW TABLE STATUS LIKE '{$table}'");
            $page = ceil($tableInfo[0]['rows'] / 10000) - 1;
            for ($i = 0; $i <= $page; $i++) {
                $query = $M->query("SELECT * FROM {$table} LIMIT " . ($i * 10000) . ", 10000");
                foreach ($query as $val) {
                    $temSql = "";
                    $tn = 0;
                    $temSql = '';
                    foreach ($val as $v) {
                        $temSql .= $tn == 0 ? "" : ",";
                        $temSql .= $v == '' ? "''" : "'{$v}'";
                        $tn++;
                    }
                    $temSql = "INSERT INTO `{$table}` VALUES ({$temSql});\n";

                    $sqlNo = "\n# Time: " . date("Y-m-d H:i:s") . "\n" .
                        "# -----------------------------------------------------------\n" .
                        "# SQLFile Label：#{$file_n}\n# -----------------------------------------------------------\n\n\n";
                    if ($file_n == 1) {
                        $sqlNo = "# Description:备份的数据表[结构]：" . implode(",", $tables) . "\n" .
                            "# Description:备份的数据表[数据]：" . implode(",", $backedTable) . $sqlNo;
                    } else {
                        $sqlNo = "# Description:备份的数据表[数据]：" . implode(",", $backedTable) . $sqlNo;
                    }

                    if (strlen($pre) + strlen($sqlNo) + strlen($sqlTable) + strlen($outstr) + strlen($temSql) > C("CFG_SQL_FILESIZE")) {
                        $file = $path . "_" . $file_n . ".sql";
                        $outstr = $file_n == 1 ? $pre . $sqlNo . $sqlTable . $outstr : $pre . $sqlNo . $outstr;

                        if (!file_put_contents($file, $outstr, FILE_APPEND)) {
                            $this->error("备份文件写入失败！", U('Tools/index'));
                        }

                        $sqlTable = $outstr = "";
                        $backedTable = array();
                        $backedTable[] = $table;
                        $file_n++;
                        dump($file_n);
                        exit;
                    }
                    $outstr .= $temSql;
                }
            }
        }
        if (strlen($sqlTable . $outstr) > 0) {
            $sqlNo = "\n# Time: " . date("Y-m-d H:i:s") . "\n" .
                "# -----------------------------------------------------------\n" .
                "# SQLFile Label：#{$file_n}\n# -----------------------------------------------------------\n\n\n";
            if ($file_n == 1) {
                $sqlNo = "# Description:备份的数据表[结构] " . implode(",", $tables) . "\n" .
                    "# Description:备份的数据表[数据] " . implode(",", $backedTable) . $sqlNo;
            } else {
                $sqlNo = "# Description:备份的数据表[数据] " . implode(",", $backedTable) . $sqlNo;
            }
            $file = $path . "_" . $file_n . ".sql";
            $outstr = $file_n == 1 ? $pre . $sqlNo . $sqlTable . $outstr : $pre . $sqlNo . $outstr;
//			exit($file);
            if (!file_put_contents($file, $outstr, FILE_APPEND)) {
                $this->error("备份文件写入失败！", U('Tools/index'));
            }
            $file_n++;
        }

        $time = time() - $time;
        exit(json_encode(array('stat' => 'ok', 'msg' => "成功备份数据表，本次备份共生成了" . ($file_n - 1) . "个SQL文件。耗时：{$time} 秒")));
    }

/////////////////////////

    public function region()
    {
        $action = $_GET["action"];
        $getId = $_GET["id"];
        $postId = $_POST["id"];
        $getData = I("get.");
        $postData = I("post.");
        switch ($action) {
            //地区管理
            case "page_list":
                $parent_id = I('parent_id', 0);
                if ($parent_id == 0) {
                    $parent = array('id' => 0, 'name' => "中国省份地区", 'level' => 0);
                } else {
                    $parent = M('SystemRegion')->where("id=$parent_id")->find();
                }
                $region = M('SystemRegion')->where("parent_id=$parent_id")->select();

                $this->assign('parent', $parent);
                $this->assign('pid', $parent_id);
                $this->assign('region', $region);
                $this->display('region_list');
                break;
            case "page_add":
                $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("Tools/region");
                $data['level'] = $postData['level'] + 1;
                if (empty($postData['name'])) {
                    $this->error("请填写地区名称", $referurl);
                } else {
                    $res = M('SystemRegion')->where("parent_id = " . $postData['parent_id'] . " and name='" . $postData['name'] . "'")->find();
                    if (empty($res)) {
                        M('SystemRegion')->add($postData);
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "添加地区" . $postData["name"] . "成功",3);
                        $this->success("保存成功", $referurl);
                    } else {
                        $this->error("该区域下已有该地区,请不要重复添加", $referurl);
                    }
                }
                break;
            //编辑  地区名
            case "page_edit":
                $id = I('get.id') ? $_GET['id'] : 0;
                $pid = I('get.pid');
                $model = M('SystemRegion');
                if (IS_POST) {
                    $val = I('post.');
                    $url = U('Admin/Tools/region', array('parent_id' => $val['pid']));
                    $res = $model->where(array('id' => $val['id']))->setField(array('name' => $val['name']));
                    if ($res) {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(6, "修改地区" . $postData["name"] . "成功",4);
                        $this->success("保存成功", $url);
                    } else {
                        //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                        $this->logRecord(5, "修改地区" . $postData["name"] . "失败",4);
                        $this->error("修改失败");
                    }
                    exit;
                }
                $list = $model->where(array('id' => $id))->find();
                $this->assign('list', $list);
                $this->assign('pid', $pid);
                $this->display('region_info');
                break;
            case "del":
                $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("Tools/region");
                $data['level'] = $postData['level'] + 1;
                $logData = M('SystemRegion')->where("id=$postId or parent_id=$postId")->find();
                M('SystemRegion')->where("id=$postId or parent_id=$postId")->delete();
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(6, "修改地区" . $logData["name"] . "成功",4);
                $this->success("保存成功", $referurl);
                break;
            default:
                //日志记录，参数：级别，字符串（你拼接的字符串与后台拼接，后台字符串为（进行？？操作），？？为你的字符串）
                $this->logRecord(5, "非法操作，试图访问权限设定以外的其他方法",4);
                $returnArr = array("result" => 0, "msg" => "请求错误，请求方法参数设置有误", "code" => 402, "data" => null);
                json_return($returnArr);
        }
    }

    public function addRegion()
    {
        $data = I('post.');
        $id = I('id');
        $this->regionHandle($data, $id);
    }

    public function delRegion()
    {
        $data = I('post.');
        $id = I('id');
        $this->regionHandle($data, $id);
    }

    public function regionHandle($data, $id)
    {
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("Tools/region");
        if (empty($id)) {
            $data['level'] = $data['level'] + 1;
            if (empty($data['name'])) {
                $this->error("请填写地区名称", $referurl);
            } else {
                $res = M('SystemRegion')->where("parent_id = " . $data['parent_id'] . " and name='" . $data['name'] . "'")->find();
                if (empty($res)) {
                    M('SystemRegion')->add($data);
                    $this->success("操作成功", $referurl);
                } else {
                    $this->error("该区域下已有该地区,请不要重复添加", $referurl);
                }
            }
        } else {
            M('SystemRegion')->where("id=$id or parent_id=$id")->delete();
            $this->success("操作成功", $referurl);
        }
    }
}
