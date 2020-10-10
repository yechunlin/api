<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;
use app\hsxz\model\UserModel;

class User extends Controller
{
	private $user_model;
	public function __construct()
	{
		$this->user_model = new UserModel();
	}

	public function getUser()
	{
		$id = Request::get('id');
		 return json(['status' => $id]);
	}

	public function addUser()
	{
		$p = Request::post();
		$res = $this->user_model->addUser($p, true);
		if($res)
		{
			return json(['status' => $res]);
		}
	}

}