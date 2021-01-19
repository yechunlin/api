<?php
namespace app\common\controller;

use think\Controller;
use think\facade\Request;

class MyController extends Controller
{
    protected $header = [
        'Content-Type' => 'application/json; charset=utf-8'
    ];
	public $page = 1;
	public $limit = 7;
	public function __construct()
	{
       
	}

    public function orgResponse($code=0, $httpCode=0, $msg='')
    {
        $msg = $msg ?: config('error.'.$code);
        $httpMsg = config('error.'.$httpCode);
        header("HTTP/1.1 {$httpCode} {$httpMsg}");
        header("Content-type: application/json; charset=utf-8");
        die(json_encode([
            'status' => 0,
            'code'   => $code,
            'msg'    => $msg
        ]));
    }

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

    public function notFoundError()
    {
        return $this->_error(4001, 404);
    }

    public function validateError($msg='请求出错')
    {
        return $this->_error(4000, 400, $msg);
    }

    public function serviceError($msg='')
    {
        return $this->_error(5000, 500, $msg);
    }
}