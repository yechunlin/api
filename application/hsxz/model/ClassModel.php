<?php
namespace app\hsxz\model;

use think\Model;

class ClassModel extends Model
{

	protected $table = 'class';

	public function getClass($where=[], $fields='*')
	{
		$res = ClassModel::where($where)
			->field($fields)
			->findOrEmpty();
		return $res;
	}

	public function getClassByPage($where=[], $fields='*', $page=1, $limit=10)
	{
		$res = ClassModel::where($where)
			->field($fields)
			->order('id', 'desc')
			->page($page, $limit)
			->select();
		return $res;
	}

	public function addClass($params=[], $incId = false)
	{
		$res = ClassModel::insert($params);
		if($incId)
		{
			return ClassModel::getLastInsID();
		}
		return $res;
	}

}