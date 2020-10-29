<?php
/**
 * User: ycl
 * Date: 2020/10/27 0027
 * Time: 14:35
 */

namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;
use app\admin\model\TimeTableModel;
use think\Validate;

class TimeTable extends MyController
{
    private $time_table_model;
    public function __construct()
    {
        parent::__construct();
        $this->time_table_model = new TimeTableModel();
    }

    /**
     * @return \think\Response|\think\response\Json
     */
    public function getTimeTableInfo()
    {
        $params = Request::only(['id'], 'get');
        $validate   = Validate::make([
            'id|课程表ID' => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $res = $this->time_table_model->getTimeTableInfo(['id' => $params['id']]);
        if($res)
        {
            return $this->_success($res);
        }
        return $this->serviceError();
    }

    /**
     * 获取课程表列表
     */
    public function getTimeTable()
    {
        $params = Request::only([
            'id'    => 0,
            'class_id' => 0,
            'user_id'=> 0,
            'status' => 1,
            'sort'  => 1,
            'page'  => 1,
            'limit' => 20
        ], 'get');
        $validate   = Validate::make([
            'id|课程表ID' => 'integer',
            'class_id|班级ID'=> 'integer',
            'user_id|用户ID'=> 'integer',
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
        }else{
            if($params['class_id']){
                $where['class_id'] = $params['class_id'];
            }
            if($params['user_id']){
                $where['user_id'] = $params['user_id'];
            }
        }
        $count = $this->time_table_model->getCount($where);
        $list  = $this->time_table_model->getTimeTable($where, $params['page'], $params['limit'], $params['sort']);

        $classModel = new \app\admin\model\ClassModel();
        $userModel = new \app\admin\model\UserModel();
        foreach($list as $key => &$val){
            $tmp = $classModel->getClassInfo(['id' => $val['class_id']], 'name');
            $val['class_name'] = $tmp['name'];
            $tmp = $userModel->getUserInfo(['id' => $val['user_id']], 'username');
            $val['user_name'] = $tmp['username'];
        }
        return $this->_success([
            'total' => $count,
            'items' => $list
        ]);
    }

    /**
     * 添加课程表
     */
    public function addTimeTable()
    {
        $params = Request::only(['user_id', 'class_id', 'start_dated', 'end_dated', 'admin_id' => 0], 'post');
        $validate   = Validate::make([
            'user_id|用户id' => 'require|integer',
            'class_id|班级ID' => 'require|integer',
            'start_dated|开始时间' => 'require',
            'end_dated|介绍时间' => 'require',
            'admin_id|管理员ID'  => 'integer'
        ]);
        if(!$validate->check($params)) {
            return $this->validateError($validate->getError());
        }
        $params['dated'] = date('Y-m-d H:i:s');
        $res = $this->time_table_model->addTimeTable($params, true);
        if($res)
        {
            $params['id'] = $res;
            $classModel = new \app\admin\model\ClassModel();
            $userModel = new \app\admin\model\UserModel();
            $tmp = $classModel->getClassInfo(['id' => $params['class_id']], 'name');
            $params['class_name'] = $tmp['name'];
            $tmp = $userModel->getUserInfo(['id' => $params['user_id']], 'username');
            $params['user_name'] = $tmp['username'];
            return $this->_success($params);
        }
        return $this->serviceError();
    }
}