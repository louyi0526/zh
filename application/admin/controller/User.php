<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13
 * Time: 0:13
 */

namespace app\admin\controller;

use app\admin\common\controller\Base;
use app\admin\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;
class User extends Base
{
    //登录界面
    public function login()
    {
        $this->view->assign('title','管理员登录');
        return $this->view->fetch();
    }

    public function checkLogin()
    {
        $data = Request::param();

        $map[] = ['email','=',$data['email']];
        $map[] = ['password','=',sha1($data['password'])];

        $rel =UserModel::where($map)->find();
        if ($rel)
        {
            Session::set('admin_id',$rel['id']);
            Session::set('admin_name',$rel['name']);
            Session::set('admin_level',$rel['is_admin']);
            $this->success('登录成功','user/userList');
        }
        $this->error('登录失败');
    }

    //退出登录
    public function logout()
    {
        Session::clear();
        $this->success('退出成功','user/login');
    }

    //用户列表
    public function userList()
    {
        //获取当前用户ID和级别is_admin
        $data['admin_id'] = Session::get('admin_id');
        $data['admin_level'] = Session::get('admin_level');

        //获取当前用户信息
        $userList = UserModel::where('id',$data['admin_id'])->select();

        //超级管理员

        if ($data['admin_level'] == 1){
            $userList = UserModel::select();
        }

        //模板赋值
        $this->view->assign('title','用户管理');
        $this->view->assign('empty','<span style="color:red;">没有数据</span>');
        $this->view->assign('userList',$userList);

        return  $this->view->fetch('userList');
    }

    //编辑界面
    public function userEdit()
    {
        //获取主键
        $userId = Request::param('id');
        $userInfo = UserModel::where('id',$userId)->find();//find一条记录
        $this->view->assign('title','编辑用户');
        $this->view->assign('userInfo',$userInfo);
        return  $this->view->fetch('userEdit');
    }

    //用户信息保存
    public function doEdit()
    {

        //获取用户信息
        $data = Request::post();
        if (!empty($data['password'])){
            $data['password']=sha1($data['password']);
        }else{
            unset($data['password']);
        }
//        halt($data);
        //更新信息
        if (UserModel::where('id',$data['id'])->data($data)->update()){
            return $this->success('更新成功','user/userList');
        }

        return $this->error('更新失败');
    }

    //删除用户
    public function doDelete()
    {
        $id = Request::post('id');

        if (UserModel::where('id',$id)->delete()){
            return ['status'=>1,'msg'=>'删除成功'];
        }
        return ['status'=>0,'msg'=>'删除失败'];
    }
}