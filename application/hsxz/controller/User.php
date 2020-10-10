<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;

class User extends Controller
{

	public function getUser()
	{
		$id = Request::route('id');
		 return json(['status' => 1]);
	}

}