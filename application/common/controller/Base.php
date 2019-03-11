<?php
/**
 * 基础控制器
 * 必须继承think\Controller
 */

namespace app\common\controller;
use think\Controller;
use think\facade\Session;
use app\common\model\ArtCate;
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
        $this->showNav();
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
}