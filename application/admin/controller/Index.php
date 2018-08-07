<?php
namespace app\admin\controller;
use app\admin\model\Brand;
use think\Controller;
use app\admin\model\Zixun;
use think\Db;
use app\admin\validate\Rule;
use think\Request;
use think\Session;
use app\admin\model\goods;
class Index extends Controller
{
	/**
	 *@content 方非法登录
	 *@return  mixed
	 *@author  童立京
	 *@time    2018/8/6
	 */
	public function __construct()
	{
		parent::__construct();
		$name = Session::get('name');
		if (empty($name)) {
			$this->success('请先登录',('login/login'));
		}
	}
	/**
	 *@content 后台页面 
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-2
	 */
	public function index()
	{
		return $this->fetch();
	}

	/**
	 *@content 后台页面--左侧菜单 
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-2
	 */
	public function public_left()
	{
		return $this->fetch();
	}


	/**
	 *@content 后台页面--头部 
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-2
	 */
	public function public_header()
	{
		$name = Session::get('name');
		$this->assign('name',$name);
		return $this->fetch();
	}


	/**
	 *@content 后台页面--商品 
	 *@return  mixed
	 *@author  牛勇港
	 *@time    2018-8-2
	 */
	public function wenzhang_xinwen()  
	{
		$model = new goods;
		$data = $model->where(['goods_del'=>1])->order('goods_id',"desc")->paginate(5);
		$this->assign('data',$data);
		return $this->fetch();
	}

	/**
	 *@content 修改删除商品  放回收站
	 *@author  牛勇港
	 */
	public function goodsdel()
	{
		$request =Request::instance();
		$id = $request->get('id');
		$model = new goods;
		$data = $model->where('goods_id',$id)->update(['goods_del'=>0]);
		if ($data) {
			$this->success('删除成功',"admin/index/wenzhang_xinwen"); 
		}
	}

	//商品修改页面
	public function goods_up()
	{
		$request =Request::instance();
		$id = $request->get('id');
		$model = new goods;
		$data = $model->where('goods_id',$id)->select();
		$this->assign('data',$data);
		return $this->fetch();
	}
	//修改商品
	public function goods_update()
	{
		$request = Request::instance();
		$data = $request->post();
		$file = $request->file('goods_img');
		if (!empty($file)) {
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	    	if ($info) {
	    		$files = DS . 'uploads' . DS . $info->getSaveName();
	    	}
	    	$data['goods_img'] = $files;
		}
    	$data['goods_time'] = time();
    	unset($data['__token__']);
    	// var_dump($data);die;
    	$model = new goods;
    	$red = $model->where('goods_id',$data['goods_id'])->update($data);
    	if ($red) {
			$this->success('修改成功',"admin/index/wenzhang_xinwen"); 
		}else{
			$this->error('修改失败',"admin/index/goods_up");
		}
	}

	//商品添加
	public function goodsAdd()
	{
		$request =Request::instance();
    	$search = $request->post();
    	$file = $request->file('goods_img');
    	$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
    	if ($info) {
    		$data = DS . 'uploads' . DS . $info->getSaveName();
    	}
    	$search['goods_img'] = $data;
    	$search['goods_time'] = time();
    	unset($search['__token__']);
		$model = new goods;
		$res = $model->inserData($search);
		if ($res) {
			$this->success('添加成功',"admin/index/wenzhang_xinwen"); 
		}else{
			$this->error('添加失败',"admin/index/goodsAdd");
		}

	}

	/**
	 *@content 后台页面 ---品牌管理
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-3
	 */
	public function huodong_guanli()
	{
		return $this->fetch();
	}


	/**
	 *@content 后台页面 ---最新资讯
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-3
	 */
	public function xiangce_guanli()
	{
		$user = new Zixun();
		$data =$user->pages();
		$page = $data->render();
		$this->assign('data',$data);
		$this->assign('page',$page);
		return $this->fetch();
	}

	/**
	 *@content 后台页面 ---联系我们
	 *@return  mixed
	 *@author  李德龙
	 *@time    2018-8-3
	 */
	public function tupian_pc_index()
	{
		$data = Db::table('contact')->paginate('5');
 	    $page = $data->render();
 	    $this->assign('page',$page);
		$this->assign('data',$data);
		return $this->fetch();
	}


	/**
	 *@content 后台页面 ---联系我们--删除
	 *@return  mixed
	 *@author  李德龙
	 *@time    2018-8-3
	 */
	public function tupian_pc_del()
	{
		$id=$_GET['id'];
		$res=Db::name("contact")->delete($id);
		if ($res) {
			$msg=array("status"=>"1","message"=>"删除成功");
		}
		else{
			$msg=array("status"=>"0","message"=>"删除失败");
		}
		return json($msg);
	}

	/**
	 *@content 后台页面 ---添加管理员
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-3
	 */
	public function zixun_team()
	{
		return $this->fetch();
	}

	/**
	 *@content 添加管理员
	 *@return  mixed
	 *@author  苗志航
	 *@time    2018/8/6
	 */
	public function addadmin()
	{
		$data = $this->request->post();
		if ($data['password'] != $data['password2']) {
			die('请确认前后密码一致');
		}
		if (empty($data['name'])) {
			die('用户名不能为空');
		}
		if (empty($data['password'])) {
			die('密码不能为空');
		}
		$pwd = $data['password'];
		$data['password'] = md5($pwd);
		$data['addtime'] = time();
		unset($data['password2']);
		$user = new Zixun();
		$info = $user->add($data);
		if ($info) {
			$this->success('添加成功',('index/muban_guanli'));
		}else{
			$this->success('添加失败',('index/addadmin'));
		}
	}

	/**
	 *@content 后台页面 ---管理员列表
	 *@return  mixed
	 *@author  童立京
	 *@time    2018-8-3
	 */
	public function muban_guanli()
	{
		$user = new Zixun();
		$show = $user->page();
		$this->assign('show',$show);
		return $this->fetch();
	}

	//渲染添加页面
	public function wenzhang_add()
	{
		return $this->fetch();
	}


    /**
	 *@content 后台页面 ---调用资讯添加页面方法
	 *@return  mixed
	 *@author  muyang
	 *@time    2018-8-3
	 */
	public function information()
	{
		return $this->fetch();
	}

	/**
	 *@content 后台页面 ---资讯添加方法
	 *@return  mixed
	 *@author  muyang
	 *@time    2018-8-3
	 */
	public function information_add()
	{
		$data = $this->request->post();
		$data['time'] = date('Y-m-d',time());
		$user = new Zixun();
		$info =$user->inserts($data);
		if ($info) {
			$this->success('添加成功',('index/xiangce_guanli'));
		}
		else
		{
			$this->error('添加失败');
		}
	}
	public function updates()
	{
		$id = $this->request->get('id');
		$user = new Zixun();
		$data =$user->finds($id);
		return view('updates',['data'=>$data]);
	}
	public function updates_add()
	{
		$data = $this->request->post();
		$id = $data['id'];
		$user = new Zixun();
		$info =$user->updates($id,$data);
		if ($info) {
			$this->success('修改成功',('index/xiangce_guanli'));
		}else
		{
			$this->error('修改失败');
		}
	}
	public function deletes()
	{
		$id = $this->request->get('id');
		$user = new Zixun();
		$info =$user->deletes($id);
		if ($info) {
			$this->success('删除成功',('index/xiangce_guanli'));
		}else
		{
			$this->error('删除失败');
		}
	}
	/**
	 *@content 后台页面 ---品牌查看
	 *@return  array
	 *@author  xuda
	 *@time    2018-8-3
	 */
	public function brandGuan()
	{

		$brand = new Brand();
		$data = Db::table('grx_brand')->paginate(3);
		return view('huodong_guanli',['data'=>$data]);
	}
	/**
	 *@content 后台页面 ---品牌添加
	 *@return  array
	 *@author  xuda
	 *@time    2018-8-3
	 */
	public function addBrand()
	{
		return view('addBrand');
	}
	/**
	 *@content 后台页面 ---接收数值，将数据入库
	 *@return  array
	 *@author  xuda
	 *@time    2018-8-3
	 */
	public function add_do()
	{
		$request = Request::instance();
		$data=$request->post();
		$result = $this->validate($data,'Rule');
		if(true !== $result){
			$this->error("$result");
		}
		$file = $request->file('brand_img');
		
		$info = $file->move('uploads');//移动到uploads文件夹
		$url = $info->getSaveName();//获取图片名称
		//dump($url);die;
		$imgp=str_replace("\\", "/", $url);//转义字符
		 //dump($imgp);die;
		
		 $data['brand_img'] = "uploads/"."$imgp";
		/*dump($file);die;*/
		$time = date("Y-m-d H:i:s");
		$data['create_time'] = $time;
		$brand = new Brand;
		$res = $brand->addData($data);
		if($res){
			echo "<script>alert('添加成功');location.href='brandGuan'</script>";
		}else{
			echo "<script>alert('添加失败');location.href='addBrand'</script>";
		}
	}
	/**
	 *@content 后台页面 ---删除数据
	 *@return  array
	 *@author  xuda
	 *@time    2018-8-3
	 */
	public function del()
	{
		$request = Request::instance();
		$id = $request->get('id');
		$brand = new Brand;
		$res = $brand->delData($id);

		if($res){
			echo "<script>alert('删除成功');location.href='brandGuan'</script>";
		}else{
			echo "<script>alert('删除失败');location.href='brandGuan'</script>";
		}
		return $res;
	}

	/**
	 *@content 后台页面 ---修改数据
	 *@return  array
	 *@author  xuda
	 *@time    2018-8-3
	 */
	public function update()
	{
		$request = Request::instance();
		$id = $request->get('id');
		$brand = new Brand;
		$data = $brand->findOne($id);
		return view('update',['id'=>$id,'data'=>$data]);
	}

	/**
	 *@content 后台页面 ---接收数值，将数据修改入库
	 *@return  array
	 *@author  xuda
	 *@time    2018-8-3
	 */
	public function update_do()
	{
		$request = Request::instance();
		$file = $request->file('brand_img');
		if (!empty($file)) {
			$move = $file->move('uploads');
			$name = $move->getSaveName();
			$imgp = str_replace("\\", '/', $name);
			$data['brand_img'] = "uploads/".$imgp;
		}
		$data = $request->post();
		$id = $data['brand_id'];
		$time = date("Y-m-d H:i:s");
		$data['create_time'] = $time;
		$brand = new Brand;
		$res = $brand->upData($id,$data);
		if($res){
			echo "<script>alert('修改成功');location.href='brandGuan'</script>";
		}else{
			echo "<script>alert('修改失败');location.href='addBrand'</script>";
		}
	}
	

	/**
	 *@content ajax修改管理员列表状态
	 *@return  json
	 *@author  童立京
	 *@time    2018/8/6
	 */
	public function ajax_save()
	{
		$id = $this->request->get('id');
		$status = $this->request->get('status');
		if ($status == '×') {
			$result = Db::table('admin')->where('id',$id)->update(['is_show' => '1']);
			echo json_encode(array('statu'=>'false','mesg'=>'修改成功'));
		} else {
			$result = Db::table('admin')->where('id',$id)->update(['is_show' => '0']);
			echo json_encode(array('statu'=>'true','mesg'=>'修改成功'));
		} 
	}

	/**
	 *@content 后台管理员删除
	 *@return  array();
	 *@author  童立京
	 *@time    2018/8/7
	 */
	// public function adminDel()
	// {
	// 	echo '123';
	// }

}
?>