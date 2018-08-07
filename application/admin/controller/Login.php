<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\captcha\Captcha;
use think\Cookie;
use think\Session;

class Login extends Controller
{
	/**
	 *@content 后台登录页面
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-3
	 */
	public function login()
	{
		return $this->fetch('loginb');
	}

	public function loginbDo()
    { 
    	$name = input('post.name');
    	$password = input('post.password');
    	$password = md5($password);
    	$authcode = input('post.authcode');
		$arr = Db::table('admin')->where('name',$name)->find(); 
		if ($arr['is_show'] != 1) {
			$this->success('您的账号已冻结，请联系管理员',('login/login'));
		}
        if ($arr) {
        	$all = ['name' => $name];
            Cookie::set('all',$all,3);
			if ($arr['password'] == $password) {
				$allp = ['password' => $password];
				// print_r($allp);die;
                Cookie::set('allp',$allp,3);
				$captcha = new Captcha();
				if ( !$captcha->check($authcode)) {
				    $this->redirect('Login/login');
				} else {
					if ($arr['is_show'] == 1) {
						Session::set('name',$arr['name']); 
	                    Session::set('id',$arr['id']); 
	                    $data = ['name' => $arr['name'],
	                             'login_time' => time(),
	                             'user_ip' => $_SERVER['REMOTE_ADDR'],
	                             'server_ip' => $_SERVER['SERVER_ADDR']
	                            ];
	                    Db::name('admin_log')->insert($data);
						$this->redirect('Index/index');
					} else {
			            $this->redirect('Login/login');
			        }
				}
			} else {
				$this->redirect('Login/login');
			}
		} else {
			$this->redirect('Login/login');
		} 
    }

    public function verify()
    {
		$config = [
            'length' => 3,
        ];
        $captcha = new Captcha($config);
        $captcha->codeSet = '0123456789';

        return $captcha->entry();    
    }


	/**
	 *@content 后台页面---修改密码
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-3
	 */
	public function change_psw()
	{
		return $this->fetch();
	}

}

?>