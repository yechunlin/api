<?php
namespace app\output\controller;

class Output
{
    public $header = [
        'Content-Type' => 'application/json; charset=utf-8'
    ];

    public function notFound()
    {
        $error_code = 4004;
        $data = json_encode([
            'status' => 0,
            'code'   => $error_code,
            'msg'    => config('error.'.$error_code)
        ]);
        return response($data, 404, $this->header);
    }
}