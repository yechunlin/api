<?php
namespace app\common\controller;

use think\Controller;
use myextend\Edcrypt;
use think\facade\Request;

class AdminController extends Controller
{
	private $wirtePath = ['admin/user/login','admin/user/logout','admin/Upload/execAction','admin/Upload/execActionBlod'];
    protected $header = [
        'Content-Type' => 'application/json; charset=utf-8'
    ];

	public function __construct()
	{
        $this->checkToken();
	}

	public function checkToken()
    {
        if( !in_array(Request::path(), $this->wirtePath) )
        {
            $edcrypt = new Edcrypt();
            $header = Request::header();

            if(!isset($header['x-token']))
            {
                $this->orgResponse(4006, 403);

            }
            if(!isset($header['x-user-id']))
            {
                $this->orgResponse(4007, 403);
            }
            $token = $header['x-token'];
            $user_id = $header['x-user-id'];
            $org_token_arr = explode('_', $edcrypt->decrypt($token));
            if(!is_array($org_token_arr) || !isset($org_token_arr[0]) || !isset($org_token_arr[1]))
            {
                $this->orgResponse(4003, 403);
            }

            if($org_token_arr[1] < time())
            {
                $this->orgResponse(4005, 403);
            }

            if($user_id != $org_token_arr[0])
            {
                $this->orgResponse(4003, 403);
            }
        }
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