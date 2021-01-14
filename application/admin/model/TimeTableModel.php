<?php
/**
 * User: ycl
 * Date: 2020/10/27 0027
 * Time: 14:39
 */

namespace app\admin\model;

use think\Model;

class TimeTableModel extends Model
{
    protected $table = 'school_timetable';

    public function getTimeTableInfo($where=[], $fields='*')
    {
        $res = TimeTableModel::where($where)
            ->field($fields)
            ->find();
        return $res;
    }
    public function addTimeTable($params=[], $incId = false)
    {
        $res = TimeTableModel::insert($params);
        return $res;
    }
	public function updateTimeTable($where=[], $data=[])
    {
        return TimeTableModel::where($where)->update($data);
    }
    public function getTimeTable($where=[], $page=1, $limit=10, $sort=1)
    {
        $order = !intval($sort) ? 'asc' : 'desc';
        $res = TimeTableModel::where($where)
            ->field('*')
            ->order('id', $order)
            ->page($page, $limit)
            ->select();
        return $res;
    }

    public function getCount($where=[])
    {
        return TimeTableModel::where($where)->count('id');
    }
}