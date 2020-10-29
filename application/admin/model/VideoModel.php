<?php
namespace app\admin\model;

use think\Model;

class VideoModel extends Model
{

	protected $table = 'video';

	public function getVideoInfo($where=[], $fields='*')
	{
		$res = VideoModel::where($where)
			->field($fields)
			->find();
		return $res;
	}

	public function getVideo($where=[], $page=1, $limit=10, $sort=1)
	{
	    $order = !intval($sort) ? 'asc' : 'desc';
		$res = VideoModel::where($where)
			->field('*')
			->order('id', $order)
			->page($page, $limit)
			->select();
		return $res;
	}

	public function getCount($where=[])
    {
        return VideoModel::where($where)->count('id');
    }

	public function addVideo($params=[], $incId = false)
	{
		$res = VideoModel::insert($params);
		if($incId)
		{
			return VideoModel::getLastInsID();
		}
		return $res;
	}

	public function updateVideo($where=[], $data=[])
    {
        return VideoModel::where($where)->update($data);
    }


    public function getLikeVideo($where=[], $likeWhere=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = VideoModel::where($where)->where(function ($query) use ($likeWhere){
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
        $res = VideoModel::where($where)->where(function($query) use ($likeWhere){
				foreach($likeWhere as $val)
				{
					$query->whereLike($val['field'], "%{$val['value']}%");
				}
		})->count('id');
		return $res;
    }

}