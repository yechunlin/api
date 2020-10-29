<?php
namespace app\admin\model;

use think\Model;

class CourseModel extends Model
{

	protected $table = 'course';

	public function getCourseInfo($where=[], $fields='*')
	{
		$res = CourseModel::where($where)
			->field($fields)
			->find();
		return $res;
	}

	public function getCourse($where=[], $page=1, $limit=10, $sort=1)
	{
	    $order = !intval($sort) ? 'asc' : 'desc';
		$res = CourseModel::where($where)
			->field('*')
			->order('id', $order)
			->page($page, $limit)
			->select();
		return $res;
	}

	public function getCount($where=[])
    {
        return CourseModel::where($where)->count('id');
    }

	public function addCourse($params=[], $incId = false)
	{
		$res = CourseModel::insert($params);
		if($incId)
		{
			return CourseModel::getLastInsID();
		}
		return $res;
	}

	public function updateCourse($where=[], $data=[])
    {
        return CourseModel::where($where)->update($data);
    }


    public function getLikeCourse($where=[], $likeWhere=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = CourseModel::where($where)->where(function ($query) use ($likeWhere){
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
        $res = CourseModel::where($where)->where(function($query) use ($likeWhere){
				foreach($likeWhere as $val)
				{
					$query->whereLike($val['field'], "%{$val['value']}%");
				}
		})->count('id');
		return $res;
    }

}