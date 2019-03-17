<?php

namespace app\admin\controller;


use app\admin\common\controller\Base;
use app\admin\common\model\Article as ArtModel;
use app\admin\common\model\Cate;
use think\facade\Request;
use think\facade\Session;

class Article extends Base
{
    //文章首页
    public function index()
    {
        $this->isLogin();

        return $this->redirect('artList');
    }

    public function artList()
    {
        $this->isLogin();

        $userId = Session::get('admin_id');
        $isAdmin = Session::get('admin_level');

//        halt($isAdmin);
        if ($isAdmin == 1){
            $artList = ArtModel::paginate(5);
        }else {
            $artList = ArtModel::where('user_id',$userId)->paginate(5);
        }



        //模板变量赋值
        $this->view->assign('title','文章管理');
        $this->view->assign('empty','<span style="color: red;">没有文章</span>');
        $this->view->assign('artList',$artList);

        return $this->view->fetch('artList');

    }

    //编辑文章界面
    public function artEdit()
    {
        //获取文章ID
        $artId = Request::param('id');

        //获取信息
        $artInfo = ArtModel::where('id',$artId)->find();

        //获取分类信息
        $cateList=Cate::all();

        $this->view->assign('title','编辑文章');
        $this->view->assign('empty','<span style="color: red;">没有文章</span>');
        $this->view->assign('artInfo',$artInfo);
        $this->view->assign('cateList',$cateList);

        return $this->view->fetch('artEdit');

    }

    public function doEdit()
    {
        $data = Request::post();

        if(!empty($_FILES['title_img']['name'])){  //文件不为空时

            //获取图片信息
            $file = Request::file('title_img');

            //文件信息验证,再上传到指定目录
            $info = $file->validate(['size'=>1000000,'ext'=>'jpg,jpeg,png,gif'])->move('uploads/');
            if ($info){
                $data['title_img'] = $info->getSaveName();
            }else {
                $this->error($file->getError());
            }
        }
        //将数据写入数据表
        if (ArtModel::update($data)){
            $this->success('更新成功','artList');
        }else {
            $this->error('更新失败');
        }

    }

    //文章删除
    public function doDelete()
    {
        $artId = Request::param('id');

        if (ArtModel::destroy($artId)){
            return ['status'=>1,'msg'=>'删除成功'];
        }
        return ['status'=>-1,'msg'=>'删除失败'];
    }

}