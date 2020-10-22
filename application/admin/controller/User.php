<?php
namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\admin\model\UserModel;
use think\Validate;

class User extends MyController
{
	private $User_model;
	public function __construct()
	{
		$this->User_model = new UserModel();
	}

	public function login()
	{
        $params = Request::only(['username','password'], 'post');
        $validate   = Validate::make([
            'username|用户名'  => 'require',
            'password|密码'   => 'require'
        ]);
        if(!$validate->check($params)) {
            return $this->_error(4000, 400, $validate->getError());
        }
		$where = [
			'username' => $params['username'],
			'password' => md5($params['password']),
            'status' => 1
		];
		$user = $this->User_model->getUserInfo($where);
		if($user)
		{	
			$access_token = md5($params['username'].$params['password']);
			$res = $this->User_model->updateUser(['id' => $user['id']], [
				'lastdated' => date('Y-m-d H:i:s'),
				'access_token' => $access_token
			]);
			if($res)
			{
			    return $this->_success([
                    'token' => $access_token
                ]);
			}
            return $this->_error(5000, 500);
        }
        return $this->_error(4001, 404);
	}

	public function info()
	{
	    $userInfo[md5('admin123456')] = [
            'roles' => ['admin'],
            'introduction' => 'I am a super administrator',
            'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'name' => 'Super Admin'
        ];
        $params = Request::only(['token'], 'get');
        $validate   = Validate::make([
            'token|令牌'   => 'require'
        ]);
        if(!$validate->check($params)) {
            return $this->_error(4000, 400, $validate->getError());
        }
        if(!isset($userInfo[$params['token']])){
            return $this->_error(4003, 403, '非法令牌');
        }
        return $this->_success($userInfo[$params['token']]);
	}

}