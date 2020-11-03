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
}