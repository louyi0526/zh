<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 20:49
 */

namespace app\admin\controller;

use app\admin\common\controller\Base;
use app\admin\common\model\Cate as CateModel;
use think\facade\Request;
use think\facade\Session;
class Cate extends Base
{
    //判断是否登录
    public function index()
    {
        $this->isLogin();

        return $this->redirect('cateList');
    }

    //分类列表界面
    public function cateList()
    {
        //用户是否登录
        $this->isLogin();

        //获取分类数据
        $cateList = CateModel::all();

        //模板变量赋值
        $this->view->assign('title','分类管理');
        $this->view->assign('empty','<span style="color: red;">没有分类</span>');
        $this->view->assign('cateList',$cateList);

        //显示模板
        return $this->view->fetch('cateList');
    }

    //编辑分类界面
    public function cateEdit()
    {
        //获取分类ID
        $cateId = Request::param('id');

        //获取信息
        $cateInfo = CateModel::where('id',$cateId)->find();

        $this->view->assign('title','编辑分类');
        $this->view->assign('empty','<span style="color: red;">没有分类</span>');
        $this->view->assign('cateInfo',$cateInfo);

        return $this->view->fetch('cateEdit');

    }

    //编辑更新操作
    public function doEdit()
    {

        //获取用户信息
        $data = Request::post();

//        halt($data);

        //更新信息
        if (CateModel::where('id',$data['id'])->data($data)->update()){
            return $this->success('更新成功','cate/cateList');
        }

        return $this->error('更新失败');
    }

    //删除分类
    public function doDelete()
    {
        $id = Request::post('id');

        if (CateModel::where('id',$id)->delete()){
            return ['status'=>1,'msg'=>'删除成功'];
        }
        return ['status'=>0,'msg'=>'删除失败'];
    }

    //添加分类界面
    public function cateAdd()
    {
        return $this->view->fetch('cateAdd',['ititle'=>'添加分类']);
    }


    //新增分类操作
    public function doAdd()
    {

        //获取用户信息
        $data = Request::post();

        $rule ='app\admin\common\validate\ArtCate';//自定义的验证规则

        $res = $this->validate($data,$rule);

        if ($res !== true){

            return ['status'=> -1,'message'=>$res];
        }

//        halt($data);

        //新增
        if (CateModel::create($data)){
            return ['status'=> 1,'message'=>'新增成功'];
        }

        return ['status'=> -1,'message'=>'新增失败'];
    }

}