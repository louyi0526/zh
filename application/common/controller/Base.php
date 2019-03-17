<?php
/**
 * 基础控制器
 * 必须继承think\Controller
 */

namespace app\common\controller;
use app\admin\common\model\Site;
use app\common\model\Article;
use think\Controller;
use think\facade\Session;
use app\common\model\ArtCate;
use think\facade\Request;

class Base extends Controller
{
    /**
     * 初始化方法
     * 创建常量,公共方法
     * 在所有的方法之前被调用
     */
    protected function initialize()
    {
        //初始化调用
        //站点是否开启
        $this->is_open();

        //导航条
        $this->showNav();

        //热门排行
        $this->getHotArt();

    }

        //重复登录
        public function logined()
        {
            if (Session::has('user_id')){
                $this->redirect('index/index',302);
            }
        }

        //是否登录
        public function isLogin()
        {
            if (!Session::has('user_id')){
                $this->redirect('user/login',302);
            }
        }

        //显示分类导航
        protected function showNav()
        {
            //闭包
            $cateList = ArtCate::all(function ($query){
                $query->where('status',1)->order('sort','asc');
            });
            $this->view->assign('cateList',$cateList);
        }

        //检测站点是否关闭
    public function is_open()
    {
        $isOpen=Site::where('status',1)->value('is_open');

        if ($isOpen==0&& Request::module() == 'index'){
            $info = '站点维护中...';
            exit($info);
        }
    }

    //检测注册是否关闭
    public function is_reg()
    {
        $isReg=Site::where('status',1)->value('is_reg');

        if ($isReg==0){
            $this->error('注册关闭','index/index');
        }
    }

    //根据阅读量PV来获取
    public function getHotArt()
    {
        $hotArtList=Article::where('status',1)
            ->order('pv','desc')
            ->limit(12)
            ->select();
        $this->view->assign('hotArtList',$hotArtList);

    }
}