<?php

header("Content-type:text/html;charset=utf-8");

function getUserInfo($user_id){
	return D('ManageUsers')->where("user_id=".$user_id)->find();
}

/**
 * 面包屑导航  用于后台管理
 * 根据当前的控制器名称 和 action 方法
 */
function navigate_admin()
{
    $navigate = include APP_PATH.'Common/Conf/navigate.php';
    $location = strtolower('Admin/'.CONTROLLER_NAME);
    $arr = array(
        '后台首页'=>'javascript:void();',
        $navigate[$location]['name']=>'javascript:void();',
        $navigate[$location]['action'][ACTION_NAME]=>'javascript:void();',
    );
    return $arr;
}

/**
 * 导出excel
 * @param $strTable	表格内容
 * @param $filename 文件名
 */
function downloadExcel($strTable,$filename)
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
	header('Expires:0');
	header('Pragma:public');
	echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
}

/**
 * 数组转xls格式的excel文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
$data = array(
array(NULL, 2010, 2011, 2012),
array('Q1',   12,   15,   21),
array('Q2',   56,   73,   86),
array('Q3',   52,   61,   69),
array('Q4',   30,   32,    0),
);
 */
function create_xls($data,$action){
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    if($action == 0) {
        $filename=date("Ymd_",time()).'exportThisPage.xls';
    } else {
        $filename=date("Ymd_",time()).'exportAllPages.xls';
    }

    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}


    function testexcel($data1){
        Vendor('PHPExcel.PHPExcel');
        $filename=date("Ymd_",time()).'exportData.xls';
        $excel = new PHPExcel();
    //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F');
    //表头数组
        $tableheader = array('学号','姓名','性别','年龄','班级','刚刚');
    //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
    
            //表格数组
          /*  $data = array(
                array('1','小王','男','20','100'),
                array('2','小李','男','20','101'),
                array('3','小张','女','20','102'),
                array('4','小赵','女','20','103')
            );*/
        $data = $data1;
    //填充表格信息
            for ($i = 2;$i <= count($data) + 1;$i++) {
                $j = 0;
                foreach ($data[$i - 2] as $key=>$value) {
                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                    $j++;
                }
            }
    
            //创建Excel输入对象
            $write = new PHPExcel_Writer_Excel5($excel);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");;
            header("Content-Disposition:attachment;filename=$filename");
            header("Content-Transfer-Encoding:binary");
            $write->save('php://output');
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 根据id获取地区名字
 * @param $regionId id
 */
function getRegionName($regionId){
    $data = M('SystemRegion')->where(array('id'=>$regionId))->field('name')->find();
    return $data['name'];
}


function tpversion()
{
    if(!empty($_SESSION['isset_push']))
        return false;
    $_SESSION['isset_push'] = 1;
    error_reporting(0);//关闭所有错误报告
    $app_path = dirname($_SERVER['SCRIPT_FILENAME']).'/';
    $version_txt_path = $app_path.'/Application/Admin/Conf/version.txt';
    $curent_version = file_get_contents($version_txt_path);

    $vaules = array(
        'domain'=>$_SERVER['HTTP_HOST'],
        'last_domain'=>$_SERVER['HTTP_HOST'],
        'key_num'=>$curent_version,
        'install_time'=>INSTALL_DATE,
        'cpu'=>'0001',
        'mac'=>'0002',
        'serial_number'=>SERIALNUMBER,
    );
    // $url = "http://service.tp-shop.cn/index.php?m=Home&c=Index&a=user_push&".http_build_query($vaules);
    // stream_context_set_default(array('http' => array('timeout' => 3)));
    //  file_get_contents($url);
}

