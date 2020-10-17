<?php
namespace app\hsxz\model;

use think\Model;

class UserModel extends Model
{

	protected $table = 'user';

	public function getUserInfo($where=[], $fields='*')
	{
		$res = UserModel::where($where)
			->field($fields)
			->findOrEmpty();
		return $res;
	}
	public function addUser($params=[], $incId = false)
	{
		$res = UserModel::insert($params);
		return $res;
	}

}