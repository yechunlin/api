<?php
namespace app\admin\model;

use think\Model;

class CateModel extends Model
{

	protected $table = 'cate';

	public function getCateInfo($where=[], $fields='*')
	{
		$res = CateModel::where($where)
			->field($fields)
			->find();
		return $res;
	}

	public function getCate($where=[], $page=1, $limit=10, $sort=1)
	{
	    $order = !intval($sort) ? 'asc' : 'desc';
		$res = CateModel::where($where)
			->field('*')
			->order('id', $order)
			->page($page, $limit)
			->select();
		return $res;
	}

	public function getCount($where=[])
    {
        return CateModel::where($where)->count('id');
    }

	public function addCate($params=[], $incId = false)
	{
		$res = CateModel::insert($params);
		if($incId)
		{
			return CateModel::getLastInsID();
		}
		return $res;
	}

	public function updateCate($where=[], $data=[])
    {
        return CateModel::where($where)->update($data);
    }


    public function getLikeCate($where=[], $likeWhere=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = CateModel::where($where)->where(function ($query) use ($likeWhere){
				foreach($likeWhere as $val)
				{
					$query->whereLike($val['field'], "%{$val['value']}%");
				}
		})->field('*')
		->order('id', $order)
		->page($page, $limit)
		->select();
        return $res;
    }

    public function getLikeCount($where=[], $likeWhere=[])
    {
        $res = CateModel::where($where)->where(function($query) use ($likeWhere){
				foreach($likeWhere as $val)
				{
					$query->whereLike($val['field'], "%{$val['value']}%");
				}
		})->count('id');
		return $res;
    }

}