<?php
namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\hsxz\model\CateModel;
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
            'page'  => $this->page,
            'limit' => $this->limit
        ], 'get');
        $validate   = Validate::make([
            'page'     => 'integer',
            'limit'    => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }

        $count = $this->cate_model->getCount(['state' => 1]);
        $list  = $this->cate_model->getCate($params['page'], $params['limit']);
        
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

}