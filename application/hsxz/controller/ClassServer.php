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

	public function getClass()
	{
		$id = Request::get('id');
		$res = $this->class_model->getClass(['id' => $id]);
		return json([
			'status' => 1,
			'data' => $res
		]);
	}

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

}