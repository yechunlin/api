<?php
namespace app\hsxz\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\hsxz\model\ClassModel;
use think\Validate;

class ClassServer extends MyController
{
	private $class_model;
	public function __construct()
	{
		$this->class_model = new ClassModel();
	}

    /**
     * 获取班级列表
     */
    public function getClass()
    {
        $params = Request::only([
            'cate_id' => 0,
            'page'  => $this->page,
            'limit' => $this->limit
        ], 'get');
        $validate   = Validate::make([
			'cate_id'  => 'integer',
            'page'  => 'integer',
            'limit'  => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$where = [
			'cate_id' => $params['cate_id'],
			'status' => 1
		];
        $count = $this->class_model->getCount($where);
        $list  = $this->class_model->getClass($where, $params['page'], $params['limit'], 'id,name');

        $courseModel = new \app\hsxz\model\CourseModel();
        $userModel = new \app\hsxz\model\UserModel();
		foreach($list as $key => &$val){
            $tmp = $courseModel->getCourse(['class_id' => $val['id'], 'status' => 1], 1, 100);
            foreach($tmp as $k => &$v){
                $tmp_class = $userModel->getUserInfo(['id' => $v['admin_id']],'username');
                $v['admin_name'] = $tmp_class['username'];
            }
			$val['courses'] = $tmp;
		}
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

}