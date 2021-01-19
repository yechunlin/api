<?php
namespace app\hsxz\model;

use think\Model;

class CateModel extends Model
{

	protected $table = 'cate';


	public function getCate($page=1, $limit=7)
	{
		$res = CateModel::field('id,name')
			->order('id', 'desc')
			->page($page, $limit)
			->select();
		return $res;
	}

	public function getCount($where=[])
    {
        return CateModel::where($where)->count('id');
    }

}