<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Brand extends Model
{
	//品牌查看
	public function showData()
	{
		return Db::table('grx_brand')->select();
	}
	//品牌添加
	public function addData($data)
	{
		return Db::table('grx_brand')->insert($data);
	}
	//品牌删除
	public function delData($id)
	{
		return Db::table('grx_brand')->where("brand_id in ($id) ")->delete();
	}
	//品牌修改
	public function upData($id,$data)
	{
		return Db::table('grx_brand')->where("brand_id = $id ")->update($data);
	}
	//查找一条数据
	public function findOne($id)
	{
		return Db::table('grx_brand')->where("brand_id = $id ")->find();
	}
}