<?php
namespace app\hsxz\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\hsxz\model\ClassModel;
use think\Validate;

class ClassServer extends MyController
{
	private $Class_model;
	public function __construct()
	{
		$this->Class_model = new ClassModel();
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
            return $this->_error(4000, 400, $validate->getError());
        }
		$res = $this->Class_model->getClassInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->_error(4001, 404);
	}

    /**
     * 添加班级
     */
	public function addClass()
	{
        $params = Request::only([
            'name' => '',
            'description' => '',
            'admin_id' => 0
        ], 'post');
        $validate = Validate::make([
            'name' => 'require|max:20',
            'description' => 'require|max:50',
            'admin_id' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->_error(4000, 400, $validate->getError());
        }
        $params['dated'] = date('Y-m-d H:i:s');
		$res = $this->Class_model->addClass($params, true);
        if($res)
        {
            $params['id'] = $res;
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
            'status' => 1,
            'sort' => 1,
            'page' => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|用户ID'  => 'integer',
            'name|用户名'  => 'max:20',
            'status'  => 'integer',
            'sort'  => 'integer',
            'page'  => 'integer',
            'limit'  => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->_error(4000, 400, $validate->getError());
        }
        $where = ['status' => $params['status']];
        if($params['id'])
        {
            $where['id'] = $params['id'];
        }
        if($params['name'])
        {
            $likeWhere = [
				['field' => 'name', 'value' => $params['name']]
			];
            $count = $this->Class_model->getLikeCount($where, $likeWhere);
            $list  = $this->Class_model->getLikeClass($where, $likeWhere, $params['page'], $params['limit'], $params['sort']);
        }else{
		    $count = $this->Class_model->getCount($where);
			$list  = $this->Class_model->getClass($where, $params['page'], $params['limit'], $params['sort']);
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
        $params = Request::only(['id', 'name', 'description'], 'post');
        $validate   = Validate::make([
            'id|用户ID'  => 'require|integer',
            'name|用户名'  => 'max:20',
            'description|描述'  => 'max:50'
        ]);
        if(!$validate->check($params)) {
            return $this->_error(4000, 400, $validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'name' => $params['name'],
            'description' => $params['description']
        ];
        $res = $this->Class_model->updateClass($where, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->_error(5000, 500);
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
            return $this->_error(4000, 400, $validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->Class_model->updateClass($where, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->_error(5000, 500);
    }
}