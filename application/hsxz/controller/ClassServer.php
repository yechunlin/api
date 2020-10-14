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
			'status' => 1,
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
			return json([
				'status' => 1,
				'data' => $res
			]);
		}
	}

    /**
     * 获取班级列表
     */
    public function getClass()
    {
        $status = Request::get('status', 1);
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 10);
        $where = ['status' => $status];
        $count = $this->class_model->getCount($where);
        $list = $this->class_model->getClass($where, $page, $limit);
        return json([
            'status' => 1,
            'data' => [
                'count' => $count,
                'items' => $list
            ]
        ]);
    }
}