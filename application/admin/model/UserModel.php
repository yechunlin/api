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
        return UserModel::where($where)->find();
	}

	public function updateUser($where=[], $data=[])
    {
        return UserModel::where($where)->update($data);
    }

    public function getUser($where=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = UserModel::where($where)
            ->field('*')
            ->order('id', $order)
            ->page($page, $limit)
            ->select();
        return $res;
    }

    public function getCount($where=[])
    {
        return UserModel::where($where)->count('id');
    }

    public function getLikeUser($where=[], $likeWhere=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = UserModel::where($where)->where(function ($query) use ($likeWhere){
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
        $res = UserModel::where($where)->where(function($query) use ($likeWhere){
            foreach($likeWhere as $val)
            {
                $query->whereLike($val['field'], "%{$val['value']}%");
            }
        })->count('id');
        return $res;
    }
}