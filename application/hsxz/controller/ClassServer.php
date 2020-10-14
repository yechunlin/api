<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;
use app\hsxz\model\ClassModel;

class ClassServer extends Controller
{
	private $class_model;
	public function __construct()
	{
		$this->class_model = new ClassModel();
	}

    /**
     * 根据ID获取班级详情
     * @param id int
     * @return \think\response\Json
     */
	public function getClassInfo()
	{
		$id = Request::get('id');
		$res = $this->class_model->getClassInfo(['id' => $id]);
		return json([
			'code' => 20000,
			'data' => $res
		]);
	}

    /**
     * 添加班级
     */
	public function addClass()
	{
		$p = Request::post();
		$p['dated'] = date('Y-m-d H:i:s');
		$res = $this->class_model->addClass($p, true);
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
     * 获取班级列表
     */
    public function getClass()
    {
        $status = Request::get('status', 1);
        $sort = Request::get('sort', 1);
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 10);
        $where = ['status' => $status];
        $count = $this->class_model->getCount($where);
        $list = $this->class_model->getClass($where, $page, $limit, $sort);
        return json([
            'code' => 20000,
            'data' => [
                'total' => $count,
                'items' => $list
            ]
        ]);
    }

    /**
     * 搜索班级
     */
    public function searchClass()
    {
        $id = Request::get('id');
        $name = Request::get('name');
        $status = Request::get('status', 1);
        $sort = Request::get('sort', 1);
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 10);
        $where = ['status' => $status];
        if($id)
        {
            $where['id'] = $id;
        }
        if($name)
        {
            $likeWhere['name'] = "%{$name}%";
            $count = $this->class_model->getLikeCount($where, $likeWhere);
            $list = $this->class_model->getLikeClass($where, $likeWhere, $page, $limit, $sort);
            return json([
                'code' => 20000,
                'data' => [
                    'total' => $count,
                    'items' => $list
                ]
            ]);
        }
        $count = $this->class_model->getCount($where);
        $list = $this->class_model->getClass($where, $page, $limit, $sort);
        return json([
            'code' => 20000,
            'data' => [
                'total' => $count,
                'items' => $list
            ]
        ]);
    }

    /**
     * 修改班级信息
     */
    public function updateClass()
    {
        $p = Request::post();
        $where = [
            'id' => $p['id']
        ];
        $data = [
            'name' => $p['name'],
            'description' => $p['description']
        ];
        $res = $this->class_model->updateClass($where, $data);
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
     * 删除班级信息
     */
    public function deleteClass()
    {
        $p = Request::post();
        $where = [
            'id' => $p['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->class_model->updateClass($where, $data);
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