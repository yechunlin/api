<?php
namespace app\admin\controller;

use app\common\controller\AdminController;
use think\facade\Request;
use think\Validate;
use app\admin\model\UserModel;
use myextend\Edcrypt;

class User extends AdminController
{
	private $user_model;
	public function __construct()
	{
		parent::__construct();
		$this->user_model = new UserModel();
	}

    /**
     * 添加用户
     */
	public function addUser()
	{
        $params = Request::only([
            'username' => '',
			'password' => '123456',
			'phone' => '',
			'intro' => '',
			'school' => '',
			'grade' => '',
			'local' => '',
			'type'  => 1,
            'admin_id' => 0
        ], 'post');
        $validate = Validate::make([
            'username|名称' => 'require|max:30',
            'admin_id|管理员ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$params['password'] = md5($params['password']);
		$params['avatar'] = 'http://yechunlin.com/upload/20170902181523_vetXi.jpeg';
		$params['dated'] = date('Y-m-d H:i:s');
		$params['lastdated'] = $params['dated'];
		$res = $this->user_model->addUser($params, true);
		if($res)
		{
		    $params['id'] = $res;
			unset($params['password'] );
 			return $this->_success($params);
		}
		return $this->serviceError();
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
        $user = $this->user_model->getUserInfo(['id' => $params['user_id']], 'id,username,avatar,phone,intro,school,grade,local,type');
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
			'type'  => 1,
            'status'=> 1,
            'sort'  => 1,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|用户ID' => 'integer',
            'username|昵称'=> 'max:20',
            'status'   => 'integer',
			'type'   => 'integer',
            'sort'     => 'integer',
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = ['status' => $params['status'], 'type' => $params['type']];
		$field = 'id,username,avatar,phone,intro,school,grade,local,lastdated,status';
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
            $list  = $this->user_model->getLikeUser($where, $likeWhere, $params['page'], $params['limit'], $params['sort'], $field);
        }else{
            $count = $this->user_model->getCount($where);
            $list  = $this->user_model->getUser($where, $params['page'], $params['limit'], $params['sort'], $field);
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
		$params = Request::only([
			'id' => 0,
            'username' => '',
			'avatar' => '',
			'password' => '',
			'phone' => '',
			'intro' => '',
			'school' => '',
			'grade' => '',
			'local' => '',
            'admin_id' => 0
        ], 'post');
        $validate   = Validate::make([
            'id|用户ID' => 'require|integer',
            'username|昵称'=> 'require|max:20',
            'phone|电话'  => 'require',
			'avatar|头像'  => 'require',
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $data = [
            'username' => $params['username'],
            'avatar' => $params['avatar'],
			'phone' => $params['phone'],
			'intro' => $params['intro'],
			'school' => $params['school'],
			'grade' => $params['grade'],
			'local' => $params['local']
        ];
		if(!empty($params['password'])){
			if(!isset($params['password'][5])){
				return $this->validateError('密码长度要大于等于6');
			}
			$data['password'] = md5($params['password']);
		}
        $res = $this->user_model->updateUser(['id' => $params['id']], $data);
        if($res)
        {
            return $this->_success($data);
        }
        return $this->serviceError();
    }
	
	//获取用户对于路由
	public function getRouter()
	{
		$header = Request::header();
		return $this->_success(['id' => 2]);
	}
}