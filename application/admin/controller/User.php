<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use app\hsxz\model\UserModel;
use app\extend\Edcrypt;

class User extends Controller
{
	private $User_model;
	public function __construct()
	{
		$this->User_model = new UserModel();
	}

	public function login()
	{
		$username = Request::post('username');
        $password = md5(Request::post('password'));
		$where = [
			'nickname' => $username,
			'password' => $password
		];
		$user = $this->User_model->getUserInfo($where);
		if($user)
		{	
			$edcrypt = new Edcrypt();
			$access_token = $edcrypt->encrypt(rand(1000, 9999).time().$password);
			$res = $this->User_model->updateUser(['id' => $user['id']], [
				'lastdated' => date('Y-m-d H:i:s'),
				'access_token' => $access_token
			]);
			if($res)
			{
				return json([
					'code' => 20000,
					'data' => [
						'token' => $access_token
					]
				]);
			}else
			{
			    return json([
					'code' => 60204,
					'data' => []
				]);
			}
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