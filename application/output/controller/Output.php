<?php
namespace app\output\controller;

class Output
{
    public function notFound()
    {
        abort(404, '资源不存在');
        //throw new Httpexception('资源不存在', 404);
    }
}