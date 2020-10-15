<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;
use app\hsxz\model\CourseModel;

class Course extends Controller
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
		$id = Request::get('id');
		$res = $this->Course_model->getCourseInfo(['id' => $id]);
		return json([
			'code' => 20000,
			'data' => $res
		]);
	}

    /**
     * 添加课程
     */
	public function addCourse()
	{
		$p = Request::post();
		$res = $this->Course_model->addCourse($p, true);
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
     * 获取课程列表
     */
    public function getCourse()
    {
        $status = Request::get('status', 1);
        $sort = Request::get('sort', 1);
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 10);
        $where = ['status' => $status];
        $count = $this->Course_model->getCount($where);
        $list = $this->Course_model->getCourse($where, $page, $limit, $sort);
        return json([
            'code' => 20000,
            'data' => [
                'total' => $count,
                'items' => $list
            ]
        ]);
    }

    /**
     * 搜索课程
     */
    public function searchCourse()
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
			'teacher_id' => $p['teacher_id']
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