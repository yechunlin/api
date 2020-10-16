<?php
namespace app\admin\model;

use think\Model;

class UserModel extends Model
{

	protected $table = 'user';

	public function addUser($params=[], $incId = false)
	{
		$res = UserModel::insert($params);
		return $res;
	}

	public function getUserInfo($where=[])
	{
		$res = UserModel::where($where)->limit(1)->select();
		return $res[0];
	}

	public function updateUser($where=[], $data=[])
    {
        return UserModel::where($where)->update($data);
    }
}