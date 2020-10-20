<?php
namespace myextend;

use Exception;
use think\Config;
use think\exception\Handle;

class MyException extends Handle
{
    public function render(Exception $e)
    {   
        //$debug_status = config("app_debug");
        //if($debug_status){
            //return parent::render($e);
        //}else{
            $this->throwException(0, $e->getMessage(), $e->getCode());
        //}
    }

    public function throwException($status=0, $msg='', $code, $data=[])
    {
        echo json_encode([
            'status' => $status,
            'msg'    => $msg,
            'code'   => $code,
            'data'   => $data
        ]);
        die();
    }
}