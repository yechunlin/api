<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;

class Upload extends Controller
{
	public function execAction()
	{
		$file = Request::file('file');
		if(!is_null($file))
		{
			$info = $file->move('./upload/images');
			if($info){
				// 成功上传后 获取上传信息
				return json([
					'type' => ($info->getInfo())['type'],
					'saveName' => 'public/upload/images/'.$info->getSaveName()
				]);
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
	}



}