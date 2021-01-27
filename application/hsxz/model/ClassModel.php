<?php
namespace app\hsxz\model;

use think\Model;

class ClassModel extends Model
{

	protected $table = 'class';

	public function getClass($where=[], $page=1, $limit=10, $field='*')
	{
		$res = ClassModel::where($where)
			->field($field)
			//->order('id', 'desc')
			->page($page, $limit)
			->select();
		return $res;
	}

	public function getCount($where=[])
    {
        return ClassModel::where($where)->count('id');
    }

}