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
	private $Course_model;
	public function __construct()
	{
		$this->Course_model = new CourseModel();
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
            return $this->_error(4000, 400, $validate->getError());
        }
		$res = $this->Course_model->getCourseInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->_error(4001, 404);
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
		$res = $this->Course_model->addCourse($params, true);
		if($res)
		{
		    $p['id'] = $res;
 			return json([
				'code' => 20000,
				'data' => $p
			]);
		}
		$this->_error();
	}

    /**
     * 获取课程列表
     */
    public function getCourse()
    {
        $id = Request::get('id');
        $title = Request::get('title');
        $status = Request::get('status', 1);
        $sort = Request::get('sort', 1);
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 10);
        $where = ['status' => $status];
        if($id)
        {
            $where['id'] = $id;
        }
        if($title)
        {
            $likeWhere = [
				['field' => 'title', 'value' => $title]
			];
            $count = $this->Course_model->getLikeCount($where, $likeWhere);
            $list  = $this->Course_model->getLikeCourse($where, $likeWhere, $page, $limit, $sort);
        }else{
		    $count = $this->Course_model->getCount($where);
			$list  = $this->Course_model->getCourse($where, $page, $limit, $sort);
		}
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
        return json([
            'code' => 20000,
            'data' => [
                'total' => $count,
                'items' => $list
            ]
        ]);
    }

    /**
     * 修改课程信息
     */
    public function updateCourse()
    {
        $p = Request::post();
        $where = [
            'id' => $p['id']
        ];
        $data = [
            'title' => $p['title'],
            'cover' => $p['cover'],
			'class_id' => $p['class_id'],
			'video_id' => $p['video_id'],
			'teacher_id' => $p['teacher_id'],
			'admin_id' => $p['admin_id']
        ];
        $res = $this->Course_model->updateCourse($where, $data);
        if($res)
        {
            return json([
                'code' => 20000,
                'data' => $p
            ]);
        }
        return json([
            'code' => 0,
            'data' => []
        ]);
    }

    /**
     * 删除课程信息
     */
    public function deleteCourse()
    {
        $p = Request::post();
        $where = [
            'id' => $p['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->Course_model->updateCourse($where, $data);
        if($res)
        {
            return json([
                'code' => 20000,
                'data' => $p
            ]);
        }
        return json([
            'code' => 0,
            'data' => []
        ]);
    }
}