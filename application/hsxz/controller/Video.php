<?php
namespace app\hsxz\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\hsxz\model\VideoModel;
use think\Validate;

class Video extends MyController
{
	private $Video_model;
	public function __construct()
	{
		$this->Video_model = new VideoModel();
	}

    /**
     * 根据ID获取视频详情
     * @param id int
     * @return \think\response\Json
     */
	public function getVideoInfo()
	{
		$id = Request::get('id');
		$res = $this->Video_model->getVideoInfo(['id' => $id]);
		return json([
			'code' => 20000,
			'data' => $res
		]);
	}

    /**
     * 添加视频
     */
	public function addVideo()
	{
		$p = Request::post();
		$p['dated'] = date('Y-m-d H:i:s');
		$res = $this->Video_model->addVideo($p, true);
		if($res)
		{
		    $p['id'] = $res;
 			return json([
				'code' => 20000,
				'data' => $p
			]);
		}
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
        $count = $this->Video_model->getCount($where);
        $list  = $this->Video_model->getVideo($where, $params['page'], $params['limit'], $params['sort']);

        $classModel = new \app\hsxz\model\ClassModel();
        $courseModel = new \app\hsxz\model\CourseModel();
        $userModel = new \app\hsxz\model\UserModel();
        foreach($list as $key => &$val){
            $tmp = $classModel->getClassInfo(['id' => $val['class_id']], 'name');
            $val['class_name'] = $tmp['name'];
            $tmp = $courseModel->getCourseInfo(['id' => $val['course_id']], 'title');
            $val['course_name'] = $tmp['title'];
            $tmp = $userModel->getUserInfo(['id' => $val['teacher_id']], 'username');
            $val['teacher_name'] = $tmp['username'];
        }
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

    /**
     * 删除视频信息
     */
    public function deleteVideo()
    {
        $p = Request::post();
        $where = [
            'id' => $p['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->Video_model->updateVideo($where, $data);
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