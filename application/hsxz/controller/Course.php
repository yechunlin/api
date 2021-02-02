<?php
namespace app\hsxz\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\hsxz\model\ClassModel;
use app\hsxz\model\UserModel;
use app\hsxz\model\CourseModel;
use think\Validate;

class Course extends MyController
{
	private $course_model;
	public function __construct()
	{
		$this->course_model = new CourseModel();
	}

    /**
     * 根据ID获取课程详情
     * @param id int
     * @return \think\response\Json
     */
	public function getCourseInfo()
	{
	    $params = Request::only(['id'], 'get');
        $validate   = Validate::make([
            'id|课程ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$res = $this->course_model->getCourseInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->notFoundError();
	}


    /**
     * 获取课程列表
     */
    public function getCourse()
    {
        $params = Request::only([
            'class_id' => 0,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate = Validate::make([
            'class_id|班级ID' => 'integer',
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'status' => 1,
            'class_id' => $params['class_id']
        ];
        $count = $this->course_model->getCount($where);
        $list  = $this->course_model->getCourse($where, $params['page'], $params['limit']);

		$classModel = new ClassModel();
		$userModel = new UserModel();
		foreach($list as $key => &$val){
			$tmp = $classModel->getClassInfo(['id' => $val['class_id']]);
			$val['class_name'] = $tmp['name'];
			$tmp = $userModel->getUserInfo(['id' => $val['teacher_id']]);
			$val['teacher_name'] = $tmp['username'];
			$tmp = $userModel->getUserInfo(['id' => $val['admin_id']]);
			$val['admin_name'] = $tmp['username'];
		}
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

    function getVideo(){
        $params = Request::only(['id'], 'get');
        $validate   = Validate::make([
            'id|课程ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $res = $this->course_model->getCourseInfo(['id' => $params['id']]);
        if(!$res)
        {
            return $this->notFoundError();
        }
        $localfile = str_replace('..', 'C:\phpstudy_pro\WWW\\', $res['video']);
        $size = filesize($localfile);

        $start = 0;
        $end = $size - 1;
        $length = $size;
        
        header("Accept-Ranges: 0-$size");
        header("Content-Type: video/mp4");
        
        $ranges_arr = array();
        if (isset($_SERVER['HTTP_RANGE'])) {
            if (!preg_match('/^bytes=\d*-\d*(,\d*-\d*)*$/i', $_SERVER['HTTP_RANGE'])) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
            }
            $ranges = explode(',', substr($_SERVER['HTTP_RANGE'], 6));
            foreach ($ranges as $range) {
                $parts = explode('-', $range);
                $ranges_arr[] = array($parts[0],$parts[1]);
            }
        
            $ranges = $ranges_arr[0];
            if($ranges[0]==''){
                if($ranges[1]!=''){
                    //Range: bytes=-n 表示取文件末尾的n个字节
                    $length = (int)$ranges[1];
                    $start = $size - $length;
                }else{
                    //Range: bytes=- 这种形式不合法
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                }
            }else{
                $start = (int)$ranges[0];
                if($ranges[1]!=''){
                    //Range: bytes=n-m 表示从文件的n偏移量读到m偏移量
                    $end = (int)$ranges[1];
                }
                //Range: bytes=n- 表示从文件的n偏移量读到末尾
                $length = $end - $start + 1;
            }
            header('HTTP/1.1 206 PARTIAL CONTENT');
        }
        
        header("Content-Range: bytes {$start}-{$end}/{$size}");
        header("Content-Length: $length");
        
        $buffer = 1024*1024;
        $file = fopen($localfile, 'rb');
        if($file){
            fseek($file, $start);
            while (!feof($file) && ($p = ftell($file)) <= $end){
                if ($p + $buffer > $end) {
                    $buffer = $end - $p + 1;
                }
                set_time_limit(0);
                echo fread($file, $buffer);
                flush();
            }
            fclose($file);
        }
    }
}