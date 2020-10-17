<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;
use app\hsxz\model\UserModel;

class User extends Controller
{
	private $User_model;
	public function __construct()
	{
		$this->User_model = new UserModel();
	}

	public function getUserInfo()
	{
		$id = Request::get('id');
		$res = $this->User_model->getUserInfo(['id' => $id]);
		return json([
			'code' => 20000,
			'data' => $res
		]);
	}

	public function addUser()
	{
		$p = Request::post();
		$res = $this->User_model->addUser($p, true);
		if($res)
		{
			return json(['status' => $res]);
		}
	}

}