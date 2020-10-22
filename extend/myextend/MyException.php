<?php
namespace myextend;

use Exception;
use think\exception\Handle;

class MyException extends Handle
{
    public function render(Exception $e)
    {

        return parent::render($e);

    }
}