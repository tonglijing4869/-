<?php
namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Session;
class Login extends controller
{
	/*
	*content  前台登录展示
	*return   mixed
	*time     2018/8/7
	*author   miaozhihang
	*/
	public function login()
	{
		return $this->fetch('login');
	}
	/*
	*content  前台登录判断
	*return   mixed
	*time     2018/8/7
	*author   miaozhihang
	*/
	public function loginuser()
	{
		$data = $this->request->post();
		$name = $data['user_name'];
		$pwd = md5($data['user_password']);
		$info = Db::table('user')->where('user_name',$name)->find();
		$Cname = $info['user_name'];
		$Cpwd  = $info['user_password'];
			if ($name != $Cname) {
				$this->error('用户名不存在');
			}else{
				if ($pwd != $Cpwd) {
					$this->error('密码错误，请重新输入！');
				}
				//存session:
				Session::set('user_name',$Cname);
				$this->success('登录成功，正在为您跳转',('index/index/index'),'','1');
			}
	}
	/*
	*content  前台注册展示
	*return   mixed
	*time     2018/8/7
	*author   miaozhihang
	*/
	public function addlogin()
	{
		return $this->fetch('addlogin');
	}
	/*
	*content  前台注册添加
	*return   mixed
	*time     2018/8/7
	*author   miaozhihang
	*/
	public function logindb()
	{
		$data = $this->request->post();
		$name = $data['user_name'];
		$pwd = $data['user_password'];
		if (preg_match('/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]{3,5}$/u',$name)) {
			if (preg_match('/^[A-Za-z0-9_\.]{6,8}$/',$pwd)) {
			$pwd = md5($data['user_password']);
			$querypwd = md5($data['Password']);
			$time = date('Y-m-d',time());
			$info = Db::table('user')->where('user_name',$name)->find();
			$Cname = $info['user_name'];
			$Cpwd =  $info['user_password'];
				if ($querypwd != $pwd) {
				$this->error('您输入的确认密码与密码不一致，请重新输入',('login/addlogin'),'','1');
				}else{
					if ($name == $Cname) {
					$this->error('您输入的用户已存在，请重新输入',('login/addlogin'),'','1');
					}
						$list = ['user_name'=>$name,'user_password'=>$pwd,'addtime'=>$time];
						$demo = Db::table('user')->insert($list);
						if ($demo) {
						$this->success('注册成功，请登录',('index/login/login'),'','1');
							}else{
								$this->success('注册失败，请重新注册',('index/login/addlogin'),'','1');
							}
					}
				}else{
					$this->error('密码是由6到8位字母、数字、点、下划线构成',('login/addlogin'),'','3');
					}
			}else{
			$this->error('用户名必须是由三到五位汉字或者字母开头可以带数字的三到五位构成',('login/addlogin'),'','3');
			}
	}
}
?>