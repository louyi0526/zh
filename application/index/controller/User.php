<?php


namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\User as UserModel;
use think\facade\Request;

class User extends Base
{
    //注册
    public function register()
    {
        $this->assign('title','用户注册');
        return $this->fetch();
    }

    //处理用户提交的注册信息
    public function insert()
    {
        if (Request::isAjax())
        {

            //验证数据
            $data = Request::post();//获取数据
            $rule ='app\common\validate\User';//自定义的验证规则
            $res = $this->validate($data,$rule); //开始验证
            if ($res !== true){
                switch ($res){
                    case '':
                }
                return ['status'=> -1,'message'=>$res];
            }else {
                if (UserModel::create($data)){
                    return ['status'=> 1,'message'=>'注册成功'];
                }else {
                    return ['status'=> 0,'message'=>'注册失败'];
                }
            }

        }else {
            $this->error('请求类型错误','register');
        }
    }
}