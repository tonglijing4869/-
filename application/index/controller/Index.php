<?php
namespace app\index\controller;

use think\Db;
use think\Controller;

class Index extends Controller
{
	/**
	 *@content 商城首页
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function index()
    {
        return $this->fetch('index');
    }

    /**
	 *@content 商城首页--蔬果热卖页面
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function hot()
    {
    	return $this->fetch('hot');
    }

    /**
	 *@content 商城首页--全部产品页面
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function produ()
    {
    	return $this->fetch('produ');
    }

    /**
	 *@content 商城首页--橘子页面
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function orange()
    {
    	return $this->fetch('orange');
    }


    /**
	 *@content 商城首页--最新资讯页面
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function consult()
    {
    	return $this->fetch('consult');
    }


    /**
	 *@content 商城首页--联系我们页面
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function touch()
    {
    	return $this->fetch('touch');
    }

     /**
	 *@content 商城首页--联系我们入库
	 *@return  mixed
	 *@author  李德龙
	 *@time    2018-8-1
	 */
    public function do_touch()
    {
    	$data=input("post.");
        $datetime=date('y-m-d h:i:s',time());
        $data['datetime']=$datetime;
       
        $res=Db::name("contact")->insert($data);
       if ($res) {
       	return $this->success("留言成功","Index/touch");
       }
       else
       {
       	return $this->error("留言失败");
       }
    }
}
