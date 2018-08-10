<?php 
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;

class Power extends Model
{
	public function selectPower()
	{
		$id = Session::get('id');

		return $this->query("select * from power where power_id in(select power_id from role_power where role_id in(select role_id from admin_role where id in(".$id.")))");
	}

	public function selectRole()
	{
		return $this->query("select * from role");
	}
}