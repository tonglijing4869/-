<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use app\admin\model\Power;

class Commons extends Controller {

    function __construct(){
        parent::__construct();
        $name = Session::get('name');
        if (empty($name)) {
            $this->redirect('login/login');
        }
        
        $power = new Power;
		$data = $power->selectPower(); 
		$res=$this->recursion($data);
		$url = [];
		foreach ($res as $key => $value) {
			$url[]=$value['controller_name'].'/'.$value['action_name'];
		}
		Session::set('power',$url);
        $request = Request::instance();
        $controller = $request->controller();
        $action = $request->action();
        $power = Session::get('power');
     
        // if(!in_array($controller.'/'.$action,$power)){
        //     $this->error("没有权限,请联系管理员");
        // }

    }


    public function recursion($data,$path=0,$f=1)
	{
		static $arr=array();
		foreach ($data as $key => $val) {
			if($val['pid']==$path){
				$val['f']=$f;
				$arr[]=$val;
				$this->recursion($data,$val['power_id'],$f+1);
			}
		}
		
        return $arr;
	 }


}

