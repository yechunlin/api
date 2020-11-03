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
     * 根据ID获取班级详情
     * @param id int
     * @return \think\response\Json
     */
	public function getClassInfo()
	{
        $params = Request::only(['id'], 'get');
        $validate   = Validate::make([
            'id|用户ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$res = $this->class_model->getClassInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->notFoundError();
	}


    /**
     * 获取班级列表
     */
    public function getClass()
    {
        $params = Request::only([
            'page' => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'page'  => 'integer',
            'limit'  => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = ['status' => 1];
        $count = $this->class_model->getCount($where);
        $list  = $this->class_model->getClass($where, $params['page'], $params['limit'], 'id,name');

        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

}