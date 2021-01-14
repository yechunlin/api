<?php
namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\admin\model\CateModel;
use think\Validate;

class Cate extends MyController
{
	private $cate_model;
	public function __construct()
	{
        parent::__construct();
		$this->cate_model = new CateModel();
	}

    /**
     * 根据ID获取分类详情
     * @param id int
     * @return \think\response\Json
     */
	public function getCateInfo()
	{
	    $params = Request::only(['id'], 'get');
        $validate   = Validate::make([
            'id|分类ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$res = $this->cate_model->getCateInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->notFoundError();
	}

    /**
     * 添加分类
     */
	public function addCate()
	{
        $params = Request::only([
            'name' => '',
            'admin_id' => 0
        ], 'post');
        $validate = Validate::make([
            'name|名称' => 'require|max:30',
            'admin_id|管理员ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
		$params['dated'] = date('Y-m-d H:i:s');
		$res = $this->cate_model->addCate($params, true);
		if($res)
		{
		    $params['id'] = $res;
 			return $this->_success($params);
		}
		return $this->serviceError();
	}

    /**
     * 获取分类列表
     */
    public function getCate()
    {
        $params = Request::only([
            'id'    => 0,
            'name' => '',
            'status'=> 1,
            'sort'  => 1,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|分类ID'=> 'integer',
            'name|名称'=> 'max:20',
            'status'   => 'integer',
            'sort'     => 'integer',
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = ['status' => $params['status']];
        if($params['id'])
        {
            $where['id'] = $params['id'];
            $count = $this->cate_model->getCount($where);
            $list  = $this->cate_model->getCate($where, $params['page'], $params['limit'], $params['sort']);
        }else{
            if($params['name']){
                $likeWhere = [
                    ['field' => 'name', 'value' => $params['name']]
                ];
                $count = $this->cate_model->getLikeCount($where, $likeWhere);
                $list  = $this->cate_model->getLikeCate($where, $likeWhere, $params['page'], $params['limit'], $params['sort']);
            }else{
                $count = $this->cate_model->getCount($where);
                $list  = $this->cate_model->getCate($where, $params['page'], $params['limit'], $params['sort']);
            }
        }
		$userModel = new \app\admin\model\UserModel();
		foreach($list as $key => &$val){
			$tmp = $userModel->getUserInfo(['id' => $val['admin_id']]);
			$val['admin_name'] = $tmp['username'];
		}
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

    /**
     * 修改分类信息
     */
    public function updateCate()
    {
        $params = Request::only(['id', 'name', 'admin_id'], 'post');
        $validate   = Validate::make([
            'id|分类id'  => 'require|integer',
            'name|名称' => 'require|max:30',
            'admin_id|管理员ID' => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $where = [
            'id' => $params['id']
        ];
        $data = [
            'name' => $params['name'],
			'admin_id' => $params['admin_id']
        ];
        $res = $this->cate_model->updateCate($where, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->serviceError();
    }

    /**
     * 删除分类信息
     */
    public function deleteCate()
    {
        $params = Request::only(['id'], 'post');
        $validate   = Validate::make([
            'id|分类ID'  => 'require|integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $data = [
            'status' => 0,
        ];
        $res = $this->cate_model->updateCate($params, $data);
        if($res)
        {
            return $this->_success($params);
        }
        return $this->serviceError();
    }
}