<?php
namespace app\admin\model;
use think\Db;
use think\Model;
use think\db\Query;

class goods extends Model
{
	protected $table='grx_goods';//表名
	function inserData($data)
	{
		return Db::table($this->table)->insert($data);
	}
	function show($data,$where,$id)
	{
		return Db::table($this->table)->where("and title like '%$where%'")->order([$id=>'desc'])->paginate(5);
	}
	function shows()
	{
		return Db::table($this->table)->paginate(5);
	}

	//生成缩略图
    function thumbImage($file,$pic){
        $image = \think\Image::open($file);
        $getSaveName = str_replace('\\','/',$pic->getSaveName());

		$portrait_thumbnail_180= 'uploads/user/'.str_replace($pic->getFilename(),'180_'.$pic->getFilename(),$getSaveName);

		$image->thumb(250,195,\think\Image::THUMB_CENTER)->save($portrait_thumbnail_180,null,100,true);

		if ($image) {
             return $portrait_thumbnail_180;
        }

    }
}