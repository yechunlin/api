<?php
namespace app\hsxz\model;

use think\Model;

class UserModel extends Model
{

	protected $table = 'user';

	public function __construct()
	{

	}
	public function addUser($params=[], $incId = false)
	{
		$res = UserModel::insert($params);
		return $res;
	}

	public function getUserInfo($where=[])
	{
		return UserModel::where($where)->limit(1)->select();
	}

	public function updateUser($where=[], $data=[])
    {
        return UserModel::where($where)->update($data);
    }
}