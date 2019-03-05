<?php
/**
 * 基础控制器
 * 必须继承think\Controller
 */

namespace app\common\controller;
use think\Controller;
class Base extends Controller
{
    /**
     * 初始化方法
     * 创建常量,公共方法
     * 在所有的方法之前被调用
     */
    protected function initialize()
    {

    }

}