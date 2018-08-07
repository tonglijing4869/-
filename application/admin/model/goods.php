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
}