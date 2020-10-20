<?php
namespace app\common\controller;

use think\Controller;

class MyController extends Controller
{
    public function _success($data=[])
    {
        return json([
            'status' => 1,
            'msg' => 'success',
            'data' => $data
        ]);
    }

    public function _error($code=500, $msg='')
    {
        $msg = $msg ?: config('error.'.$code);
        return json([
            'status' => 0,
            'code'   => $code,
            'msg'    => $msg,
        ]);
    }
}