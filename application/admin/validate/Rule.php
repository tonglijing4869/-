<?php
namespace app\admin\validate;
use think\Validate;
class Rule extends Validate
{
     protected $rule = [
        ['brand_name','require','品牌名称必填'],
        ['brand_img','number|min:6','密码必须是数字|密码最少六位以上'],
        ['brand_desc','require','品牌描述必填'],
    ];
    
   /* protected $message = [
        'name.require'  =>  '用户名必须是数字',
        'pwd.require' =>  '密码必填',
        'pwd.number' =>  '密码必须是数字',
    ];*/
    
    /*protected $scene = [
        'add'   =>  ['user','pwd'],
    ];*/
}