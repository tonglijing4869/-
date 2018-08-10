<?php
namespace app\index\model;
use think\Model;
use think\Db;
/**
 * 创建model类
 */
class Grx_goods extends Model
{
    /**
     *  定义查询全部方法
     */
    public function selects()
    {
        return Db::table('grx_goods')->select();
    }
    /**
     *  定义添加方法
     */
    public function inserts($data)
    {
        return Db::table('grx_goods')->insert($data);
    }
    /**
     *  定义修改方法
     */
    public function updates($id,$data)
    {
        return Db::table('grx_goods')->where("id =$id")->update($data);
    }
    /**
     *  定义删除方法
     */
    public function deletes($id)
    {
        return Db::table('grx_goods')->where("id = $id")->delete();
    }
    /**
     *  定义查询单条方法
     */
    public function finds($id)
    {
        return Db::table('grx_goods')->where("id =$id ")->select();
    }
    // 定义分页类
    public function pages()
    {
        // 查询状态为1的用户数据 并且每页显示10条数据
        $data = Db::table('grx_goods')->paginate(12);
        // $page = $data->render();
        return $data;
        // return $page;
    }
}
?>