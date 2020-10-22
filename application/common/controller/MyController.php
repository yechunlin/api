<?php
namespace app\common\controller;

use think\Controller;

class MyController extends Controller
{
    protected $header = [
        'Content-Type' => 'application/json; charset=utf-8'
    ];

    public function _success($data=[])
    {
        return json([
            'status' => 1,
            'msg' => 'success',
            'data' => $data
        ]);
    }

    public function _error($code=0, $httpCode=0, $msg='')
    {
        $msg = $msg ?: config('error.'.$code);
        return response(json_encode([
            'status' => 0,
            'code'   => $code,
            'msg'    => $msg
        ]), $httpCode, $this->header);
    }

    public function validateError($msg='请求出错')
    {
        return $this->_error(4000, 400, $msg);
    }

    public function serviceError()
    {
        return $this->_error(5000, 500);
    }
}