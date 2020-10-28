<?php
namespace app\http\middleware;

use myextend\Edcrypt;
use think\facade\Request;

class Check
{
	public function handle($request, \Closure $next)
    {	
        return $next($request);
    }
}