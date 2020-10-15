<?php
namespace app\hsxz\controller;

use think\Controller;
use think\facade\Request;
use app\hsxz\model\VideoModel;

class VideoServer extends Controller
{
	private $video_model;
	public function __construct()
	{
		$this->Video_model = new VideoModel();
	}

    /**
     * 根据ID获取视频详情
     * @param id int
     * @return \think\response\Json
     */
	public function getVideoInfo()
	{
		$id = Request::get('id');
		$res = $this->Video_model->getVideoInfo(['id' => $id]);
		return json([
			'code' => 20000,
			'data' => $res
		]);
	}

    /**
     * 添加班级
     */
	public function addVideo()
	{
		$p = Request::post();
		$p['dated'] = date('Y-m-d H:i:s');
		$res = $this->Video_model->addVideo($p, true);
		if($res)
		{
		    $p['id'] = $res;
 			return json([
				'code' => 20000,
				'data' => $p
			]);
		}
	}

    /**
     * 获取视频列表
     */
    public function getVideo()
    {
        $status = Request::get('status', 1);
        $sort = Request::get('sort', 1);
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 10);
        $where = ['status' => $status];
        $count = $this->Video_model->getCount($where);
        $list = $this->Video_model->getVideo($where, $page, $limit, $sort);
        return json([
            'code' => 20000,
            'data' => [
                'total' => $count,
                'items' => $list
            ]
        ]);
    }

    /**
     * 删除视频信息
     */
    public function deleteVideo()
    {
        $p = Request::post();
        $where = [
            'id' => $p['id']
        ];
        $data = [
            'status' => 0,
        ];
        $res = $this->Video_model->updateVideo($where, $data);
        if($res)
        {
            return json([
                'code' => 20000,
                'data' => $p
            ]);
        }
        return json([
            'code' => 0,
            'data' => []
        ]);
    }
}