<?php
namespace Mobile\Controller;
use Think\Controller;
use Think\Log;

class StartTestController extends BaseController{

    public function __construct()
    {
        parent::__construct();
        parent::checkUrl();
    }


    //测试题目列表
    public function testList() {
        $this->display('test_list');
    }

    //档案列表
    public function archives() {
        $testId = $_GET['id'];
        $this->assign('test_id',$testId);
        $this->display('archives');
    }

    //新建档案
    public function newArchives() {
        $testId = $_GET['test_id'];//测试题目id
        $this->assign('test_id',$testId);
        $this->display('new_archives');
    }
    //从已有档案进入测试
    public function archivesTest() {
        $testId = $_GET['test_id'];//测试题目id
        $gradeId = $_GET['grade_id'];
        $classId = $_GET['class_id'];
        if($gradeId == null || $classId == null ){
            $gradeId = -1;
            $classId = -1;
        }
        $testTitle = M("TestWeifan")->where("id = $testId")->getfield("title");
        $this->assign('grade_id',$gradeId);
        $this->assign('class_id',$classId);
        $this->assign('test_id',$testId);
        $this->assign('test_title',$testTitle);
        $archives_id = $_GET['archives_id'];
        $this->assign('archives_id',$archives_id);
        $this->display('archives_test');
    }

    //开始测试
    public function startTest() {
        $archives_id = $_GET['archives_id'];
       
        $testTitle = M("TestWeifan")->where("id = {$_SESSION['testData']['test_id']}")->getfield("title");
        $testCount = M("TestTopicsWeifan")->where("test_id = {$_SESSION['testData']['test_id']}")->count();
        $school = M("WeifanSchool")->where("id = {$_SESSION['testData']['school_id']}")->getField("name");
        $grade = M("WeifanGrade")->where("id = {$_SESSION['testData']['grade_id']}")->getField("name");
        $class = M("WeifanClass")->where("id = {$_SESSION['testData']['class_id']}")->getField("name");
        $student = M("WeifanStudent")->where("id = {$_SESSION['testData']['student_id']}")->find();
        $school = $school.$grade.$class;

        $testId = $_GET['test_id'];//测试题目id
        $this->assign('test_id',$testId);
        $this->assign('archives_id',$archives_id);
        $this->assign('doctor_id', $_SESSION['adminInfo']['admin_id']);
        $this->assign('test_title',$testTitle);
        $this->assign('test_id',$_SESSION['testData']['test_id']);
        $this->assign('test_count',$testCount);
        $this->assign('school',$school);
        $this->assign('grade_id',$_SESSION['testData']['grade_id']);
        $this->assign('class_id',$_SESSION['testData']['class_id']);
        $this->assign('student',$student);
        $this->display('start_test');
    }

    //提交测试结果
    public function testAnswer() {
        $postData = I("post.");
        $company_id = $_GET['company_id'];
        $userId =  session('userArr')['user_id'];
        $fillIn =  M("UserTest")->where("user_id = '$userId' AND test_id ='$company_id' AND fill_in = 1")->find();
        $i = 0;
        foreach ($postData['answer'] as $value) {
            if(is_array($value)) {
                $m=0;
                foreach ($value as $value2) {
                    $info[$i][$m] = explode('_',$value2);
                    $m++;
                }
            } else {
                $info[$i] = explode('_',$value);
            }

            $i ++ ;
        }
        foreach ($info as $value1) {
            if(is_array($value1[0])) {
              
                $answerRemark = M("TopicAnswerWeifan")->where("topic_id ={$value1[0][0]}  AND id ={$value1[0][1]}")->getField("remarks");
                $data['topic_id'] = $value1[0][0] ;
             
                foreach ($value1 as $value2) {
                    $answer[] = $value2[1];
                }
                $answer1=implode(",",$answer);
                $data['answer'] = $answer1;
            } else {
                if( is_numeric($value1[1])){
                    $answerRemark = M("TopicAnswerWeifan")->where("topic_id ={$value1[0]}  AND id ={$value1[1]}")->getField("remarks");
                } else {
                    $answerRemark = '自主题';
                }

                $data['topic_id'] = $value1[0] ;
                $data['answer'] = $value1[1] ;
            }
            $data['test_id'] = $company_id;
            $data['answer_remark'] = $answerRemark ;
            $data['answer_time'] =  date("Y-m-d H:i:s", time());
           $info1 =  M("TestResultWeifan")->add($data);
        }
        if($info1) {
            $data = array(
              'user_id' => $userId,
                'test_id' => $company_id,
                'fill_in' => 1,
                'create_time' => date("Y-m-d H:i:s",time()),
            );
            M("UserTest")->add($data);
            $returnArr = array("result" => 1, "msg" => "提交成功", "code" => 200, "data" => '');
        }

        json_return($returnArr);
    }

    //数据处理
    public function testData()
    {
        $getAction = $_GET['action'];
        $showType = $_GET['show_type']; //1为学校，2为年级，3为班级，4为学生，5为确认新加档案
        $schoolId = $_GET['school_id'];
        $companyId = $_GET['company_id'];  //企业id，企业对应调查问卷问题
        $testStudentId = $_GET['test_student_id'];
        $gradeId = $_GET['grade_id'];
        $archives_id = $_GET['archives_id'];//档案id
        $recordId = $_GET['record_id'];//档案id
        $classId = $_GET['class_id'];
        $testId = $_GET['test_id'];//测试题目id
        $testNum = $_GET['test_num'];
        $limit_start = $_GET["limit_start"];//从第几条开始
        $limit_end = $_GET["limit_end"];//取几条数据
        $where['is_deleted'] = 0;
        $where['status'] = 1;
        switch ($getAction) {
            //测试列表
            case "test_list":
                $count = M("TestWeifan")->where($where)->count();
                if($limit_start < $count) {
                    $info = M("TestWeifan")
                        ->field("id,title,desc,icon")
                        ->where($where)
                        ->order('id desc')
                        ->limit($limit_start, $limit_end)
                        ->select();
                }
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                //获取指定文章详细信息
                break;
            //档案列表
            case "archives_list":
                $count = M("WeifanRecords")->where($where)->count();
                $doctorId = $_SESSION['adminInfo']['admin_id'];
                if($limit_start < $count) {
                    $info = M("WeifanRecords")->alias('a')
                        ->field("a.id,a.create_time,a.test_num,a.test_title,a.record_name,b.name")
                        ->join('__WEIFAN_SCHOOL__ b on b.id=a.school_id','LEFT')
                        ->where("a.is_deleted!=1 AND a.test_id = '$testId' AND a.doctor_id = '$doctorId'")
                        ->order('a.create_time desc')
                        ->limit($limit_start, $limit_end)
                        ->select();
                }
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                //获取指定文章详细信息
                break;
            //新建档案
            case "new_archives":
                switch ($showType) {
                    case 1 :
                        $schoolId = $_SESSION['adminInfo']['school_id'];
                        $dactorSchool=explode(',',$schoolId);
                        $w = 0;
                        foreach ($dactorSchool as $value) {
                            $school[$w] = M("WeifanSchool")
                                ->field("id,name")
                                ->where("is_deleted != 1 AND id='$value'")
                                ->find();
                            $w++;
                        }
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $school);
                //获取指定文章详细信息
                    break;
                    //年级
                    case 2:
                        if($archives_id) {
                          $info = M("WeifanGrade")
                              ->field("id,name")
                              ->where("school_id = '$archivesSchoolId' AND is_deleted != 1")
                              ->select();

                        }else {
                            $info = M("WeifanGrade")
                                ->field("id,name")
                                ->where("school_id = '$schoolId' AND is_deleted != 1")
                                ->select();
                        }
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        //获取指定文章详细信息
                        break;
                    //班级
                    case 3 :
                        if($archives_id) {
                            $info = M("WeifanClass")
                                ->field("id,name")
                                ->where("school_id = '$archivesSchoolId' AND grade_id = '$gradeId' AND is_deleted != 1")
                                ->select();
                        }else {
                            $info = M("WeifanClass")
                                ->field("id,name")
                                ->where("school_id = '$schoolId' AND grade_id = '$gradeId' AND is_deleted != 1")
                                ->select();
                        }

                     

                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        //获取指定文章详细信息
                        break;
                    //学生
                    case 4 :
                        if($archives_id) {
                            $info = M("WeifanStudent")
                                ->field("id,name")
                                ->where("school_id = '$archivesSchoolId' AND grade_id = '$gradeId' AND class_id = '$classId' AND is_deleted != 1")
                                ->select();
                        }else {
                            $info = M("WeifanStudent")
                                ->field("id,name")
                                ->where("school_id = '$schoolId' AND grade_id = '$gradeId' AND class_id = '$classId' AND is_deleted != 1")
                                ->select();
                        }

                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        //获取指定文章详细信息
                        break;
                    //新建档案->开始测试
                    case 5 :
                     
                            $postData = I("post.");
                            if($postData['school'] == null) {
                                $returnArr = array("result" => 0, "msg" => "学校不能为空", "code" => 200, "data" => 0);
                            } else if($postData['grade'] == null) {
                                $returnArr = array("result" => 0, "msg" => "年级不能为空", "code" => 200, "data" => 0);
                            } else if($postData['class'] == 'moren') {
                                $returnArr = array("result" => 0, "msg" => "班级不能为空", "code" => 200, "data" => 0);
                            } else if($postData['student'] == 'moren') {
                                $returnArr = array("result" => 0, "msg" => "学生不能为空", "code" => 200, "data" => 0);
                            } else {
                                $testTitle = M("TestWeifan")
                                    ->where("is_deleted!=1 AND id = '$testId'")
                                    ->getField("title");
                                $recordCount = M("WeifanRecords")->where("school_id = {$postData['school']} AND test_id = '$testId'AND doctor_id={$_SESSION['adminInfo']['admin_id']} AND is_deleted !=1")->count()+1;
                                $data['doctor_id'] = $_SESSION['adminInfo']['admin_id'];
                                $data['school_id'] = $postData['school'];
                                $data['test_id'] = $testId;
                                $data['create_time'] = date("Y-m-d H:i:s", time());
                                $data['test_title'] = $testTitle;
                                $data['record_name'] = $testTitle.'-'.$recordCount;
                                $recordId = M("WeifanRecords")->add($data);
                                $data['grade_id'] = $postData['grade'];
                                $data['student_id'] = $postData['student'];
                                $data['class_id'] = $postData['class'];
                                session("testData", $data);

                            $returnArr = array("result" => 1, "msg" => "开始测试", "code" => 200, "data" => $recordId);
                        }

                        //获取指定文章详细信息
                        break;
                    //已有档案->开始测试
                    case 6 :

                        $postData = I("post.");
                        if($postData['grade'] == 'moren') {
                            $returnArr = array("result" => 0, "msg" => "年级不能为空", "code" => 200, "data" => 0);
                        } else if($postData['class'] == 'moren') {
                            $returnArr = array("result" => 0, "msg" => "班级不能为空", "code" => 200, "data" => 0);
                        } else if($postData['student'] == 'moren') {
                            $returnArr = array("result" => 0, "msg" => "学生不能为空", "code" => 200, "data" => 0);
                        } else {
                            $testData['doctor_id'] = $_SESSION['adminInfo']['admin_id'];
                            $testData['school_id'] = $archivesSchoolId;
                            $testData['test_id'] = $testId;
                            $testData['record_id'] = $archives_id;
                            $testData['grade_id'] = $postData['grade'];
                            $testData['student_id'] = $postData['student'];
                            $testData['class_id'] = $postData['class'];
                            session("testData", $testData);
                            $returnArr = array("result" => 1, "msg" => "开始测试", "code" => 200, "data" => 0);
                        }

                        //获取指定文章详细信息
                        break;
                    //在测试结果中根据学校年级班级查找测试
                    case 7 :
                        $doctorId = $_SESSION['adminInfo']['admin_id'];
                        $testId = M("TestStudentResultWeifan")->alias('a')
                            ->field("a.test_id")
                            ->where("a.school_id = '$schoolId' AND a.grade_id = '$gradeId' AND a.class_id = '$classId' AND a.doctor_id='$doctorId' AND a.is_deleted != 1")
                            ->select();
                        foreach ($testId as $value) {
                            $testId1[] = $value['test_id'];
                        }
                        $testId1 = array_unique($testId1);
                        $i = 0;
                      foreach ($testId1 as $value) {
                          $testTitle = M("TestWeifan")->where("id = '$value'")->getField("title");
                          $info[$i]['test_id'] = $value;
                          $info[$i]['test_title'] = $testTitle;
                          $i++;
                      }
                    $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        //获取指定文章详细信息
                        break;
                    //在测试结果中获取异常学生数据
                    case 8 :
                        $info = M("TestStudentResultWeifan")->alias('a')
                            ->field("a.id,a.test_num,a.test_error,a.test_right,b.name")
                            ->join('__WEIFAN_STUDENT__ b on b.id=a.student_id','LEFT')
                            ->where("a.id = '$testStudentId'  AND a.is_deleted != 1")
                            ->find();
                        if($info) {
                            $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        } else {
                            $returnArr = array("result" => 0, "msg" => "没有数据", "code" => 200, "data" => 0);
                        }

                        //获取指定文章详细信息
                        break;


                }
                break;
            //进行测试_题目
            case "is_test_topic":
                $info = M("TestTopicsWeifan")->alias('a')
                    ->field("a.test_no,a.topic_id,b.desc,b.title,b.id,b.answer_count,b.topic_type")
                    ->join('__TOPIC_WEIFAN__ b on b.id=a.topic_id','LEFT')
                    ->where("a.test_id = '$companyId'")
                    ->order('a.test_no')
                    ->limit($testNum,1)
                    ->select();
               
                unset ($_SESSION['testTopicId']);
                session('testTopicId',$info[0]['id']);
                $testNo = $testNum+1;
                $topicId = M("TestTopicsWeifan")
                    ->where("test_no = '$testNo'AND test_id = '$companyId'")
                    ->getField("topic_id");
                $infoAnswer = M("TopicAnswerWeifan")
                    ->field("id,title,topic_id,desc,status")
                    ->where(" topic_id= '$topicId'")
                    ->select();
                $i = 0;
                foreach ($infoAnswer as $value) {
                    foreach ($value as $item => $value1) {
                        if($item == 'desc'){
                            $info1[$i][$item] = urlencode($value1);
                        }else {
                            $info1[$i][$item] = $value1;
                            $info1[$i]['test_no'] = $testNo;
                        }

                    }
                    $i++;
                }

                $i = 0;
               foreach ($info as $value) {
                   $topicAswer[$i]= $value;
                   $topicAswer[$i]['answer'] = $info1;
                   $i ++;
               }
                $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $topicAswer);
                //获取指定文章详细信息
                break;
            //结果统计
            case "result_tongji":

                switch ($showType) {
                    //获取该学校下的档案
                    case 1 :
                        $doctorId = $_SESSION['adminInfo']['admin_id'];
                        $info = M("WeifanRecords")
                            ->field("id,record_name")
                            ->where("school_id = '$schoolId' AND doctor_id='$doctorId' AND is_deleted != 1")
                            ->select();
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        //获取指定文章详细信息
                        break;
                    //获取该档案下的年级
                    case 2 :
                        $info = M("TestStudentResultWeifan")
                            ->field("grade_id")
                            ->where("school_id = '$schoolId' AND record_id = '$recordId' AND is_deleted != 1")
                            ->select();
                        foreach ($info as $value) {
                            $info1[] = $value['grade_id'];
                        }
                        $info2 = array_unique($info1);
                        foreach ( $info2 as $value) {
                            $info3[] = M("WeifanGrade")->field("id,name")->where("id = '$value'")->find();
                        }
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info3);
                        //获取指定文章详细信息
                        break;
                    //获取该档案下的班级
                    case 3 :
                        $info = M("TestStudentResultWeifan")
                            ->field("class_id")
                            ->where("school_id = '$schoolId' AND record_id = '$recordId' AND grade_id = '$gradeId' AND is_deleted != 1")
                            ->select();
                        foreach ($info as $value) {
                            $info1[] = $value['class_id'];
                        }
                        $info2 = array_unique($info1);
                        foreach ( $info2 as $value) {
                            $info3[] = M("WeifanClass")->field("id,name")->where("id = '$value'")->find();
                        }
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info3);
                        //获取指定文章详细信息
                        break;
                    //获取该档案下的异常学生的统计
                    case 4 :
                        //该班级下的学生总人数
                        $studentCount = M("WeifanStudent")
                            ->where("school_id = '$schoolId' AND grade_id = '$gradeId' AND class_id = '$classId' AND is_deleted !=1")
                            ->count();
                        //检查的学生总人数
                        $resultCount = M("TestStudentResultWeifan")
                            ->where("school_id = '$schoolId' AND grade_id = '$gradeId' AND class_id = '$classId' AND is_deleted !=1")
                            ->count();
                        //有异常的学生量
                        $errorCount = M("TestStudentResultWeifan")
                            ->where("school_id = '$schoolId' AND grade_id = '$gradeId' AND class_id = '$classId' AND test_error>0 AND is_deleted !=1")
                            ->count();
                        $errorStudent =  M("TestStudentResultWeifan")->alias('a')
                            ->field("a.id,a.test_num,a.test_error,a.test_right,a.student_id,b.name")
                            ->join('__WEIFAN_STUDENT__ b on b.id=a.student_id','LEFT')
                            ->where("a.school_id = '$schoolId' AND a.grade_id = '$gradeId' AND a.class_id = '$classId' AND a.test_error>0 AND a.is_deleted !=1")
                            ->select();
                        $info['student_count'] = $studentCount;
                        $info['result_count'] = $resultCount;
                        $info['error_count'] = $errorCount;
                        $info['error_student'] = $errorStudent;
                        $returnArr = array("result" => 1, "msg" => "获取成功", "code" => 200, "data" => $info);
                        //获取指定文章详细信息
                        break;
                }
                break;
        }
        json_return($returnArr);
    }

    
}