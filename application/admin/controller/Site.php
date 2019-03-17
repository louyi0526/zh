<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 0:04
 */

namespace app\admin\controller;

use app\admin\common\controller\Base;
use app\admin\common\model\Site as SiteModel;
use think\facade\Request;
use think\facade\Session;
class Site extends Base
{
    //站点管理页面
    public function index()
    {
        $siteInfo = SiteModel::get(['status'=>1]);

        $this->view->assign('siteInfo',$siteInfo);

        return $this->view->fetch();
    }

    //保存站点信息
    public function save()
    {
        $data = Request::post();
//halt($data);
        if (SiteModel::update($data)){
            $this->success('更新成功');
        }else {
            $this->error('更新失败');
        }
    }
}