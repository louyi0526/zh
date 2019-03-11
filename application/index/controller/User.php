<?php


namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

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
//            return $data['name'];
            $rule ='app\common\validate\User';//自定义的验证规则
            $res = $this->validate($data,$rule); //开始验证
            if ($res !== true){
                switch ($res){
                    case '':
                }
                return ['status'=> -1,'message'=>$res];
            }else {
                if ($user = UserModel::create($data)){

                    Session::set('user_id',$user->id);
                    Session::set('user_name',$data['name']);
                    return ['status'=> 1,'message'=>'注册成功'];
                }else {
                    return ['status'=> 0,'message'=>'注册失败'];
                }
            }

        }else {
            $this->error('请求类型错误','register');
        }
    }

    //用户登录
    public function login()
    {
        $this->logined();
        return $this->fetch('login',['title'=>'用户登录']);
    }

    //用户登录验证与查询
    public function loginCheck()
    {
        if (Request::isAjax())
        {
            //验证数据
            $data = Request::post();//获取数据
            $rule =[
                'email|邮箱'=>'require|email',
                'password|密码'=>'require|alphaNum',
            ];//自定义的验证规则

            $res = $this->validate($data,$rule); //开始验证

            if ($res !== true){
                return ['status'=> -1,'message'=>$res];
            }else {
                $result = UserModel::get(function ($query) use ($data){
                    $query->where('email',$data['email'])
                        ->where('password',sha1($data['password']));
                });
                if ($result == null){
                    return ['status'=> 0,'message'=>'邮箱或密码不正确'];
                }else {
                    Session::set('user_id',$result->id);
                    Session::set('user_name',$result->name);
                    return ['status'=> 1,'message'=>'登录成功'];
                }
            }

        }else {
            $this->error('请求类型错误','login');
        }
    }

    //用户退出登录
    public function logout()
    {
//        Session::delete('user_id');
//        Session::delete('user_name');
        Session::clear();
//        Session::destroy();//不能用在这里
//        $this->success('','index/index');
        $this->redirect('index/index',302);
    }
}