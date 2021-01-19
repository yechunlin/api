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
     * 获取分类列表
     */
    public function getCate()
    {
        $params = Request::only([
            'page'  => 1,
            'limit' => 7
        ], 'get');
        $validate   = Validate::make([
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }

        $count = $this->cate_model->getCount($where);
        $list  = $this->cate_model->getCate($params['page'], $params['limit']);
        
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

}