<?php
namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\ArtCate;
use app\common\model\Article;
use think\facade\Request;

class Index extends Base
{
    public function index()
    {
        //查询条件star
        $map=[];
        $map[]=['status','=',1];

        $keywords = Request::param('keywords');
        if (!empty($keywords))
        {
            $map[]=['title','like','%'.$keywords.'%'];
        }
        //查询条件end



        $cateId=Request::param('cate_id');//获取url上cate_id的值

        if (isset($cateId)){
            $map[] = ['cate_id','=',$cateId];

            $res = ArtCate::get($cateId);

            $artList = Article::where($map)
                ->order('create_time','desc')
                ->paginate(5);

            $this->view->assign('cateName',$res->name);
        }else {

            $this->view->assign('cateName','全部文章');
            $artList = Article::where($map)
                ->order('create_time','desc')
                ->paginate(5);
        }

        $this->view->assign('empty','<h3>没有文章</h3>');
        //分页显示
//        if (isset($cateId)){
//            $artList = Article::where('status',1)
//                ->where('cate_id',$cateId)
//                ->order('create_time','desc')
//                ->paginate(5);
//        }else {
//            $artList = Article::where('status',1)
//                ->order('create_time','desc')
//                ->paginate(5);
//        }

        $this->view->assign('artList',$artList);


        return $this->fetch();
    }

    //添加文章界面
    public function insert()
    {

        //登录才允许发布文章
        $this->isLogin();
        //设置页面标题
        $this->assign('title','文章发布');
        //栏目信息
        $cateList=ArtCate::all();
//        halt($cateList);
        if (count($cateList) > 0){
            $this->assign('cateList',$cateList);
        }else {
            $this->error('请先添加栏目','index/index');
        }
        //渲染界面
        return $this->fetch();
    }

    //保存文章
    public function save()
    {
        //判断提交类型
        if (Request::isPost())
        {
            //获取提交数据
            $data = Request::post();

            $res = $this->validate($data,'app\common\validate\Article');
            if ($res !== true){
                echo '<script>alert("'.$res.'");location.history();</script>';
            }else {
                //验证成功
                if(empty($_FILES['title_img']['name'])){  //文件是否为空
                    return '<script>alert("请选择上传图片");</script>';
                }
                //获取图片信息
                $file = Request::file('title_img');

                //文件信息验证,再上传到指定目录
                $info = $file->validate(['size'=>1000000,'ext'=>'jpg,jpeg,png,gif'])->move('uploads/');
                if ($info){
                    $data['title_img'] = $info->getSaveName();
                }else {
                    $this->error($file->getError());
                }

                //将数据写入数据表
                if (Article::create($data)){
                    $this->success('发布成功');
                }else {
                    $this->error('发布失败');
                }
            }
        }else {
            $this->error('请求类型错误');
        }
    }

    //
    public function detail()
    {

        $artId=Request::param('id');
        $art = Article::get(function ($query) use ($artId){
        $query->where('id','=',$artId)
        ->setInc('pv');//setInc自增
        });
        if (!is_null($art)){
            $this->view->assign('art',$art);
        }


        $this->view->assign('title','详情页面');
        return $this->view->fetch();

    }

}
