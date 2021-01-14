<?php
namespace app\admin\controller;

use app\common\controller\AdminController;
use think\facade\Request;
use app\admin\model\VideoModel;
use think\Validate;

class Video extends AdminController
{
	private $video_model;
	public function __construct()
	{
        parent::__construct();
		$this->video_model = new VideoModel();
	}

    /**
     * 根据ID获取视频详情
     * @param id int
     * @return \think\response\Json
     */
	public function getVideoInfo()
	{
        $params = Request::only(['id'], 'get');
        $validate   = Validate::make([
            'id|视频ID' => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$res = $this->video_model->getVideoInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->serviceError();
	}

    /**
     * 添加视频
     */
	public function addVideo()
	{
        $params = Request::only(['path', 'class_id', 'course_id', 'admin_id'], 'post');
        $validate   = Validate::make([
            'path|视频地址' => 'require',
            'class_id|班级ID' => 'require|integer',
            'course_id|课程ID' => 'require|integer',
            'admin_id|管理员ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $params['dated'] = date('Y-m-d H:i:s');
		$res = $this->video_model->addVideo($params, true);
		if($res)
		{
            $params['id'] = $res;
            $classModel = new \app\admin\model\ClassModel();
            $courseModel = new \app\admin\model\CourseModel();
            $userModel = new \app\admin\model\UserModel();
            $tmp = $classModel->getClassInfo(['id' => $params['class_id']], 'name');
            $params['class_name'] = $tmp['name'];
            $tmp = $courseModel->getCourseInfo(['id' => $params['course_id']], 'title');
            $params['course_name'] = $tmp['title'];
            $tmp = $userModel->getUserInfo(['id' => $params['admin_id']], 'username');
            $params['admin_name'] = $tmp['username'];
            return $this->_success($params);
		}
        return $this->serviceError();
	}

    /**
     * 获取视频列表
     */
    public function getVideo()
    {
        $params = Request::only([
            'id'    => 0,
            'class_id' => 0,
            'course_id'=> 0,
            'status' => 1,
            'sort'  => 1,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|视频ID' => 'integer',
            'class_id|班级ID'=> 'integer',
            'course_id|课程ID'=> 'integer',
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
        }else{
            if($params['class_id']){
                $where['class_id'] = $params['class_id'];
            }
            if($params['course_id']){
                $where['course_id'] = $params['course_id'];
            }
        }
        $count = $this->video_model->getCount($where);
        $list  = $this->video_model->getVideo($where, $params['page'], $params['limit'], $params['sort']);

        $classModel = new \app\admin\model\ClassModel();
        $courseModel = new \app\admin\model\CourseModel();
        $userModel = new \app\admin\model\UserModel();
        foreach($list as $key => &$val){
            $tmp = $classModel->getClassInfo(['id' => $val['class_id']], 'name');
            $val['class_name'] = $tmp['name'];
            $tmp = $courseModel->getCourseInfo(['id' => $val['course_id']], 'title');
            $val['course_name'] = $tmp['title'];
            $tmp = $userModel->getUserInfo(['id' => $val['admin_id']], 'username');
            $val['admin_name'] = $tmp['username'];
        }
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

    /**
     * 修改视频信息
     */
    public function updateVideo()
    {
        $params = Request::only(['id', 'path', 'class_id', 'course_id'], 'post');
        $validate   = Validate::make([
            'id|视频id'  => 'require|integer',
            'path|视频地址' => 'require',
            'class_id|班级ID' => 'require|integer',
            'course_id|课程ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'path' => $params['path'],
			'class_id' => $params['class_id'],
			'course_id' => $params['course_id']
        ];
        $res = $this->video_model->updateVideo($where, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->serviceError();
    }

    /**
     * 删除视频信息
     */
    public function deleteVideo()
    {
        $params = Request::only(['id'], 'post');
        $validate   = Validate::make([
            'id|视频id'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->video_model->updateVideo($where, $data);
        if($res)
        {
            $this->_success($params);
        }
        return $this->serviceError();
    }
}