<?php
namespace app\admin\controller;

use app\common\controller\MyController;
use think\facade\Request;

class Upload extends MyController
{
    public function __construct()
    {
        parent::__construct();
    }

	public function execAction()
	{
		$file = Request::file('file');
		if(!is_null($file))
		{
			$info = $file->move('./upload/images');
			if($info){
				// 成功上传后 获取上传信息
				return $this->_success([
					'saveName' => 'public/upload/images/' . str_replace('\\', '/', $info->getSaveName())
				]);
			}else{
				// 上传失败获取错误信息
				return $this->serviceError($file->getError());
			}
		}
		return $this->validateError('缺失上传文件');
	}

	public function execActionBlod()
	{
		$fileName = Request::post('get_file_name', '');
		if(empty($fileName)){
			return $this->validateError('上传失败');
		}
		$file = $_FILES[$fileName];
        $saveFileExtention = Request::post('save_file_extention') ?: 'mp4';
		$saveFileType = Request::post('save_file_type');
        $saveFileName = Request::post('save_file_name') ?: md5(rand(10000,999).date('Y-m-d H:i:s').rand(10000,99999)).'.'.$saveFileExtention;

		$base_path = 'public/upload/videos/'.date('Ymd').'/';
		$path = env('ROOT_PATH').$base_path;
		if(!is_dir($path)){
			$this->createDirs($path, 0755);
		};
		$res = file_put_contents($path.$saveFileName, file_get_contents($file['tmp_name']), FILE_APPEND);
		if($res){
			return $this->_success([
				'saveFilePath'=>$base_path,
				'saveFileName'=>$saveFileName,
				'saveFileType'=>$saveFileType
			]);
		}
	}

	private function createDirs($dir, $model=0777){
        return is_dir($dir) or $this->createDirs(dirname($dir),$model) and mkdir($dir,$model);
	}

}