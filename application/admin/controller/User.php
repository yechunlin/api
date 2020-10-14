<?php
namespace app\admin\controller;

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

	public function login()
	{
		$username = Request::post('username');
        $password = md5(Request::post('password'));
		if($username === 'admin' && $password == md5('123456'))
		{
		    return json([
                'code' => 20000,
		        'data' => [
		            'token' => md5('admin123456')
                ]
            ]);
        }
        return json([
            'code' => 60204,
            'data' => []
        ]);
	}

	public function info()
	{
	    $userInfo[md5('admin123456')] = [
            'roles' => ['admin'],
            'introduction' => 'I am a super administrator',
            'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'name' => 'Super Admin'
        ];
		$token = Request::get('token');
		return json([
		    'code' => 20000,
            'data' => $userInfo[$token]
        ]);
	}

}