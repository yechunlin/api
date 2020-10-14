<?php
namespace app\hsxz\model;

use think\Model;

class ClassModel extends Model
{

	protected $table = 'class';

	public function getClassInfo($where=[], $fields='*')
	{
		$res = ClassModel::where($where)
			->field($fields)
			->findOrEmpty();
		return $res;
	}

	public function getClass($where=[], $page=1, $limit=10, $sort=1)
	{
	    $order = !intval($sort) ? 'asc' : 'desc';
		$res = ClassModel::where($where)
			->field('*')
			->order('id', $order)
			->page($page, $limit)
			->select();
		return $res;
	}

	public function getCount($where=[])
    {
        return ClassModel::where($where)->count('id');
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

	public function updateClass($where=[], $data=[])
    {
        return ClassModel::where($where)->update($data);
    }


    public function getLikeClass($where=[], $likeWhere=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = ClassModel::where($where)
            ->whereLike($likeWhere)
            ->field('*')
            ->order('id', $order)
            ->page($page, $limit)
            ->select();
        return $res;
    }

    public function getLikeCount($where=[], $likeWhere=[])
    {
        return ClassModel::where($where)
            ->whereLike($likeWhere)
            ->count('id');
    }

}