<?php
namespace app\admin\controller;

use app\common\controller\AdminController;
use think\facade\Request;
use app\admin\model\ClassModel;
use think\Validate;

class ClassServer extends AdminController
{
	private $class_model;
	public function __construct()
	{
        parent::__construct();
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
     * 添加班级
     */
	public function addClass()
	{
        $params = Request::only([
            'name' => '',
			'cate_id' => 0,
			'num' => 0,
            'admin_id' => 0
        ], 'post');
        $validate = Validate::make([
            'name' => 'require|max:20',
			'cate_id' => 'require|integer',
			'num'  => 'require|integer',
            'admin_id' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $params['dated'] = date('Y-m-d H:i:s');
		$res = $this->class_model->addClass($params, true);
        if($res)
        {
            $params['id'] = $res;
			$cateModel = new \app\admin\model\CateModel();
			$tmp = $cateModel->getCateInfo(['id' => $params['cate_id']]);
			$params['cate_name'] = $tmp['name'];
            return $this->_success($params);
        }
        return $this->serviceError();
	}

    /**
     * 获取班级列表
     */
    public function getClass()
    {
        $params = Request::only([
            'id' => 0,
            'name' => '',
			'cate_id' => 0,
            'status' => 1,
            'sort' => 1,
            'page' => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|用户ID'  => 'integer',
            'name|用户名'  => 'max:20',
			'cate_id|分类' => 'integer',
            'status'  => 'integer',
            'sort'  => 'integer',
            'page'  => 'integer',
            'limit'  => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = ['status' => $params['status']];
        if($params['id'])
        {
            $where['id'] = $params['id'];
        }
		if($params['cate_id'])
        {
            $where['cate_id'] = $params['cate_id'];
        }
        if($params['name'])
        {
            $likeWhere = [
				['field' => 'name', 'value' => $params['name']]
			];
            $count = $this->class_model->getLikeCount($where, $likeWhere);
            $list  = $this->class_model->getLikeClass($where, $likeWhere, $params['page'], $params['limit'], $params['sort']);
        }else{
		    $count = $this->class_model->getCount($where);
			$list  = $this->class_model->getClass($where, $params['page'], $params['limit'], $params['sort']);
		}
		$cateModel = new \app\admin\model\CateModel();
		$userModel = new \app\admin\model\UserModel();
		foreach($list as $key => &$val){
			$tmp = $cateModel->getCateInfo(['id' => $val['cate_id']]);
			$val['cate_name'] = $tmp['name'];
			$tmp = $userModel->getUserInfo(['id' => $val['admin_id']]);
			$val['admin_name'] = $tmp['username'];
		}
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }


    /**
     * 修改班级信息
     */
    public function updateClass()
    {
        $params = Request::only(['id', 'name', 'cate_id', 'num'], 'post');
        $validate   = Validate::make([
            'id|用户ID'  => 'require|integer',
            'name|用户名'  => 'max:20',
			'num|招生'  => 'require|integer',
			'cate_id|分类' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'name' => $params['name'],
			'num' => $params['num'],
			'cate_id' => $params['cate_id']
        ];
        $res = $this->class_model->updateClass($where, $data);
        if($res)
        {
			$cateModel = new \app\admin\model\CateModel();
			$tmp = $cateModel->getCateInfo(['id' => $params['cate_id']]);
			$params['cate_name'] = $tmp['name'];
            return $this->_success($params);
        }
        return $this->serviceError();
    }

    /**
     * 删除班级信息
     */
    public function deleteClass()
    {
        $params = Request::only(['id'], 'post');
        $validate   = Validate::make([
            'id|班级ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->class_model->updateClass($where, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->serviceError();
    }
}