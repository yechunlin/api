<?php
namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;
use think\Validate;
use app\admin\model\UserModel;
use myextend\Edcrypt;

class User extends MyController
{
	private $user_model;
	public function __construct()
	{
		parent::__construct();
		$this->user_model = new UserModel();
	}

	public function login()
	{
        $params = Request::only(['username','password'], 'post');
        $validate = Validate::make([
            'username|用户名'  => 'require',
            'password|密码'   => 'require'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$where = [
			'username' => $params['username'],
			'password' => md5($params['password']),
            'status' => 1
		];
		$user = $this->user_model->getUserInfo($where, 'id');
		if($user)
		{
		    $edcrypt = new Edcrypt();
			$token = $edcrypt->encrypt($user['id'].'_'. ( time() + 3600 ).'_'.md5($user['id']));
			$res = $this->user_model->updateUser(['id' => $user['id']], [
				'lastdated' => date('Y-m-d H:i:s')
			]);
			if($res)
			{
			    return $this->_success([
                    'token' => $token,
                    'user_id' => $user['id']
                ]);
			}
            return $this->serviceError();
        }
        return $this->notFoundError();
	}

	public function info()
	{
        $params = Request::only(['user_id', 'token'], 'get');
        $validate   = Validate::make([
            'user_id|用户id'   => 'require|integer',
            'token|令牌'   => 'require'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $user = $this->user_model->getUserInfo(['id' => $params['user_id']], 'username,avatar');
        if($user)
        {
            $user['roles'] = ['admin'];
            return $this->_success($user);
        }
        return $this->_error(4003, 403, '非法令牌');
	}

	public function getUser()
    {
        $params = Request::only([
            'id'    => 0,
            'username' => '',
            'status'=> 1,
            'sort'  => 1,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|用户ID' => 'integer',
            'username|昵称'=> 'max:20',
            'status'   => 'integer',
            'sort'     => 'integer',
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = ['status' => $params['status']];
        if($params['id'])
        {
            $where['id'] = $params['id'];
        }
        if($params['username'])
        {
            $likeWhere = [
                ['field' => 'username', 'value' => $params['username']]
            ];
            $count = $this->user_model->getLikeCount($where, $likeWhere);
            $list  = $this->user_model->getLikeUser($where, $likeWhere, $params['page'], $params['limit'], $params['sort']);
        }else{
            $count = $this->user_model->getCount($where);
            $list  = $this->user_model->getUser($where, $params['page'], $params['limit'], $params['sort']);
        }
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

    public function logout()
    {
        return $this->_success();
    }

    public function updateUser()
    {
        $params = Request::only(['id', 'username', 'avatar'], 'post');
        $validate   = Validate::make([
            'id|用户ID' => 'require|integer',
            'username|昵称'=> 'require|max:20',
            'avatar|图像'  => 'require',
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $data = [
            'username' => $params['username'],
            'avatar' => $params['avatar']
        ];
        $res = $this->user_model->updateUser(['id' => $params['id']], $data);
        if($res)
        {
            return $this->_success($data);
        }
        return $this->serviceError();
    }
}