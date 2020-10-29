<?php
namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\admin\model\CourseModel;
use think\Validate;

class Course extends MyController
{
	private $course_model;
	public function __construct()
	{
        parent::__construct();
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
     * 添加课程
     */
	public function addCourse()
	{
        $params = Request::only([
            'title' => '',
            'cover' => '',
            'class_id' => 0,
            'video_id' => 0,
            'teacher_id' => 0,
            'admin_id' => 0
        ], 'post');
        $validate = Validate::make([
            'title|标题' => 'require|max:30',
            'cover|封面图' => 'require',
            'class_id|班级ID' => 'require|integer',
            'video_id|视频ID' => 'integer',
            'teacher_id|教师ID' => 'require|integer',
            'admin_id|管理员ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$res = $this->course_model->addCourse($params, true);
		if($res)
		{
		    $params['id'] = $res;
 			return $this->_success($params);
		}
		return $this->serviceError();
	}

    /**
     * 获取课程列表
     */
    public function getCourse()
    {
        $params = Request::only([
            'id'    => 0,
            'class_id' => 0,
            'title' => '',
            'status'=> 1,
            'sort'  => 1,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|课程ID' => 'integer',
            'class_id|班级ID' => 'integer',
            'title|标题'=> 'max:20',
            'status'   => 'integer',
            'sort'     => 'integer',
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = ['status' => $params['status']];
        if($params['id'])
        {
            $where['id'] = $params['id'];
            $count = $this->course_model->getCount($where);
            $list  = $this->course_model->getCourse($where, $params['page'], $params['limit'], $params['sort']);
        }else{
            if($params['class_id']){
                $where['class_id'] = $params['class_id'];
            }
            if($params['title']){
                $likeWhere = [
                    ['field' => 'title', 'value' => $params['title']]
                ];
                $count = $this->course_model->getLikeCount($where, $likeWhere);
                $list  = $this->course_model->getLikeCourse($where, $likeWhere, $params['page'], $params['limit'], $params['sort']);
            }else{
                $count = $this->course_model->getCount($where);
                $list  = $this->course_model->getCourse($where, $params['page'], $params['limit'], $params['sort']);
            }
        }

		$classModel = new \app\admin\model\ClassModel();
		$userModel = new \app\admin\model\UserModel();
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

    /**
     * 修改课程信息
     */
    public function updateCourse()
    {
        $params = Request::only(['id', 'title', 'cover', 'class_id', 'video_id', 'teacher_id', 'admin_id'], 'post');
        $validate   = Validate::make([
            'id|课程id'  => 'require|integer',
            'title|标题' => 'require|max:30',
            'cover|封面图' => 'require',
            'class_id|班级ID' => 'require|integer',
            'video_id|视频ID' => 'integer',
            'teacher_id|教师ID' => 'require|integer',
            'admin_id|管理员ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'title' => $params['title'],
            'cover' => $params['cover'],
			'class_id' => $params['class_id'],
			'video_id' => $params['video_id'],
			'teacher_id' => $params['teacher_id'],
			'admin_id' => $params['admin_id']
        ];
        $res = $this->course_model->updateCourse($where, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->serviceError();
    }

    /**
     * 删除课程信息
     */
    public function deleteCourse()
    {
        $params = Request::only(['id'], 'post');
        $validate   = Validate::make([
            'id|课程ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $data = [
            'status' => 0,
        ];
        $res = $this->course_model->updateCourse($params, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->serviceError();
    }
}