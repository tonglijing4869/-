<?php
namespace app\index\controller;

use think\Db;
use app\index\model\Goods;
// use app\admin\model\goods;
use think\Controller;
use think\Request;

class Index extends Controller
{
	/**
	 *@content 商城首页
	 *@return  mixed
	 *@author  牛勇港
	 *@time    2018-8-1
	 */
    public function index()
    {/*
        $model = new goods;*/
        $data = Db::table('grx_goods')->where(['goods_del'=>1])->limit(6)->order('goods_id',"desc")->select();
        $this->assign('data',$data);
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
	 *@content 商城首页--商品详情页
	 *@return  mixed
	 *@author  tonglijing
	 *@time    2018-8-1
	 */
    public function orange()
    {
        $id  = $this->request->get('id');
        $result = Db::table('grx_goods')->where('goods_id',$id)->find(); 
        $this->assign('result',$result);
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


    /**
     *@content 前台购物车
     *@author  童立京
     *@return  mixed
     *@time    童立京
     */
    public function gwc()
    {
        return $this->fetch('gwc');
    }


    /**
     *@content 前台---详情页---备用方法
     *@author  徐达
     *@return  mixed
     *@time    2018/8/8
     */
    public function detail()
     {
        $request = Request::instance();
        $id = $request->get('id');
        $goods = new Goods;
        $data = $goods->detailData($id);
        ob_start();//开启缓冲区
        include "static/template.html";//引入模板
        $content = ob_get_contents();//获取缓冲区的内容
        file_put_contents("static/jintai.html", $content);//把获取到的内容发送到模板里，生成静态文件
     }
}
