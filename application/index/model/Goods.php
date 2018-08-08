<?php
namespace app\index\model;
use think\Db;
use think\Model;
class Goods extends Model
{
	public function addData($data)
	{
		return Db::table('grx_goods')->insert($data);
	}
	public function showNum($num)
	{
		$sql = "select * from grx_goods limit $num";
		$res = Db::table('grx_goods')->query($sql);
		return $res;
	}
	public function showData()
	{
		return Db::table('grx_goods')->select();
	}
	public function detailData($id)
	{
		return Db::table('grx_goods')->where("goods_id = '$id' ")->select();
	}


}