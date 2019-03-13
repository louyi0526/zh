<?php
/**
 * 后台公共控制器
 */

namespace app\admin\common\controller;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    /**
     * 初始化方法
     */
    protected function initialize()
    {


    }

    /**
     * 用户是否登录
     * 1.调用位置:后台:admin/index/index
     */
    public function isLogin()
    {
        if (!Session::has('admin_id')){
            $this->redirect('admin/user/login',302);
        }
    }


}