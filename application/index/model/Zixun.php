<?php
namespace app\index\model;
use think\Model;
use think\Db;
/**
* 创建model类
*/
class Zixun extends Model
{
	/**
	*  定义查询全部方法
	*/
	public function selects()
	{
		return Db::table('zixun')->select();
	}
	/**
	*  定义添加方法
	*/
	public function inserts($data)
	{
		return Db::table('zixun')->insert($data);
	}
	/**
	*  定义修改方法
	*/
	public function updates($id,$data)
	{
		return Db::table('zixun')->where("id =$id")->update($data);
	}
	/**
	*  定义删除方法
	*/
	public function deletes($id)
	{
		return Db::table('zixun')->where("id = $id")->delete();
	}
	/**
	*  定义查询单条方法
	*/
	public function finds($id)
	{
		return Db::table('zixun')->where("id =$id ")->select();
	}
	// 定义分页类
	public function pages()
	{
		// 查询状态为1的用户数据 并且每页显示10条数据
		$data = Db::table('zixun')->paginate(5);
		// $page = $data->render();
		return $data;
		// return $page;
	}

	public function page()
	{
		// 查询状态为1的用户数据 并且每页显示10条数据
		return Db::table('admin')->paginate(5);
		// return $page;
	}

	public function add($data)
	{
		return Db::table('admin')->insert($data);
	}
	

}
?>